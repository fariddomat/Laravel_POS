<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-right image">
              <img src="{{auth()->user()->image_path}}" class="user-image img-circle" alt=""> </div>
            <div class="pull-left info">
              <p>@lang('site.panel_title') </p>
              <a href="#"><i class="fa fa-circle text-success"></i> @lang('site.online')</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="@lang('site.search')">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">@lang('site.section')</li>
            <li class="active treeview">
            <a href="{{route('dashboard.welcome')}}">
                <i class="fa fa-dashboard"></i> <span>@lang('site.dashboard')</span> <i class=""></i>
              </a> 
            </li>
            
            @if (auth()->user()->hasPermission('read_categories'))
            <li class="active treeview">
                <a href="{{route('dashboard.categories.index')}}">
                    <i class="fa fa-th"></i> <span>@lang('site.categories')</span> <i class=""></i>
                  </a> 
                </li>
            @endif
            @if (auth()->user()->hasPermission('read_products'))
            <li class="active treeview">
                <a href="{{route('dashboard.products.index')}}">
                    <i class="fa fa-th"></i> <span>@lang('site.products')</span> <i class=""></i>
                  </a> 
                </li>
            @endif
            @if (auth()->user()->hasPermission('read_clients'))
            <li class="active treeview">
                <a href="{{route('dashboard.clients.index')}}">
                    <i class="fa fa-th"></i> <span>@lang('site.clients')</span> <i class=""></i>
                  </a> 
                </li>
            @endif
            
            @if (auth()->user()->hasPermission('read_orders'))
            <li class="active treeview">
                <a href="{{route('dashboard.orders.index')}}">
                    <i class="fa fa-th"></i> <span>@lang('site.orders')</span> <i class=""></i>
                  </a> 
                </li>
            @endif
            @if (auth()->user()->hasPermission('read_users'))
            <li class="active treeview">
                <a href="{{route('dashboard.users.index')}}">
                    <i class="fa fa-th"></i> <span>@lang('site.users')</span> <i class=""></i>
                  </a> 
                </li>
            @endif
            
            
            
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
