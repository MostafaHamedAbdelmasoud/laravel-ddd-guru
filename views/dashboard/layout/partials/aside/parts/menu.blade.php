<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item {{ is_active(userType()::prefix().'dashboard') }}" aria-haspopup="true">
                <a href="{{ route(userType()::prefix().'dashboard') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-poll-symbol"></i>
                    <span class="kt-menu__link-text">{{ __('main.dashboard') }}</span>
                </a>
            </li>
            @admin
                <li class="kt-menu__section">
                    <h4 class="kt-menu__section-text">Group 1</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                @include('backend.layout.partials.aside.parts.menuSections.users')
                @include('backend.layout.partials.aside.parts.menuSections.owner_clubs')
                @include('backend.layout.partials.aside.parts.menuSections.partners')
                @include('backend.layout.partials.aside.parts.menuSections.complains')

            <li class="kt-menu__section">
                <h4 class="kt-menu__section-text">Manage Products</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            @include('backend.layout.partials.aside.parts.menuSections.products',['prefix'=>userType()::prefix()])
            @endadmin
            @admin
            @include('backend.layout.partials.aside.parts.menuSections.discounts',['prefix'=>userType()::prefix()])
            @include('backend.layout.partials.aside.parts.menuSections.coupons',['prefix'=>userType()::prefix()])
            @endadmin
            @admin
            <li class="kt-menu__section">
                <h4 class="kt-menu__section-text">Orders</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

            @include('backend.layout.partials.aside.parts.menuSections.orders',['prefix'=>userType()::prefix()])
            {{--
                @include('backend.layout.partials.aside.parts.menuSections.invoice')
                @include('backend.layout.partials.aside.parts.menuSections.finance',['prefix'=>userType()::prefix()])
            --}}
            @endadmin

            @admin
                <li class="kt-menu__section">
                    <h4 class="kt-menu__section-text">Group 4</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                @include('backend.layout.partials.aside.parts.menuSections.engines')
                @include('backend.layout.partials.aside.parts.menuSections.categories')
                @include('backend.layout.partials.aside.parts.menuSections.product_makes')
                @include('backend.layout.partials.aside.parts.menuSections.product_models')
                @include('backend.layout.partials.aside.parts.menuSections.complain_types')

                <li class="kt-menu__section">
                    <h4 class="kt-menu__section-text">Service Centers</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                @include('backend.layout.partials.aside.parts.menuSections.services')
                @include('backend.layout.partials.aside.parts.menuSections.service_centers')

                <li class="kt-menu__section">
                    <h4 class="kt-menu__section-text">Settings</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                @include('backend.layout.partials.aside.parts.menuSections.applications')
                @include('backend.layout.partials.aside.parts.menuSections.branches')
                @include('backend.layout.partials.aside.parts.menuSections.translation')
                @include('backend.layout.partials.aside.parts.menuSections.features')
                <li class="kt-menu__section">
                    <h4 class="kt-menu__section-text">Template</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                @include('backend.layout.partials.aside.parts.menuSections.attributes',['prefix'=>userType()::prefix()])
                @include('backend.layout.partials.aside.parts.menuSections.templates',['prefix'=>userType()::prefix()])
                @include('backend.layout.partials.aside.parts.menuSections.currencies')
                @include('backend.layout.partials.aside.parts.menuSections.currency_conversions')
            @endadmin
            @vendor
            <li class="kt-menu__section">
                <h4 class="kt-menu__section-text">Manage Vendor Products</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @include('backend.layout.partials.aside.parts.menuSections.manage_vendor_products',['prefix'=>userType()::prefix()])
            @endvendor
            @vendor
            <li class="kt-menu__section">
                <h4 class="kt-menu__section-text">Manage Vendor Orders</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @include('backend.layout.partials.aside.parts.menuSections.manage_vendor_orders',['prefix'=>userType()::prefix()])
            {{--
                @include('backend.layout.partials.aside.parts.menuSections.transactions',['prefix'=>userType()::prefix()])
            --}}
            @endvendor

            <li class="kt-menu__section">
                <h4 class="kt-menu__section-text">Settings</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @include('backend.layout.partials.aside.parts.menuSections.vendor')
            @admin
                @include('backend.layout.partials.aside.parts.menuSections.sliders')
            @endadmin
             @if(Auth::user()->type ==userType()::admin)
                <li class="kt-menu__section">
                    <h4 class="kt-menu__section-text">Contacts</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                @include('backend.layout.partials.aside.parts.menuSections.requests')

                @include('backend.layout.partials.aside.parts.menuSections.sms')
            @endif


            {{-- AddedIncludeSectionsHere --}}

        </ul>
    </div>
</div>
