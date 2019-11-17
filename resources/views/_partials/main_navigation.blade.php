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
		$user_page = ['admin.user.index', 'admin.role.index'];
		@endphp
		<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">User Panel</div> <i class="icon-menu" title="Main"></i></li>
		<li class="nav-item nav-item-submenu {{ nav_item_open($user_page, request()->route()->getName()) }}">
			<a href="#" class="nav-link"><i class="icon-copy"></i> <span>User Mangement</span></a>
			<ul class="nav nav-group-sub" data-submenu-title="Starter kit" {!!nav_item_open($user_page, request()->route()->getName(), 'style="display: block; "') !!}>
				<li class="nav-item">
					<a href="{{ route('admin.user.index') }}" class="nav-link {{ active_link('admin.user.index') }}">
						<i class="icon-home4"></i>
						<span>Users</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.role.index') }}" class="nav-link {{ active_link('admin.role.index') }}">
						<i class="icon-home4"></i>
						<span>Roles</span>
					</a>
				</li>
			</ul>
		</li>
		<!-- User Panel -->
	</ul>
</div>