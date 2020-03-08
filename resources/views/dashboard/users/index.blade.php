@extends('layouts.dashboard.app')

@section('content')
    <section class="content-header">
        <h1>@lang('site.users')
            <small>it all start here </small>
        </h1>

        
    </section>

    <section class="content">
        

        <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">@lang('site.users')
                  <small>{{$users->total()}}</small>
                </h3>
                </div><!-- /.box-header -->
            <form action="{{route('dashboard.users.index')}}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">@lang('site.search')</button>
                            
                            @if (auth()->user()->hasPermission('create_users'))    
                            <a href="{{route('dashboard.users.create')}}" class="btn btn-success"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                            <a href="" class="btn btn-success disabled"> <i class="fa fa-plus"></i> @lang('site.add')</a>    
                            @endif
                            </div>
                        </div>
            
                    </form>
                <div class="box-body">
        @if ($users->count() > 0)
                  <table class="table table-bordered table-hover">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>@lang('site.first_name')</th>
                      <th>@lang('site.last_name')</th>
                      <th>@lang('site.image')</th>
                      <th >@lang('site.email')</th>
                      <th >@lang('site.action')</th>
                    </tr>
                    @foreach ($users as $index=>$user)
                    <tr>
                        <td style="padding-top: 25px;">{{$index+1}}</td>
                        <td style="padding-top: 25px;">{{$user->first_name}}</td>
                        <td style="padding-top: 25px;">{{$user->last_name}}</td>
                    <td><img src="{{$user->image_path}}" style="width: 50px;height: 50px;" class="img-thumbnail" alt=""></td>
                        <td style="padding-top: 25px;">{{$user->email}}</td>
                    <td style="padding-top: 25px;">
                            @if (auth()->user()->hasPermission('update_users'))    
                    <a class="btn btn-info" href="{{route('dashboard.users.edit',$user->id)}}">@lang('site.edit')</a>
                    @else
                    <a class="btn btn-info disabled" href="">@lang('site.edit')</a>
                    @endif
                    @if (auth()->user()->hasPermission('delete_users'))
                    <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post" style="display: inline-block">
                            @csrf
                            @method('delete')
                            <button id="delete" class="btn btn-danger delete" onclick="return confirm('.@lang('site.delete_confirm').');">@lang('site.delete')</button>
                        </form>
                    @else
                    <button type="submit" class="btn btn-danger disabled" >@lang('site.delete')</button>
                       
                    @endif
                    
                    </td>
                    </tr> 
                    @endforeach
                  </table>

                  {{$users->appends(request()->query())->links()}}
                </div><!-- /.box-body -->
                
              </div>


        @else
            <h2>@lang('site.no_data_found')</h2>
        @endif
            </section>
@endsection