<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
{{--  --}}

<head>
  <meta charset="UTF-8">
  <title>@lang('site.Admin_panel')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.4 -->
  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons 2.0.0 -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 {{-- chart.js --}}
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css">
 

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/flat/blue.css') }}"> 
  <!-- Morris chart -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

  <link rel="stylesheet" href="{{ asset('dist/fonts/fonts-fa.css') }}">

  @if(app()->getLocale()=='ar')
  <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-rtl.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/rtl.css') }}">
  <style>
    .sidebar-mini.sidebar-collapse .content-wrapper,
    .sidebar-mini.sidebar-collapse .right-side,
    .sidebar-mini.sidebar-collapse .main-footer {
      margin-right: 50px !important
    }

    .notify-alert.notify-success.animated,
    .notify-alert.notify-error.animated {
      direction: ltr !important;
      right: inherit !important;
      left: 0 !important;
      margin-top: 22px !important;
    }

  </style>
  @else
  <style>
    .dir-lte-home {
    direction: rtl !important;
}

    .h-head{
      float: inline-end;
    }
    /* .main-sidebar{
        left: 0;
      }
      .content-wrapper{
        margin-right: 0!important;
        margin-left: 236px!important;
      }
      .sidebar-mini.sidebar-collapse .content-wrapper, .sidebar-mini.sidebar-collapse .right-side, .sidebar-mini.sidebar-collapse .main-footer {
      margin-left: 50px !important;
        }
      .main-footer{
        margin-right: 0;
      } */

    .main-header .navbar-custom-menu,
    .main-header .navbar-right {
      float: right;
    }

    .main-header .sidebar-toggle {
      float: left;
    }

  </style>



  @endif
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  @notifyCss

  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



<script>


$(document).ready(function(){
    $('.add-product-btn').on('click',function(){
      // e.preventDefault();
      var name=$(this).data('name');
      var id=$(this).data('id');
      var price=$(this).data('price');
      var stock=$(this).data('stock');
      $(this).removeClass('btn-success').addClass('btn-default disabled');
      
          // <input type="hidden" name="product_ids[]" value="${id}">
      var html=`<tr>
        <td>${name}</td>
        <td><input type="number" name="products[${id}][quantity]" data-price="${price}" class="form-control input-sm product-quantity" min="1" max="${stock}" value="1"></td>
        <td class="product-price" >${price}</td>
        <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>

        </tr>`;
      $('.order-list').append(html);
      calculate_total();

    });

    $('body').on('click','.disabled',function(e){
      e.preventDefault();
    });

    
    $('body').on('click','.remove-product-btn',function(e){
      
      e.preventDefault();
      var id=$(this).data('id');
      $(this).closest('tr').remove();
      $('#product-'+id).removeClass('btn-default disabled').addClass('btn-success');
      calculate_total();
    });

    $('body').on('keyup change','.product-quantity',function(){
        var quantity=parseInt($(this).val());
        var unitPrice=$(this).data('price');
        $(this).closest('tr').find('.product-price').html(quantity * unitPrice);
        
        calculate_total();
    });

    //list order products
    $('.order-products').on('click',function(e){
      
      
      e.preventDefault();
      $('#loading').css('display','block');
      $('#order-product-list').empty(); 
      var url=$(this).data('url');
      var method=$(this).data('method');
      $.ajax({
          url:url,
          method:method,
          success:function(data){
            
            $('#loading').css('display','none');
            $('#order-product-list').append(data); 
          }
      });
    });

    //print this
    $(document).on('click','.print-btn',function(){
      $('#print-area').printThis({
        pageTitle: "POS",
        header: "<h1>POS products order!</h1>",
        footer: "<h3>powered br : FaridDomat</h3>",
      });
    });

});


function calculate_total(){
  var price=0;
  $('.order-list .product-price').each(function(index){
    price+=parseInt($(this).html());
  });
  $('.total-price').html(price);
  
  if (price > 0) {
    $('#add-order-form-btn').removeClass('disabled');
  } else {
    $('#add-order-form-btn').addClass('disabled');
  }

  }


</script>


</head>

