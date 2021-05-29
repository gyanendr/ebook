
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-book | Library</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{url('backend')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('backend')}}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
         <a class=" btn-sm btn btn-success" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
      </li>
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{url('backend')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('backend')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ucfirst(Auth()->user()->name)}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         @auth()
         @if(Auth()->user()->role == 1)
        <li class="nav-item menu-open">
            <a href="{{url('/admin/dashboard')}}" class="nav-link {{(url()->current() == url('/admin/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/user-listing')}}" class="nav-link {{(url()->current() == url('/admin/user-listing')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Users Listing
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="{{url('/admin/book-listing')}}" class="nav-link {{(url()->current() == url('/admin/book-listing')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Book Listing
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="{{url('/admin/order-listing')}}" class="nav-link {{(url()->current() == url('/admin/order-listing')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Order Listing
              </p>
            </a>
          </li>  

          <li class="nav-item">
            <a href="{{url('/admin/category-listing')}}" class="nav-link {{(url()->current() == url('/admin/category-listing')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Category Listing
              </p>
            </a>
          </li>
         @else
        <li class="nav-item menu-open">
            <a href="{{url('/user/dashboard')}}" class="nav-link {{(url()->current() == url('/user/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard </p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="{{url('user/order-new-book')}}" class="nav-link {{(url()->current() == url('/user/order-new-book')) ? 'active' : '' }} ">
              <i class="nav-icon fas fa-book"></i>
              <p> Order New Book </p>
            </a>
          </li>
        
         @endif
        @endauth
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{date('Y')}} <a href="https://adminlte.io">E-book-library</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{url('backend')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{url('backend')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('backend')}}/dist/js/adminlte.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="{{url('backend')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{url('backend')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{url('backend')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script type="text/javascript">
  $(".table").DataTable({
      "responsive": true,
    })
</script>
</body>
</html>
