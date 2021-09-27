<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url('public/admin') }}/dist/img/admin.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                 <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
                <a href="{{route('users.logout')}}"><i class="fas fa-sign-out-alt"></i>Đăng Xuất</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Danh Mục Blog
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('categoryBlog.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách danh mục </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categoryBlog.create') }}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <p>Thêm mới danh mục </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categoryBlog.trashed') }}" class="nav-link">
                                <i class="fas fa-trash"></i>
                                <p>Thùng rác danh mục </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Danh Mục Video
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('categoryVideo.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách danh mục Video</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categoryVideo.create') }}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <p>Thêm mới danh mục Video</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categoryVideo.trashed') }}" class="nav-link">
                                <i class="fas fa-trash nav-icon"></i>
                                <p>Thùng rác danh mục Video</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Danh Mục Sản Phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('categoryProduct.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách danh mục </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categoryProduct.create') }}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <p>Thêm mới danh mục </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categoryProduct.trashed') }}" class="nav-link">
                                <i class="fas fa-trash nav-icon"></i>
                                <p>Thùng rác danh mục </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-image"></i>
                        <p>
                            Banner
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('banner.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Banner</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('banner.create') }}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <p>Thêm mới Banner</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-blog"></i>
                        <p>
                            Blog
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('blog.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách blog</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog.create') }}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <p>Thêm mới blog</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-video"></i>
                        <p>
                            Video
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.video') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách video</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('video.create')}}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <p>Thêm mới Video</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('video.trashed')}}" class="nav-link">
                                <i class="fas fa-trash nav-icon"></i>
                                <p>Thùng rác  Video</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fab fa-atlassian"></i>
                        <p>
                            Logo
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.logo')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Chi tiết </p>
                            </a>
                        </li>
                    </ul>
                    
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-cog"></i>
                        <p>
                            Quản trị viên
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách quản trị viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.create')}}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <p>Thêm mới quản trị viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.trashed')}}" class="nav-link">
                                <i class="fas fa-trash nav-icon"></i>
                                <p>Thùng rác quản trị viên</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-cog"></i>
                        <p>
                            Tài khoản người dùng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('customer.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách tài khoản</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customer.create')}}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <p>Thêm mới tài khoản</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customer.trashed')}}" class="nav-link">
                                <i class="fas fa-trash nav-icon"></i>
                                <p>Thùng rác tài khoản</p>
                            </a>
                        </li>
                    </ul>
                </li>
            <!-- </ul> -->
            </li>
       
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fab fa-product-hunt"></i>
                    <p>
                        Sản Phẩm
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('product.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Danh sách sản phẩm</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.create') }}" class="nav-link">
                            <i class="fas fa-plus"></i>
                            <p>Thêm mới sản phẩm</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.trashed') }}" class="nav-link">
                            <i class="fas fa-trash"></i>
                            <p>Thùng rác sản phẩm</p>
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
