<!DOCTYPE html>

<html lang="{{ GetLanguage() }}">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>{{ $title }}</title>
		<meta name="description" content="No subheader example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="supported-languages" content="{{ json_encode(AppLanguages()) }}">
        <meta name="uploade-route" content="{{ route('api.images.store') }}">

		<!--begin::Fonts -->
		<script src="{{ asset("backend/dist/assets/css/pages/wizard/wizard-4.css") }}" type="text/javascript"></script>
		<link href="https://keenthemes.com/metronic/themes/metronic/theme/default/demo1/dist/assets/css/pages/wizard/wizard-4.css" rel="stylesheet" type="text/css" />

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
		<!--end::Fonts -->
		<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
		<!--begin::Page Vendors Styles(used by this page) -->
		@yield('styles')
		<!--end::Page Vendors Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="{{ asset('backend/dist/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backend/dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/introjs.min.css" integrity="sha256-/oZ7h/Jkj6AfibN/zTWrCoba0L+QhP9Tf/ZSgyZJCnY=" crossorigin="anonymous" />
		<!--begin::Layout Skins(used by all pages) -->
		<link href="{{ asset('backend/dist/assets/css/pages/invoices/invoice-1.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backend/dist/assets/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backend/dist/assets/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backend/dist/assets/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backend/dist/assets/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />

		<!--end::Layout Skins -->
		<link rel="stylesheet" href="https://unpkg.com/vue-form-wizard/dist/vue-form-wizard.min.css">

		<style media="screen">
			.required::after { content:"*"; color: #f4516c; }

			[v-cloak] { display:none; }

			.markElement{
				position: relative;
				background: white;
				z-index:15007
			}
		</style>

		<link rel="shortcut icon" href="{{ showImage(attribute('site_icon')) }}" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">
    <div class="overlay d-none invisible" style="
		position: absolute;
		top: 0;
		width: 100%;
		height: 100vw;
		background: #000000c9;
		z-index: 156"></div>
		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
			<div class="kt-header-mobile__logo">
				<a href="{{route(userType()::prefix().'dashboard')}}">
					<img style="display:none" alt="Logo" src="" />
				</a>
			</div>
			<div class="kt-header-mobile__toolbar">
				<button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
				<button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
				<button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
			</div>
		</div>

		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

				<!-- begin:: Aside -->
				@include('backend.layout.partials.aside.index')
				<!-- end:: Aside -->

				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
					<!-- begin:: Header -->
					<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

						<!-- begin:: Header Menu -->
						@include('backend.layout.partials.header-menu.index')
						<!-- end:: Header Menu -->

						<!-- begin:: Header Topbar -->
                        @include('backend.layout.partials.header-topbar.index')
						<!-- end:: Header Topbar -->
					</div>
					<!-- end:: Header -->

					<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

						<!-- begin:: Subheader -->
						@yield('sub_header')
						<!-- end:: Subheader -->

						<!-- begin:: Content -->
						<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            @yield("content")
						</div>
						<!-- end:: Content -->
					</div>

					<!-- begin:: Footer -->
					@include('backend.layout.partials.footer.index')
					<!-- end:: Footer -->
				</div>
			</div>
		</div>
		<!-- end:: Page -->

		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>

		<!-- end::Scrolltop -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
		<script src="{{ asset('backend/dist/assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backend/dist/assets/js/scripts.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backend/shared/js/vue.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backend/shared/js/helpers.js') }}" type="text/javascript"></script>

		<script src="{{ asset("backend/dist/assets/plugins/custom/datatables/datatables.bundle.js") }}" type="text/javascript"></script>
		<script src="https://unpkg.com/vue-form-wizard/dist/vue-form-wizard.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/intro.min.js"></script>
		<script src="{{ asset("backend/dist/assets/js/pages/custom/wizard/wizard-4.js") }}" type="text/javascript"></script>

		<!--begin::Page Vendors(used by this page) -->
		@yield('js_vendors')
		<!--end::Page Vendors -->

		<!--begin::Page Scripts(used by this page) -->
		@yield('js_scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
        <script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>
