<li class="kt-menu__item {{ is_active(config('system.vendor.name').'settings.index') }}" aria-haspopup="true">
    <a href="{{ route(userType()::prefix().'settings.index') }}" class="kt-menu__link ">
        <i class="kt-menu__link-icon flaticon2-gear"></i>
        <span class="kt-menu__link-text">{{ __('main.settings') }}</span>
    </a>
</li>
