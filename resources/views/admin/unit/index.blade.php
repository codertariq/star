@php
//arrtibutes : form= true, false; modal= false, full, normal, lg, xs, sm; ;list = true, false
$data['attribute'] = ['form' => true, 'list' => true, 'modal' => 'lg'];
$data['breadcrumbs'] = 'units.index';
$data['create'] = 'modal';
$data['icon'] = 'fa fa-balance-scale';
$data['page'] = __('page.unit');
$data['page_title'] = __('page.unit_title');
$data['permission'] = 'user.';
$data['route'] = 'admin.units.';
$data['page_index'] = 'admin.units.index';
@endphp
{{-- Main Layout for This Page --}}
@extends('layouts.app', ['data' => $data])
{{-- Page Title For This Page --}}
@section('title', $data['page_title'])
@section('page_header')
{{ Breadcrumbs::render(gv($data, 'breadcrumbs', 'home')) }}
@stop
@section('content')
<div class="content">
	<div class="card border-success" id="table_card">
		<div class="card-header header-elements-inline text-success-800 border-bottom-success alpha-info ">
			<h5 class="card-title">
			@if(gv($data, 'icon'))
			<i class="{{ $data['icon'] }} mr-2"></i>
			@endif
			{{ $data['page_title'] }}
			@if(isset($data['route']) and Route::has($data['route'].'create'))
			@if($data['create'] == 'modal' and gv($data['attribute'], 'modal') and in_array($data['attribute']['modal'], ATTR['modal']))
			<button type="button" class="btn btn-success btn-sm rounded-round ml-1" id="content_managment" data-url="{{ route($data['route'].'create') }}" data-element="form">
			<i class="icon-stack-plus mr-1"></i>
			{{ __('page.new', ['attribute' => gv($data, 'page', __('page.home'))]) }}
			</button>
			@elseif($data['create'] == 'link')
			<a class="btn btn-success btn-sm rounded-round ml-1" href="{{ route($data['route'].'create') }}">
				<i class="icon-stack-plus mr-1"></i>
				{{ __('page.new', ['attribute' => gv($data, 'page', __('page.home'))]) }}
			</a>
			@endif
			@endif
			</h5>
			<div class="header-elements">
				<div class="list-icons">
					@if (gv($data['attribute'], 'list'))
					<a class="list-icons-item" data-action="reload" id="reload"></a>
					@endif
					<a class="list-icons-item" data-action="fullscreen"></a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<table class="table content_management_datatable table-striped" data-url="@if(isset($data['route']) and Route::has($data['route'].'create')){{ route($data['route'].'index', ['get' => 'datatable']) }}@endif">
				<thead>
					<tr>
						<th></th>
						<th>#</th>
						<th>@lang( 'unit.name' )</th>
						<th>@lang( 'unit.short_name' )</th>
						<th>@lang( 'unit.allow_decimal' ) @show_tooltip(__('tooltip.unit_allow_decimal'))</th>
						<th class="text-center">@lang('page.actions')</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@push('js')
<script src="{{ asset('js/pages/admin/unit.js') }}"></script>
@endpush