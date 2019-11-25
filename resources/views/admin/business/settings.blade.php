@php
//arrtibutes : form= true, false; modal= false, full, normal, lg, xs, sm; ;list = true, false
$data['attribute'] = ['form' => true, 'list' => false, 'modal' => 'full'];
$data['breadcrumbs'] = 'business.getBusinessSettings';
$data['create'] = '';
$data['icon'] = 'icon-cogs';
$data['page'] = __('page.settings');
$data['page_title'] = __('page.settings_title');
$data['permission'] = 'user.';
$data['route'] = 'admin.business.getBusinessSettings';
$data['page_index'] = 'admin.business.getBusinessSettings';
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
	<div class="card border-success">
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
			{!! Form::open(['url' => route('admin.business.postBusinessSettings'), 'method' => 'post', 'id' => 'content_form','files' => true ]) !!}
			<div class="d-md-flex">
				<ul class="nav nav-tabs nav-tabs-vertical flex-column mr-md-3 wmin-md-200 mb-md-0 border-bottom-0">
					<li class="nav-item"><a href="#vertical-left-business" class="nav-link active" data-toggle="tab"> @lang('business.business')</a></li>
					<li class="nav-item"><a href="#vertical-left-tax" class="nav-link" data-toggle="tab"> @lang('business.tax')</a></li>
					<li class="nav-item"><a href="#vertical-left-product" class="nav-link" data-toggle="tab"> @lang('business.product')</a></li>
					<li class="nav-item"><a href="#vertical-left-sale" class="nav-link" data-toggle="tab"> @lang('business.sale')</a></li>
					<li class="nav-item"><a href="#vertical-left-pos_sale" class="nav-link" data-toggle="tab"> @lang('sale.pos_sale')</a></li>
					<li class="nav-item"><a href="#vertical-left-purchases" class="nav-link" data-toggle="tab"> @lang('purchase.purchases')</a></li>
					<li class="nav-item"><a href="#vertical-left-dashboard" class="nav-link" data-toggle="tab"> @lang('business.dashboard')</a></li>
					<li class="nav-item"><a href="#vertical-left-system" class="nav-link" data-toggle="tab"> @lang('business.system')</a></li>
					<li class="nav-item"><a href="#vertical-left-prefixes" class="nav-link" data-toggle="tab"> @lang('service.prefixes')</a></li>
					<li class="nav-item"><a href="#vertical-left-email_settings" class="nav-link" data-toggle="tab"> @lang('service.email_settings')</a></li>
					<li class="nav-item"><a href="#vertical-left-sms_settings" class="nav-link" data-toggle="tab"> @lang('service.sms_settings')</a></li>
					<li class="nav-item"><a href="#vertical-left-modules" class="nav-link" data-toggle="tab"> @lang('service.modules')</a></li>
				</ul>
				<div class="tab-content w-100">
					<div class="tab-pane fade show active" id="vertical-left-business">
						@include('admin.business._partials.settings_business')
					</div>
					<div class="tab-pane fade" id="vertical-left-tax">
						@include('admin.business._partials.settings_tax')
					</div>
					<div class="tab-pane fade" id="vertical-left-product">
						@include('admin.business._partials.settings_product')
					</div>
					<div class="tab-pane fade" id="vertical-left-sale">
						@include('admin.business._partials.settings_sales')
					</div>
					<div class="tab-pane fade" id="vertical-left-pos_sale">
						@include('admin.business._partials.settings_pos')
					</div>
					<div class="tab-pane fade" id="vertical-left-purchases">
						@include('admin.business._partials.settings_purchase')
					</div>
					<div class="tab-pane fade" id="vertical-left-dashboard">
						@include('admin.business._partials.settings_dashboard')
					</div>
					<div class="tab-pane fade" id="vertical-left-system">
						@include('admin.business._partials.settings_system')
					</div>
					<div class="tab-pane fade" id="vertical-left-prefixes">
						@include('admin.business._partials.settings_prefixes')
					</div>
					<div class="tab-pane fade" id="vertical-left-email_settings">
						@include('admin.business._partials.settings_email')
					</div>
					<div class="tab-pane fade" id="vertical-left-sms_settings">
						@include('admin.business._partials.settings_sms')
					</div>
					<div class="tab-pane fade" id="vertical-left-modules">
						@include('admin.business._partials.settings_modules')
					</div>
				</div>
			</div>
			    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-success float-right" type="submit">@lang('business.update_settings')</button>
        </div>
    </div>
{!! Form::close() !!}
		</div>
	</div>
</div>
@stop
@push('js')
<script src="{{ asset('js/pages/admin/business_settings.js') }}"></script>
@endpush