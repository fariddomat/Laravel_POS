@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
    <h1>@lang('site.clients')
        <small>it all start here </small>
    </h1>
    
</section>

<section class="content">


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('site.clients')
                <small>{{$clients->total()}}</small>
            </h3>
        </div><!-- /.box-header -->
        <form action="{{route('dashboard.clients.index')}}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                        value="{{request()->search}}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">@lang('site.search')</button>

                    @if (auth()->user()->hasPermission('create_clients'))
                    <a href="{{route('dashboard.clients.create')}}" class="btn btn-success"> <i
                            class="fa fa-plus"></i> @lang('site.add')</a>
                    @else
                    <a href="" class="btn btn-success disabled"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                    @endif
                </div>
            </div>

        </form>
        <div class="box-body">
            @if ($clients->count() > 0)
            <table class="table table-bordered table-hover">
                <tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('site.name')</th>
                    <th>@lang('site.phone')</th>
                    <th>@lang('site.address')</th>
                    <th>@lang('site.add_order')</th>
                    <th>@lang('site.action')</th>
                </tr>
                @foreach ($clients as $index=>$client)
                <tr>
                    <td style="">{{$index+1}}</td>
                    <td style="">{{$client->name}}</td>
                    <td style="">{{is_array($client->phone)?implode($client->phone,'-'):$client->phone}}</td>
                    <td style="">{{$client->address}}</td>
                <td style="">
                @if (auth()->user()->hasPermission('create_orders'))
                <a href="{{route('dashboard.clients.orders.create',$client->id)}}" class="btn btn-yahoo">@lang('site.add_order')</a>
                @else
                <a href=""  class="btn btn-yahoo disabled">@lang('site.add_order')</a>
                @endif
                </td>
                    
                    <td style="">
                        @if (auth()->user()->hasPermission('update_clients'))
                        <a class="btn btn-info"
                            href="{{route('dashboard.clients.edit',$client->id)}}">@lang('site.edit')</a>
                        @else
                        <a class="btn btn-info disabled" href="">@lang('site.edit')</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_clients'))
                        <form action="{{route('dashboard.clients.destroy',$client->id)}}" method="post"
                            style="display: inline-block">
                            @csrf
                            @method('delete')
                            <button id="delete" class="btn btn-danger delete"
                                onclick="return confirm('.@lang('site.delete_confirm').');">@lang('site.delete')</button>
                        </form>
                        @else
                        <button type="submit" class="btn btn-danger disabled">@lang('site.delete')</button>

                        @endif

                    </td>
                </tr>
                @endforeach
            </table>

            {{$clients->appends(request()->query())->links()}}
        </div><!-- /.box-body -->

    </div>


    @else
    <h2>@lang('site.no_data_found')</h2>
    @endif
</section>
@endsection