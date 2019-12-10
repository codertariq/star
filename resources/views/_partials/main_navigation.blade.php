{{-- {{ dd(gv($data, 'page_index')) }} --}}
<div class="card card-sidebar-mobile">
	<ul class="nav nav-sidebar" data-nav-type="accordion">
		<!-- Main -->
		<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
		<li class="nav-item">
			<a href="{{ route('home') }}" class="nav-link {{ active_link('home') }}">
				<i class="icon-home4"></i>
				<span>Dashboard</span>
			</a>
		</li>
		<!-- /main -->
		<!-- User Panel -->
		@php
		$user_page = ['admin.user.index', 'admin.role.index', 'admin.sales-commission-agents.index'];
		@endphp
		@if(auth()->user()->can('user.view') || auth()->user()->can('user.create') || auth()->user()->can('roles.view'))
		<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">User Panel</div> <i class="icon-menu" title="Main"></i></li>
		<li class="nav-item nav-item-submenu {{ nav_item_open($user_page, request()->route()->getName()) }}">
			<a href="#" class="nav-link"><i class="icon-users4"></i> <span>User Mangement</span></a>
			<ul class="nav nav-group-sub" data-submenu-title="Starter kit" {!!nav_item_open($user_page, request()->route()->getName(), 'style="display: block; "') !!}>
				@can( 'user.view' )
				<li class="nav-item">
					<a href="{{ route('admin.user.index') }}" class="nav-link {{ active_link('admin.user.index') }}">
						<i class="icon-user"></i>
						<span>Users</span>
					</a>
				</li>
				@endcan
				@can( 'role.view' )
				<li class="nav-item">
					<a href="{{ route('admin.role.index') }}" class="nav-link {{ active_link('admin.role.index') }}">
						<i class="icon-aid-kit"></i>
						<span>Roles</span>
					</a>
				</li>
				@endcan
				@can( 'user.view' )
				<li class="nav-item">
					<a href="{{ route('admin.sales-commission-agents.index') }}" class="nav-link {{ active_link('admin.sales-commission-agents.index') }}">
						<i class="icon-sun3"></i>
						<span> @lang('service.sales_commission_agents')</span>
					</a>
				</li>
				@endcan
			</ul>
		</li>
		<!-- User Panel -->
		@endif
		<!-- User Panel -->
		@php
		$user_page = ['admin.business.getBusinessSettings', 'admin.business-location.index', 'admin.invoice-schemes.index', 'admin.invoice-layouts.index', 'admin.invoice-layouts.create', 'admin.invoice-layouts.edit', 'admin.barcodes.index', 'admin.tax-rates.index', 'admin.group-taxes.index'];
		@endphp
		@if(auth()->user()->can('business_settings.access') ||
		auth()->user()->can('barcode_settings.access') ||
		auth()->user()->can('invoice_settings.access') ||
		auth()->user()->can('tax_rate.view') ||
		auth()->user()->can('send_notifications') ||
		auth()->user()->can('tax_rate.create'))
		<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Settings Panel</div> <i class="icon-gear" title="settings Panel"></i></li>
		@can('send_notifications')
		<li class="nav-item">
			<a href="{{ route('admin.notification-templates.index') }}" class="nav-link {{ active_link('admin.notification-templates.index') }}">
				<i class="icon-bubble-notification"></i>
				<span>@lang('service.notification_templates')</span>
			</a>
		</li>
		@endif
		<li class="nav-item nav-item-submenu {{ nav_item_open($user_page, request()->route()->getName()) }}">
			<a href="#" class="nav-link"><i class="icon-gear"></i> <span>Settings Mangement</span></a>
			<ul class="nav nav-group-sub" data-submenu-title="Settings Management" {!!nav_item_open($user_page, request()->route()->getName(), 'style="display: block; "') !!}>
				@can('business_settings.access')
				<li class="nav-item">
					<a href="{{ route('admin.business.getBusinessSettings') }}" class="nav-link {{ active_link('admin.business.getBusinessSettings') }}">
						<i class="icon-cogs"></i>
						<span>Bussiness Settings</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.business-location.index') }}" class="nav-link {{ active_link('admin.business-location.index') }}">
						<i class="icon-location4"></i>
						<span>@lang('business.business_locations')</span>
					</a>
				</li>
				@endcan
				@can('invoice_settings.access')
				<li class="nav-item">
					<a href="{{ route('admin.invoice-schemes.index') }}" class="nav-link {{ active_link('admin.invoice-schemes.index') }}">
						<i class="fa fa-file"></i>
						<span>@lang('invoice.invoice_settings')</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.invoice-layouts.index') }}" class="nav-link {{ active_link('admin.invoice-layouts.index') }}{{ active_link('admin.invoice-layouts.create') }}{{ active_link('admin.invoice-layouts.edit') }}">
						<i class="icon-color-sampler"></i>
						<span>@lang('invoice.invoice_layouts')</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.barcodes.index') }}" class="nav-link {{ active_link('admin.barcodes.index') }}">
						<i class="icon-barcode2"></i>
						<span>@lang('page.barcodes')</span>
					</a>
				</li>
				@endcan
				@if(auth()->user()->can('tax_rate.view') ||
				auth()->user()->can('tax_rate.create'))
				<li class="nav-item">
					<a href="{{ route('admin.tax-rates.index') }}" class="nav-link {{ active_link('admin.tax-rates.index') }}">
						<i class="icon-pushpin"></i>
						<span>@lang('page.tax_rates')</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.group-taxes.index') }}" class="nav-link {{ active_link('admin.group-taxes.index') }}">
						<i class="icon-make-group"></i>
						<span>@lang('page.group_taxes')</span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		<!-- User Panel -->
		@endif
	</ul>
</div>