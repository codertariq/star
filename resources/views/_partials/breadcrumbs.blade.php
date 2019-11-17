@if (count($breadcrumbs))
<div class="page-header page-header-light">
	<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
		<div class="d-flex">
			<div class="breadcrumb">
				@foreach ($breadcrumbs as $breadcrumb)
				@if ($breadcrumb->url && !$loop->last)
				<a href="{{ $breadcrumb->url }}" class="breadcrumb-item">
					@if($loop->first)
					<i class="icon-home2 mr-1"></i>
					@endif
					{{ $breadcrumb->title ? $breadcrumb->title : __('page.home') }}
				</a>
				@else
				<span class="breadcrumb-item active">
					@if($breadcrumb->title == __('page.home'))
					<i class="icon-home2 mr-1"></i>
					@endif
					{{ $breadcrumb->title }}</span>
				@endif
				@endforeach

			</div>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
		<div class="header-elements d-none">
			<div class="breadcrumb justify-content-center">
				<a href="#" class="breadcrumb-elements-item">
					Link
				</a>
				<div class="breadcrumb-elements-item dropdown p-0">
					<a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
						Dropdown
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item">Action</a>
						<a href="#" class="dropdown-item">Another action</a>
						<a href="#" class="dropdown-item">One more action</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">Separate action</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif