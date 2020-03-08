@extends('layouts.dashboard.app')

@section('content')
<section class="content-header">
  <h1>@lang('site.users')

  </h1>

  
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">@lang('site.edit')</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    @include('partials._errors')
    <form role="form" action="{{route('dashboard.users.update',$user->id)}}" method="post" enctype="multipart/form-data">
      @csrf
      @method('put')
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail1">@lang('site.first_name')</label>
          <input name="first_name" type="text" class="form-control" id="exampleInputEmail1"
            value="{{$user->first_name}}" placeholder="@lang('site.first_name')">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">@lang('site.last_name')</label>
          <input name="last_name" type="text" class="form-control" id="exampleInputEmail1" value="{{$user->last_name}}"
            placeholder="@lang('site.last_name')">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">@lang('site.email')</label>
          <input name="email" type="email" class="form-control" id="exampleInputEmail1" value="{{$user->email}}"
            placeholder="@lang('site.email')">
        </div>
        
        <div class="form-group">
          <label for="exampleInputFile">@lang('site.image')</label>
          <input type="file" class="form-control image" id="exampleInputFile" name="image" onchange="loadFile(event)">
        </div>

        <div class="form-group">
        <img src="{{$user->image_path}}" style="width:100px" class="img-thumbnail image-p" id="image-p" alt="">
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
                      <input type="checkbox" name="permissions[]" {{$user->hasPermission($map.'_'.$model)? 'checked':''}} value="{{$map.'_'.$model}}"> @lang('site.'.$map)
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
        <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
      </div>
    </form>
  </div><!-- /.box -->
</section>
@endsection