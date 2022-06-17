<li class="kt-menu__item {{ is_active($prefix.'coupons.*', true) }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
        <i class="kt-menu__link-icon flaticon2-gift-1"></i>
        <span class="kt-menu__link-text">{{ __('main.coupons') }}</span>
        <i class="kt-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
        <ul class="kt-menu__subnav">
            <li class="kt-menu__item kt-menu__item--parent" aria-haspopup="true">
                <span class="kt-menu__link">
                    <span class="kt-menu__link-text">{{ __('main.coupons') }}</span>
                </span>
            </li>
            <li class="kt-menu__item {{ is_active($prefix.'coupons.create') }}" aria-haspopup="true">
                <a href="{{ route($prefix.'coupons.create') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                    <span class="kt-menu__link-text">{{ __('main.add') }} {{ __('main.coupon') }}</span>
                </a>
            </li>
            <li class="kt-menu__item {{ is_active($prefix.'coupons.index') }}" aria-haspopup="true">
                <a href="{{ route($prefix.'coupons.index') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                    <span class="kt-menu__link-text">{{ __('main.show-all') }} {{ __('main.coupons') }}</span>
                </a>
            </li>
        </ul>
    </div>
</li>