<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{asset('layout-dist')}}/index3.html" class="brand-link">
      <img src="{{asset('layout-dist')}}/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
  
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('layout-dist')}}/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
  
      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="../widgets.html" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Home
                        <span class="right badge badge-danger">New</span>
                    </p>
                    </a>
                </li>
                @foreach ($menus as $menu)
                    @if(array_key_exists('children', $menu) && count($menu['children'])==0)
                        <li class="nav-item">
                            <a href="{{route($menu['route'])}}" class="nav-link">
                            <i class="{{$menu['icon']}}"></i>
                            <p>
                                {{$menu['name']}}
                                {{-- <span class="right badge badge-danger">New</span> --}}
                            </p>
                            </a>
                        </li>
                    @else
                    <li class="nav-item has-treeview">
                        <a href="{{route($menu['route'])}}" class="nav-link">
                            <i class="{{$menu['icon']}}"></i>
                            <p>
                                {{$menu['name']}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach ($menu['children'] as $child)
                            <li class="nav-item">
                                <a href="{{route($child['route'])}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{$child['name']}}</p>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                @endforeach
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
  <!-- /.sidebar -->
</aside>

