<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.pn') }}g">
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
		<link rel="manifest" href="{{ asset('/site.webmanifest') }}">
		<title>
		@yield('title') {{ config('system.title_divider', '|') . ' '. config('app.name') }}
		</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
		<link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('global_assets/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">

		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/pace.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/parsley.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/date_time_picker.css') }}" rel="stylesheet" type="text/css">
		@stack('css')

		<script>
			const BASE_URL = '{{ app_url() }}/';
			const BASE_ADMIN_URL = '{{ app_url() }}/admin/';
		</script>
	</head>
	<body @auth() class="navbar-top" @endauth>
		@auth
		<!-- Main navbar -->
		<div class="navbar navbar-expand-md navbar-dark fixed-top">
			<!-- Header with logos -->
			<div class="navbar-header navbar-dark d-none d-md-flex align-items-md-center">
				<div class="navbar-brand navbar-brand-md">
					<a href="{{ route('home') }}" class="d-inline-block">
						<img src="{{ asset('global_assets/images/logo_light.png') }}" alt="">
					</a>
				</div>
				<div class="navbar-brand navbar-brand-xs">
					<a href="{{ route('home') }}" class="d-inline-block">
						<img src="{{ asset('global_assets/images/logo_icon_light.png') }}" alt="">
					</a>
				</div>
			</div>
			<!-- /header with logos -->
			<!-- Mobile controls -->
			<div class="d-flex flex-1 d-md-none">
				<div class="navbar-brand mr-auto">
					<a href="{{ route('home') }}" class="d-inline-block">
						<img src="{{ asset('global_assets/images/logo_icon_light.png') }}" alt="">
					</a>
				</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
				</button>
				<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
				</button>
			</div>
			<!-- /mobile controls -->
			<!-- Navbar content -->
			<div class="collapse navbar-collapse" id="navbar-mobile">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
							<i class="icon-paragraph-justify3"></i>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown dropdown-user">
						<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
							<img src="{{ asset((auth()->user() and auth()->user()->image) ? auth()->user()->image : 'global_assets/images/image.png') }}" width="38" height="38" class="rounded-circle" alt="{{ auth()->user() ? auth()->user()->full_name.'\' Image' : 'User Image' }}">
							<span class="ml-1"> {{ auth()->user() ? auth()->user()->full_name : __('service.user_name') }}</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
							<a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
							<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-blue ml-auto">58</span></a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
							<a href="{{ route('logout') }}" id="logout" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
						</div>
					</li>
				</ul>
			</div>
			<!-- /navbar content -->
		</div>
		<!-- /main navbar -->
		@endauth
		<!-- Page content -->
		<div class="page-content">
			@auth()
			<!-- Main sidebar -->
			<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md sidebar-fixed">
				<!-- Sidebar mobile toggler -->
				<div class="sidebar-mobile-toggler text-center">
					<a href="#" class="sidebar-mobile-main-toggle">
						<i class="icon-arrow-left8"></i>
					</a>
					Navigation
					<a href="#" class="sidebar-mobile-expand">
						<i class="icon-screen-full"></i>
						<i class="icon-screen-normal"></i>
					</a>
				</div>
				<!-- /sidebar mobile toggler -->
				<!-- Sidebar content -->
				<div class="sidebar-content">
					<!-- User menu -->
					<div class="sidebar-user">
						<div class="card-body">
							<div class="media">
								<div class="mr-3">
									<a href="#">
										<img src="{{ asset((auth()->user() and auth()->user()->image) ? auth()->user()->image : 'global_assets/images/image.png') }}" width="38" height="38" class="rounded-circle" alt="{{ auth()->user() ? auth()->user()->full_name.'\' Image' : 'User Image' }}">
									</a>
								</div>
								<div class="media-body">
									<div class="media-title font-weight-semibold">
										{{ auth()->user() ? auth()->user()->full_name : __('service.user_name') }}
									</div>
									<div class="font-size-xs opacity-50">
										<i class="icon-mention font-size-sm"></i> &nbsp;{{ auth()->user() ? auth()->user()->email : __('service.user_name') }}
									</div>
								</div>
								{{-- <div class="ml-3 align-self-center">
									<a href="#" class="text-white"><i class="icon-cog3"></i></a>
								</div> --}}
							</div>
						</div>
					</div>
					<!-- /user menu -->
					<!-- Main navigation -->
					@includeIf('_partials.main_navigation')
					<!-- /main navigation -->
				</div>
				<!-- /sidebar content -->
			</div>
			<!-- /main sidebar -->
			@endauth
			<!-- Main content -->
			<div class="content-wrapper">
				@auth()
				 <!-- Add currency related field-->
                <input type="hidden" id="__code" value="{{session('currency')['code']}}">
                <input type="hidden" id="__symbol" value="{{session('currency')['symbol']}}">
                <input type="hidden" id="__thousand" value="{{session('currency')['thousand_separator']}}">
                <input type="hidden" id="__decimal" value="{{session('currency')['decimal_separator']}}">
                <input type="hidden" id="__symbol_placement" value="{{session('business.currency_symbol_placement')}}">
                <input type="hidden" id="__precision" value="{{config('constants.currency_precision', 2)}}">
                <input type="hidden" id="__quantity_precision" value="{{config('constants.quantity_precision', 2)}}">
                <!-- End of currency related field-->
                @endauth
				@auth()
				<!-- Page header -->
				@section('page_header')
				@show
				<!-- /page header -->
				@endauth
				<!-- Content area -->
				@section('content')
				@show
				<!-- /content area -->
				<!-- Footer -->
				<div class="navbar navbar-expand-lg navbar-light">
					<div class="text-center d-lg-none w-100">
						<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
						</button>
					</div>
					<div class="navbar-collapse collapse" id="navbar-footer">
						<span class="navbar-text">
							{!! config('satt.footer_credit') !!}
						</span>
						<ul class="navbar-nav ml-lg-auto">
							<li class="nav-item">
								<a href="#" class="navbar-nav-link font-weight-semibold">
									<span class="text-pink-400">
										<i class="icon-cart2 mr-2"></i>
										Purchase
									</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- /footer -->
			</div>
			<!-- /main content -->
		</div>
		<!-- Page content -->
		@if (gv($data['attribute'], 'modal') and in_array($data['attribute']['modal'], ATTR['modal']))
		<!-- Modal content -->
		<div id="content_modal" class="modal fade border-success" tabindex="-1"  data-backdrop="static">
			<div class="modal-dialog modal-{{ $data['attribute']['modal'] }} modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header bg-light border-success-300 text-success-800 border-bottom-success alpha-success">
						<h5 class="modal-title">
						@if(gv($data, 'icon'))
						<i class="{{ $data['icon'] }} mr-2"></i>
						@endif
						{{gv($data, 'page_title', __('page.home'))}}
						</h5>
						<button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
					</div>
					<div id="modal-loader" style="display: none; text-align: center;"> <img src="{{ asset('ajaxloader.gif') }}" width="400px"> </div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
		<!-- Modal content -->
		@endif

		 <audio id="success-audio">
              <source src="{{ asset('/audio/success.ogg') }}" type="audio/ogg">
              <source src="{{ asset('/audio/success.mp3') }}" type="audio/mpeg">
            </audio>
            <audio id="error-audio">
              <source src="{{ asset('/audio/error.ogg') }}" type="audio/ogg">
              <source src="{{ asset('/audio/error.mp3') }}" type="audio/mpeg">
            </audio>
            <audio id="warning-audio">
              <source src="{{ asset('/audio/warning.ogg') }}" type="audio/ogg">
              <source src="{{ asset('/audio/warning.mp3') }}" type="audio/mpeg">
            </audio>
		<!-- Core JS files -->
		<script src="{{ asset('messages.js') }}"></script>
		<script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/loaders/pace.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/notifications/pnotify.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/notifications/noty.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/ui/perfect_scrollbar.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/forms/styling/switch.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
		<script src="{{ asset('js/layout_fixed_sidebar_custom.js') }}"></script>
		<script src="{{ asset('js/parsley.js') }}"></script>
		<script src="{{ asset('js/date_time_picker.js') }}"></script>
		<script src="{{ asset('js/accounting.js') }}"></script>
		<script src="{{ asset('js/function.js') }}"></script>
		<script src="{{ asset('js/printthis.js') }}"></script>
		@if (ANIMATE)
		<script src="{{ asset('global_assets/js/plugins/velocity/velocity.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/velocity/velocity.ui.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/ui/prism.min.js') }}"></script>
		<script src="{{ asset('js/animations.js') }}"></script>

		@endif
		<!-- /core JS files -->
		@if (gv($data['attribute'], 'list'))
		<script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/fixed_header.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/responsive.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/select.min.js') }}"></script>
		<script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
		@endif
		@if (gv($data['attribute'], 'form'))
		<script src="{{ asset('js/form.js') }}"></script>
		@endif
		<script src="{{ asset('assets/js/app.js') }}"></script>
		<!-- Theme JS files -->
		<script src="{{ asset('js/main.js') }}"></script>
		@stack('js')
	</body>
</html>