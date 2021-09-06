<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset ('images/admin_images/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">A Commerce</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}" class="img-circle elevation-2 h-100"alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ ucwords(Auth::guard('admin')->user()->name) }}</a>
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
                <!-- Add icons to the links using the .nav-icon classwith font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard')}}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/settings','admin/update-admin-details') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Settings Admin
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/settings')}}" class="nav-link {{ Request::is('admin/settings') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Update Admin Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/update-admin-details')}}" class="nav-link {{ Request::is('admin/update-admin-details') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Update Admin Details</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Request::is('admin/sections','admin/categories', 'admin/add-edit-category', 'admin/add-edit-category/*', 'admin/products', 'admin/add-edit-product/*', 'admin/brands', 'admin/add-edit-brand' ,'admin/add-edit-brand/*', 'admin/coupons') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-swatchbook nav-icon"></i>
                        <p>
                            Catalogues
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/sections')}}" class="nav-link {{ Request::is('admin/sections') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sections</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/brands')}}" class="nav-link {{ Request::is('admin/brands', 'admin/add-edit-brand/*', 'admin/add-edit-brand') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/categories')}}" class="nav-link {{ Request::is('admin/categories' , 'admin/add-edit-category/*', 'add-edit-category/{$id}') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/products')}}" class="nav-link {{ Request::is('admin/products' , 'admin/add-edit-product/*', 'add-edit-product/{$id}') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/coupons')}}" class="nav-link {{ Request::is('admin/coupons' , 'admin/add-edit-product/*', 'add-edit-product/{$id}') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Coupons</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Request::is('admin/banners') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tv"></i>
                        <p>
                            Front Area
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/banners')}}" class="nav-link {{ Request::is('admin/banners') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Image Banners</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
