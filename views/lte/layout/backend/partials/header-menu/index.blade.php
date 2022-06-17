<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
    <button class="kt-aside-toggler kt-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item kt-menu__item--rel {{ is_active('dashboard') }}" aria-haspopup="true">
                <a href="{{ aurl('/') }}" class="kt-menu__link">
                    <span class="kt-menu__link-text">{{ __('main.dashboard') }}</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
            </li>

            @php
                $activeArray = [
                    'users.*',
					/*AddedIncludeActiveLinksHere*/
                ];
                $activeLeadsArray = [
                    'leads.*',
                    'lead_sources.*',
                ];
            @endphp

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel {{ is_active($activeArray, true) }}" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-text">Main Menu</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        @include('backend.layout.partials.header-menu.menuSections.users')
						{{--AddedIncludeSectionsHere--}}
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel {{ is_active($activeLeadsArray, true) }}" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-text">Leads</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        @include('backend.layout.partials.header-menu.menuSections.leads')
                        @include('backend.layout.partials.header-menu.menuSections.lead_sources')
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
