@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
  <h1>@lang('site.add_order')

  </h1>
  
</section>

<section class="content row">
  <div class="box box-primary col-md-6">
    <div class="box-header with-border">
      <h3 class="box-title">@lang('site.sections')</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    @include('partials._errors')
    <div class="box-body">
      @foreach ($categories as $category)
          <div class="panel-group">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#{{str_replace(' ','-',$category->name)}}">{{$category->name}}</a>
                </h4>
              </div>

            <div id="{{str_replace(' ','-',$category->name)}}" class="panel-collapse collapse">
              <div class="panel-body">
                @if ($category->products->count()>0)
                    <table class="table table-hover">
                      <tr>
                        <th>@lang('site.name')</th>
                        <th>@lang('site.stock')</th>
                        <th>@lang('site.price')</th>
                        <th>@lang('site.add')</th>
                      </tr>
                      @foreach ($category->products as $product)
                          <tr>
                          <td>{{$product->name}}</td>
                          <td>{{$product->stock}}</td>
                          <td>{{$product->sale_price}}</td>
                          <td>
                          <a   id="product-{{$product->id}}" data-name="{{$product->name}}"
                          data-id="{{$product->id}}" data-price="{{$product->sale_price}}" data-stock="{{$product->stock}}"
                          class="btn  btn-sm add-product-btn {{$product->stock==0 ?'disabled btn-default': 'btn-success'}}" ><i class="fa fa-plus"></i></a>
                          </td>
                          </tr>
                      @endforeach
                    </table>
                    @else
                    <h5>@lang('site.no_data_found')</h5>
                @endif

              </div>
              </div>

            </div>

          </div>
      @endforeach

    </div>
     
  </div><!-- /.box -->
  <div class="box box-primary col-md-5 col-md-offset-1">
    <div class="box-header with-border">
      <h3 class="box-title">@lang('site.orders')</h3>
    </div><!-- /.box-header -->
    <!-- form start -->


    
    <div class="box-body">
    <form action="{{route('dashboard.clients.orders.store',$client->id)}}" method="POST">
      @csrf
      @method('post')
      @include('partials._errors')
      <table class="table order-list">
        <thead>
          <tr>
            <th>@lang('site.product')</th>
            <th>@lang('site.quantity')</th>
            <th>@lang('site.price')</th>
          </tr>
        </thead>
        <tbody>
          
          
        </tbody>
      </table>
      <p>@lang('site.total') : <span class="total-price" >0</span></p>
      <button id="add-order-form-btn" type="submit" class="btn btn-primary form-control disabled">@lang('site.add_order')</button>
    </form>
    </div>
     
  </div><!-- /.box -->
</section>
@endsection