<body class="skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>@lang('site.Admin_panel')</b></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <!-- start message -->
                      <a href="#">
                        <div class="pull-right">
                          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Support Team
                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li><!-- end message -->
                    <li>
                      <a href="#">
                        <div class="pull-right">
                          <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          AdminLTE Design Team
                          <small><i class="fa fa-clock-o"></i> 2 hours</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-right">
                          <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Developers
                          <small><i class="fa fa-clock-o"></i> Today</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-right">
                          <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Sales Department
                          <small><i class="fa fa-clock-o"></i> Yesterday</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-right">
                          <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Reviewers
                          <small><i class="fa fa-clock-o"></i> 2 days</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">۱۰</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                        page and may cause design problems
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-red"></i> 5 new members joined
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-user text-red"></i> You changed your username
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
              </ul>
            </li>
            <!-- Tasks: style can be found in dropdown.less -->
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>

              </a>
              <ul class="dropdown-menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li>
                  <a rel="alternate" hreflang="{{ $localeCode }}"
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ $properties['native'] }}
                  </a>
                </li>
                @endforeach
              </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{auth()->user()->image_path}}"  class="user-image" alt=""> 
                <span class="hidden-xs">{{auth()->user()->first_name .' '. auth()->user()->last_name }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{auth()->user()->image_path}}" style="width: 50px;height: 50px;" class="img-circle" alt=""> 
                  <p>
                      {{auth()->user()->first_name .' '. auth()->user()->last_name }}
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat">@lang('site.profile')</a>
                  </div>
                  <div class="pull-left">
                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">@lang('site.logout')
                    </a>
                    

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    @include('layouts.dashboard._aside')

    <div class="content-wrapper" style="">
      <br>
      @yield('content')
    </div>
    {{--       
      @include('partials._errors') --}}

    



    <footer class="main-footer">
      <div class="pull-left hidden-xs">
        <b>Version</b> 3.0.1
      </div>
      <strong>Copyright &copy; 2019-2020<a href="#"> Fariddomat</a>.</strong> All rights
      reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
          <h3 class="control-sidebar-heading">Recent Activity</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript::;">
                <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                  <p>Will be 23 on April 24th</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript::;">
                <i class="menu-icon fa fa-user bg-yellow"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                  <p>New phone +1(800)555-1234</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript::;">
                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                  <p>nora@example.com</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript::;">
                <i class="menu-icon fa fa-file-code-o bg-green"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                  <p>Execution time 5 seconds</p>
                </div>
              </a>
            </li>
          </ul><!-- /.control-sidebar-menu -->

          <h3 class="control-sidebar-heading">Tasks Progress</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript::;">
                <h4 class="control-sidebar-subheading">
                  Custom Template Design
                  <span class="label label-danger pull-left">70%</span>
                </h4>
                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript::;">
                <h4 class="control-sidebar-subheading">
                  Update Resume
                  <span class="label label-success pull-left">95%</span>
                </h4>
                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript::;">
                <h4 class="control-sidebar-subheading">
                  Laravel Integration
                  <span class="label label-warning pull-left">50%</span>
                </h4>
                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript::;">
                <h4 class="control-sidebar-subheading">
                  Back End Framework
                  <span class="label label-primary pull-left">68%</span>
                </h4>
                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                </div>
              </a>
            </li>
          </ul><!-- /.control-sidebar-menu -->

        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <form method="post">
            <h3 class="control-sidebar-heading">General Settings</h3>
            <div class="form-group">
              <label class="control-sidebar-subheading">
                Report panel usage
                <input type="checkbox" class="pull-left" checked>
              </label>
              <p>
                Some information about this general settings option
              </p>
            </div><!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Allow mail redirect
                <input type="checkbox" class="pull-left" checked>
              </label>
              <p>
                Other sets of options are available
              </p>
            </div><!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Expose author name in posts
                <input type="checkbox" class="pull-left" checked>
              </label>
              <p>
                Allow the user to show his name in blog posts
              </p>
            </div><!-- /.form-group -->

            <h3 class="control-sidebar-heading">Chat Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Show me as online
                <input type="checkbox" class="pull-left" checked>
              </label>
            </div><!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Turn off notifications
                <input type="checkbox" class="pull-left">
              </label>
            </div><!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Delete chat history
                <a href="javascript::;" class="text-red pull-left"><i class="fa fa-trash-o"></i></a>
              </label>
            </div><!-- /.form-group -->
          </form>
        </div><!-- /.tab-pane -->
      </div>
    </aside><!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div><!-- ./wrapper -->

  <!-- jQuery 2.1.4 -->
  <script src="{{ asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.4 -->
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- Morris.js charts -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <!-- Sparkline -->
  <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
  <!-- jvectormap -->
  <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
  <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
  <!-- daterangepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- datepicker -->
  <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
  <!-- Slimscroll -->
  <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('plugins/fastclick/fastclick.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/app.min.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>


  <script src="{{ asset('dist/js/custom.js') }}"></script>

  
  <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
  {{-- chart.js --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
  

  @include('notify::messages')
    @notifyJs

    <script type="text/javascript">

      function confSubmit(form) {
      if (confirm("Are you sure you want to submit the form?")) {
      form.submit();
      }
      
      }

//image preview

var loadFile = function(event) {
    var output = document.getElementById('image-p');
    output.src = URL.createObjectURL(event.target.files[0]);
  };


  //cKeditor rtl
CKEDITOR.config.language="{{app()->getLocale()}}";



      </script>

<script src="{{ asset('dist/js/jquery.number.min.js')}}"></script>

{{-- Print This --}}
<script src="{{ asset('dist/js/printThis.js')}}"></script>
@stack('scripts')
</body>

</html>