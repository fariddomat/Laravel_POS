@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
  <h1>@lang('site.users')

  </h1>

  
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">@lang('site.add')</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    @include('partials._errors')
    <form role="form" action="{{route('dashboard.users.store')}}" method="post" enctype="multipart/form-data">
      @csrf
      @method('post')
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail1">@lang('site.first_name')</label>
          <input name="first_name" type="text" class="form-control" id="exampleInputEmail1"
            value="{{old('first_name')}}" placeholder="@lang('site.first_name')">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">@lang('site.last_name')</label>
          <input name="last_name" type="text" class="form-control" id="exampleInputEmail1" value="{{old('last_name')}}"
            placeholder="@lang('site.last_name')">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">@lang('site.email')</label>
          <input name="email" type="email" class="form-control" id="exampleInputEmail1" value="{{old('email')}}"
            placeholder="@lang('site.email')">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">@lang('site.password')</label>
          <input name="password" type="password" class="form-control" id="exampleInputPassword1"
            placeholder="@lang('site.password')">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">@lang('site.password_c')</label>
          <input name="password_confirmation" type="password" class="form-control" id="exampleInputPassword1"
            placeholder="@lang('site.password_c')">
        </div>
        <div class="form-group">
          <label for="exampleInputFile">@lang('site.image')</label>
          <input type="file" class="form-control image" id="exampleInputFile" name="image" onchange="loadFile(event)" value="{{asset('uploads/user_images/default.png')}}">
        </div>

        <div class="form-group">
        <img src="{{asset('uploads/user_images/default.png')}}" style="width:100px" class="img-thumbnail image-p" id="image-p" alt="">
        </div>


        <!-- Custom Tabs -->
        <div class="form-group">
          <label for="">@lang('site.permission')</label>
          <div class="nav-tabs-custom">
            @php
                $models=['users','categories','products','clients','orders'];
                $maps=['create','read','update','delete'];
            @endphp
            <ul class="nav nav-tabs">
              @foreach ($models as $index=>$model)
                  
            <li class="{{$index==0?'active':''}}"><a href="#{{$model}}" data-toggle="tab">@lang('site.'.$model)</a></li>
              @endforeach

            </ul>
            <div class="tab-content">
              @foreach ($models as $index=>$model)
                  
              <div class="tab-pane {{$index==0?'active':''}}" id="{{$model}}">
                  <div class="checkbox">
                    @foreach ($maps as $map)
                      <label>
                      <input type="checkbox" name="permissions[]" value="{{$map.'_'.$model}}"> @lang('site.'.$map)
                      </label>
                    @endforeach
                    
                    
                  </div>
  
                </div><!-- /.tab-pane -->
              @endforeach
              

              
            </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->

        </div>


        <div class="checkbox">
          <label>
            <input type="checkbox"> Check me out
          </label>
        </div>
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">@lang('site.add')</button>
      </div>
    </form>
  </div><!-- /.box -->
</section>
@endsection