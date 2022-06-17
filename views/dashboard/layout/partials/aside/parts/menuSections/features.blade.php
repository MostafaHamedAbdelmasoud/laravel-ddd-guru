<li class="kt-menu__item {{ is_active('features.*', true) }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
        <i class="kt-menu__link-icon flaticon-user"></i>
        <span class="kt-menu__link-text">{{ __('main.features') }}</span>
        <i class="kt-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
        <ul class="kt-menu__subnav">
            <li class="kt-menu__item kt-menu__item--parent" aria-haspopup="true">
                <span class="kt-menu__link">
                    <span class="kt-menu__link-text">{{ __('main.features') }}</span>
                </span>
            </li>
            <li class="kt-menu__item {{ is_active('features.create') }}" aria-haspopup="true">
                <a href="{{ route(config('system.admin.name').'features.create') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                    <span class="kt-menu__link-text">{{ __('main.add') }} {{ __('main.feature') }}</span>
                </a>
            </li>
            <li class="kt-menu__item {{ is_active('features.index') }}" aria-haspopup="true">
                <a href="{{ route(config('system.admin.name').'features.index') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                    <span class="kt-menu__link-text">{{ __('main.show-all') }} {{ __('main.features') }}</span>
                </a>
            </li>
        </ul>
    </div>
</li>
