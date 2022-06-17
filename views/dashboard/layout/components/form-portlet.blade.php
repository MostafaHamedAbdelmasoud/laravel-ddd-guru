<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet" v-cloak>
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ $title }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ $prevUrl }}" class="btn btn-clean kt-margin-r-10">
                        <i class="la la-arrow-left"></i>
                        <span class="kt-hidden-mobile">{{ __('main.back') }}</span>
                    </a>
                    <div class="btn-group submitBtnContainer">
                        <button type="button" class="btn btn-brand" id="save_btn" {{ $vueEvents ?? '' }}>
                            <i class="la la-check"></i>
                            <span class="kt-hidden-mobile">{{ __('main.save') }}</span>
                        </button>
                        {{ $actions }}
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ $slot }}
            </div>
        </div>
        <!--end::Portlet-->
    </div>
</div>
