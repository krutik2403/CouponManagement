<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <!--<li class="{{ \App\Utils::checkRoute(['dashboard::index', 'admin::index']) ? 'active': '' }}">
        <a href="{{ route('dashboard::index') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>-->
    @if (Auth::user()->can('viewList', \App\User::class))
        <!--<li class="{{ \App\Utils::checkRoute(['admin::users.index', 'admin::users.create']) ? 'active': '' }}">
            <a href="{{ route('admin::users.index') }}">
                <i class="fa fa-user-secret"></i> <span>Users</span>
            </a>
        </li>-->
        <li <?php if (in_array(Route::current()->uri(), ['admin/coupons'])) {echo 'class="active"';}?>>
            <a href="{{ url('admin/coupons') }}">
                <i class="fa fa-ticket"></i> <span>Coupon management</span>
            </a>
        </li>
    @endif
</ul>
