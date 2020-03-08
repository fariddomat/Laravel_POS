@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
    <h1>@lang('site.categories')
        <small>it all start here </small>
    </h1>
    
</section>

<section class="content">


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('site.categories')
                <small>{{$categories->total()}}</small>
            </h3>
        </div><!-- /.box-header -->
        <form action="{{route('dashboard.categories.index')}}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                        value="{{request()->search}}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">@lang('site.search')</button>

                    @if (auth()->user()->hasPermission('create_categories'))
                    <a href="{{route('dashboard.categories.create')}}" class="btn btn-success"> <i
                            class="fa fa-plus"></i> @lang('site.add')</a>
                    @else
                    <a href="" class="btn btn-success disabled"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                    @endif
                </div>
            </div>

        </form>
        <div class="box-body">
            @if ($categories->count() > 0)
            <table class="table table-bordered table-hover">
                <tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('site.name')</th>
                    <th>@lang('site.products_number')</th>
                    <th>@lang('site.related_products')</th>
                    <th>@lang('site.action')</th>
                </tr>
                @foreach ($categories as $index=>$category)
                <tr>
                    <td style="">{{$index+1}}</td>
                    <td style="">{{$category->name}}</td>
                    <td style="">{{$category->products->count()}}</td>
                    <td style=""><a href="{{route('dashboard.products.index',['category_id'=>$category->id])}}"
                            class="btn btn-yahoo">@lang('site.related_products')</a></td>

                    <td style="">
                        @if (auth()->user()->hasPermission('update_categories'))
                        <a class="btn btn-info"
                            href="{{route('dashboard.categories.edit',$category->id)}}">@lang('site.edit')</a>
                        @else
                        <a class="btn btn-info disabled" href="">@lang('site.edit')</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_categories'))
                        <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post"
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

            {{$categories->appends(request()->query())->links()}}
        </div><!-- /.box-body -->

    </div>


    @else
    <h2>@lang('site.no_data_found')</h2>
    @endif
</section>
@endsection