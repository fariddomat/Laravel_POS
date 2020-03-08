<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients=Client::when($request->search,function($q) use ($request){

            return $q->where('name','like','%'.$request->search.'%')
                    ->orWhere('phone','like','%'.$request->search.'%')
                    ->orWhere('address','like','%'.$request->search.'%');
        
    })->latest()->paginate(5);
        
        return view('dashboard.clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'phone' =>'required|array|min:1',
            'phone.0' =>'required',
            'address' =>'required',
        ]);
        $request_date=$request->all();
        $request_date['phone']=array_filter($request->phone);

        Client::create($request_date);
        notify()->success(__('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        
        return view('dashboard.clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' =>'required',
            'phone' =>'required|array|min:1',
            'phone.0' =>'required',
            'address' =>'required',
        ]);
        $request_date=$request->all();
        $request_date['phone']=array_filter($request->phone);

        $client->update($request_date);
        
        notify()->success(__('site.edit_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        
        notify()->error(__('site.remove_successfully'));
        return redirect()->route('dashboard.clients.index');
    }
}
