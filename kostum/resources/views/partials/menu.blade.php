<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}{{ request()->is("admin/profiles*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('profile_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.profiles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/profiles") || request()->is("admin/profiles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-id-card c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.profile.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('management_kostum_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/categories*") ? "c-show" : "" }} {{ request()->is("admin/kostums*") ? "c-show" : "" }} {{ request()->is("admin/productschedules*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-medkit c-sidebar-nav-icon">

                    </i>
                    {{ trans('Management Kostum') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-prescription-bottle c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.categories.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('kostum_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.kostums.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/kostums") || request()->is("admin/kostums/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-prescription-bottle c-sidebar-nav-icon">

                                </i>
                                {{ trans('Kostum') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('productschedule_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.product-schedules.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/productschedules") || request()->is("admin/productschedules/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-prescription-bottle c-sidebar-nav-icon">

                                </i>
                                {{ trans('productschedule') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('management_order_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/orders*") ? "c-show" : "" }} {{ request()->is("admin/order-items*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-clipboard-list c-sidebar-nav-icon">

                    </i>
                    {{ trans('Management Order') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('order_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-shopping-cart c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.order.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('order_item_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.order-items.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-shopping-cart c-sidebar-nav-icon">

                                </i>
                                {{ trans('Order Item') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('management_history_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/pengembalians*") ? "c-show" : "" }} {{ request()->is("admin/history_orders*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-truck c-sidebar-nav-icon">

                    </i>
                    {{ trans('Management History') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('pengembalian_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pengembalians.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pengembalians") || request()->is("admin/pengembalians/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-id-badge c-sidebar-nav-icon">

                                </i>
                                {{ trans('Pengembalian') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('history_order_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.history-orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/history_orders") || request()->is("admin/history_orders/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-id-badge c-sidebar-nav-icon">

                                </i>
                                {{ trans('History Order') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>