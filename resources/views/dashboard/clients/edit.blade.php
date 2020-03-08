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
    <form role="form" action="{{route('dashboard.clients.update',$client->id)}}" method="post">
      @csrf
      @method('put')

      <div class="box-body">

        <div class="form-group">
          <label for="">@lang('site.name')</label>
          <input type="text" name="name" id="" class="form-control" value="{{$client->name}}"
            placeholder="@lang('site.name')" aria-describedby="helpId">
        </div>
        @for ($i = 0; $i < 2; $i++) 
          <div class="form-group">
          <label for="">@lang('site.phone')</label>
          <input type="text" name="phone[]" id="" class="form-control" placeholder="@lang('site.phone')"
          aria-describedby="helpId" value="{{$client->phone[$i]??''}}">
          </div>
      @endfor


      <div class="form-group">
        <label for="">@lang('site.address')</label>
        <textarea t name="address" id="" class="form-control" placeholder="@lang('site.address')"
          aria-describedby="helpId">{{$client->address}}</textarea>
      </div>




          </div><!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
          </div>
    </form>
  </div><!-- /.box -->
</section>
@endsection