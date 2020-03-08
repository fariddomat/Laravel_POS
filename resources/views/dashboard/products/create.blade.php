@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
  <h1>@lang('site.products')

  </h1>

  
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">@lang('site.add')</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    @include('partials._errors')
    <form role="form" action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data">
      @csrf
      @method('post')

      <div class="form-group">
        <label for="">@lang('site.categories')</label>
        <select name="category_id" class="form-control" id="">
        <option value="">@lang('site.all_categories')</option>
        @foreach ($categories as $category)
      <option value="{{$category->id}}" {{old('category_id')==$category->id ? 'selected' :''}}>{{$category->name}}</option>
        @endforeach
      </select>
      </div>

      <div class="box-body">
        @foreach (config('translatable.locales') as $locale)
        <div class="form-group">
          <label for="exampleInputEmail1">@lang('site.'.$locale.'.name')</label>
          <input name="{{$locale}}[name]" type="text" class="form-control" id="exampleInputEmail1"
            value="{{old($locale.'.name')}}" placeholder="@lang('site.name')">
        </div>
        <div class="form-group"> 
          <label for="exampleInputEmail1">@lang('site.'.$locale.'.description')</label>
          <textarea name="{{$locale}}[description]"  class="form-control ckeditor" id="exampleInputEmail1"
            placeholder="@lang('site.description')">{{old($locale.'.description')}}</textarea>
        </div>
        

        @endforeach

        <div class="form-group">
          <label for="exampleInputFile">@lang('site.image')</label>
          <input type="file" class="form-control image" id="exampleInputFile" name="image" onchange="loadFile(event)" value="{{asset('uploads/product_images/default.png')}}">
        </div>

        <div class="form-group">
        <img src="{{asset('uploads/product_images/default.png')}}" style="width:100px" class="img-thumbnail image-p" id="image-p" alt="">
        </div>

        <div class="form-group">
          <label for="">@lang('site.purchase_price')</label>
          <input type="number" name="purchase_price" id="" class="form-control" placeholder="@lang('site.purchase_price')" aria-describedby="helpId" value="{{old('purchase_price')}}">
        </div>

        <div class="form-group">
          <label for="">@lang('site.sale_price')</label>
          <input type="number" name="sale_price" id="" class="form-control" placeholder="@lang('site.sale_price')" aria-describedby="helpId" value="{{old('sale_price')}}">
        </div>
        <div class="form-group">
          <label for="">@lang('site.stock')</label>
          <input type="text" name="stock" id="" class="form-control" placeholder="@lang('site.stock')" aria-describedby="helpId" value="{{old('stock')}}">
        </div>
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">@lang('site.add')</button>
      </div>
    </form>
  </div><!-- /.box -->
</section>
@endsection