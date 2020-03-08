@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
    <h1>@lang('site.products')
        <small>it all start here </small>
    </h1>

    
</section>

<section class="content">


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('site.products')
                <small>{{$products->total()}}</small>
            </h3>
        </div><!-- /.box-header -->
        <form action="{{route('dashboard.products.index')}}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                        value="{{request()->search}}">
                </div>

                <div class="col-md-4">
                    <select name="category_id" class="form-control">
                        <option value="">@lang('site.all_categories')</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{request()->category_id==$category->id ? 'selected':''}}>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">@lang('site.search')</button>

                    @if (auth()->user()->hasPermission('create_products'))
                    <a href="{{route('dashboard.products.create')}}" class="btn btn-success"> <i class="fa fa-plus"></i>
                        @lang('site.add')</a>
                    @else
                    <a href="" class="btn btn-success disabled"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                    @endif
                </div>
            </div>

        </form>
        <div class="box-body">
            @if ($products->count() > 0)
            <table class="table table-bordered table-hover">
                <tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('site.name')</th>
                    <th>@lang('site.description')</th>
                    <th>@lang('site.category')</th>
                    <th>@lang('site.image')</th>
                    <th>@lang('site.purchase_price')</th>
                    <th>@lang('site.sale_price')</th>
                    <th>@lang('site.profit_percent') %</th>
                    <th>@lang('site.stock')</th>
                    <th>@lang('site.action')</th>
                </tr>
                @foreach ($products as $index=>$product)
                <tr>
                    <td style="">{{$index+1}}</td>
                    <td style="">{{$product->name}}</td>
                    <td style="">{!!$product->description!!}</td>
                    <td style="">{{$product->category->name}}</td>
                    <td style=""><img src="{{$product->image_path}}" style="width: 50px;height: 50px"
                            class="img-thumbnail" alt=""></td>
                    <td style="">{{$product->purchase_price}}</td>
                    <td style="">{{$product->sale_price}}</td>
                    <td style="">{{$product->profit_percent}} %</td>
                    <td style="">{{$product->stock}}</td>

                    <td style="">
                        @if (auth()->user()->hasPermission('update_products'))
                        <a class="btn btn-info"
                            href="{{route('dashboard.products.edit',$product->id)}}">@lang('site.edit')</a>
                        @else
                        <a class="btn btn-info disabled" href="">@lang('site.edit')</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_products'))
                        <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post"
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

            {{$products->appends(request()->query())->links()}}
        </div><!-- /.box-body -->

    </div>


    @else
    <h2>@lang('site.no_data_found')</h2>
    @endif
</section>
@endsection