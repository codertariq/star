@php
//arrtibutes : form= true, false; modal= false, full, normal, lg, xs, sm; ;list = true, false
$data['attribute'] = ['form' => true, 'list' => false, 'modal' => false];
$data['breadcrumbs'] = 'invoice-layouts.create';
$data['create'] = 'link';
$data['icon'] = 'fa fa-file';
$data['page'] = __('page.invoice_layouts');
$data['page_title'] = __('page.new', ['attribute' => gv($data, 'page', __('page.home'))]);
$data['permission'] = 'user.';
$data['route'] = 'admin.invoice-layouts.';
$data['page_index'] = 'admin.invoice-layouts.index';
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
			<a class="btn btn-success btn-sm rounded-round ml-1" href="{{ route($data['route'].'index') }}">
				<i class="icon-stack-plus mr-1"></i>
				{{ __('page.invoice_layouts') }}
			</a>
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
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
					@include('admin.invoice_layouts.form._form', ['submit' => __('service.new', ['attribute' => gv($data, 'page')])])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@push('js')
<script src="{{ asset('js/pages/admin/invoice_layouts.js') }}"></script>
<script>
	_componentTooltipCustomColor();
_componentSelect2();
_componentUniform();
</script>
@endpush