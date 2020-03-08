@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
  <h1>@lang('site.clients')

  </h1>

  
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">@lang('site.add')</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    @include('partials._errors')
    <form role="form" action="{{route('dashboard.clients.store')}}" method="post">
      @csrf
      @method('post')

      <div class="box-body">

        <div class="form-group">
          <label for="">@lang('site.name')</label>
          <input type="text" name="name" id="" class="form-control" value="{{old('name')}}"
            placeholder="@lang('site.name')" aria-describedby="helpId">
        </div>
        @for ($i = 0; $i < 2; $i++) 
          <div class="form-group">
          <label for="">@lang('site.phone')</label>
          <input type="text" name="phone[]" id="" class="form-control" placeholder="@lang('site.phone')"
            aria-describedby="helpId">
          </div>
      @endfor


      <div class="form-group">
        <label for="">@lang('site.address')</label>
        <textarea t name="address" id="" class="form-control" placeholder="@lang('site.address')"
          aria-describedby="helpId">{{old('address')}}</textarea>
      </div>




          </div><!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">@lang('site.add')</button>
          </div>
    </form>
  </div><!-- /.box -->
</section>
@endsection