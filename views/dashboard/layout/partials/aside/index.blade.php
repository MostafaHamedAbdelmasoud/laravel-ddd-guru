<!-- Uncomment this to display the close button of the panel-->
{{-- <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button> --}}

<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside -->
    @include('backend.layout.partials.aside.parts.brand')
    <!-- end:: Aside -->

    <!-- begin:: Aside Menu -->
    @include('backend.layout.partials.aside.parts.menu')
    <!-- end:: Aside Menu -->
</div>
