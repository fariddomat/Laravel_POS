@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
  <h1>@lang('site.categories')

  </h1>

  
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title h-head">@lang('site.add')</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    @include('partials._errors')
    <form role="form" action="{{route('dashboard.categories.store')}}" method="post"  >
      @csrf
      @method('post')

      <div class="box-body">
      @foreach (config('translatable.locales') as $locale)
          <div class="form-group">
          <label for="exampleInputEmail1">@lang('site.'.$locale.'.name')</label>
          <input name="{{$locale}}[name]" type="text" class="form-control" id="exampleInputEmail1"
            value="{{old($locale.'.name')}}" placeholder="@lang('site.name')" >
        </div>
       
      @endforeach

        

        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">@lang('site.add')</button>
      </div>
    </form>
  </div><!-- /.box -->
</section>
@endsection