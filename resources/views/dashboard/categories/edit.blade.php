@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
  <h1>@lang('site.categories')

  </h1>

  
  
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">@lang('site.edit')</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    @include('partials._errors')
    <form role="form" action="{{route('dashboard.categories.update',$category->id)}}" method="post"  >
      @csrf
      @method('put')
      <div class="box-body">
        @foreach (config('translatable.locales') as $locale)
        <div class="form-group">
        <label for="exampleInputEmail1">@lang('site.'.$locale.'.name')</label>
        <input name="{{$locale}}[name]" type="text" class="form-control" id="exampleInputEmail1"
          value="{{$category->translate($locale)->name}}" placeholder="@lang('site.name')" >
      </div>
     
    @endforeach
        
       
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
      </div>
    </form>
  </div><!-- /.box -->
</section>
@endsection