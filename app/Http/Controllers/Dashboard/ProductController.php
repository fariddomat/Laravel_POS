<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories=Category::all();

        $products=Product::when($request->search,function($q) use ($request){

            return $q->whereTranslationLike('name','%'.$request->search.'%');
        
            })->when($request->category_id,function($query) use ($request){

                return $query->where('category_id',$request->category_id);
            
                })->latest()->paginate(5);
        return view('dashboard.products.index',compact('categories','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('dashboard.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'category_id'=>'required',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules+=[$locale . '.name' =>  'required|unique:product_translations,name'];
            $rules+=[$locale . '.description' => 'required'];
        }

        $rules+=[
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required',
        ];
        $request->validate($rules);

        $request_data=$request->except(['image']);
        
        if($request->image){
            // resize the image to a width of 300 and constrain aspect ratio (auto height)
            
            Image::make($request->image)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/product_images/'.$request->image->hashName()));

        $request_data['image']=$request->image->hashName();

        }

        Product::create($request_data);
        notify()->success(__('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories=Category::all();
        return view('dashboard.products.edit',compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules=[
            'category_id'=>'required',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules+=[$locale . '.name' =>  ['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]];
            $rules+=[$locale . '.description' => 'required'];
        }

        $rules+=[
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required',
        ];
        $request->validate($rules);

        $request_data=$request->except(['image']);
        
        if($request->image){
            if($product->image != 'default.png'){
                Storage::disk('public_uploads')->delete('product_images/'.$product->image);
            }
            // resize the image to a width of 300 and constrain aspect ratio (auto height)
            
            Image::make($request->image)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/product_images/'.$request->image->hashName()));

        $request_data['image']=$request->image->hashName();

        }

        $product->update($request_data);
        notify()->success(__('site.edit_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        
        if($product->image != 'default.png'){
            Storage::disk('public_uploads')->delete('product_images/'.$product->image);
        }
      $product->delete();
      
      notify()->error(__('site.remove_successfully'));
      return redirect()->route('dashboard.products.index');
      
  }
    
}
