@php
//arrtibutes : form= true, false; modal= false, full, normal, lg, xs, sm; ;list = true, false
$data['attribute'] = ['form' => true, 'list' => true, 'modal' => 'full'];
$data['breadcrumbs'] = 'products.index';
$data['create'] = 'link';
$data['icon'] = 'fa fa-file';
$data['page'] = __('page.product');
$data['page_title'] = __('page.product_title');
$data['permission'] = 'user.';
$data['route'] = 'admin.products.';
$data['page_index'] = 'admin.products.index';
@endphp
{{-- Main Layout for This Page --}}
@extends('layouts.app', ['data' => $data])
{{-- Page Title For This Page --}}
@section('title', $data['page_title'])
@push('css')
	<style>
		@media print {
  body {
    margin: 0;
    padding: 0 !important;
    min-width: 768px;
  }
  .container {
    width: auto;
    min-width: 750px;
  }
}

@media print {
   .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
        float: left;
   }
   .col-sm-12 {
        width: 100%;
   }
   .col-sm-11 {
        width: 91.66666667%;
   }
   .col-sm-10 {
        width: 83.33333333%;
   }
   .col-sm-9 {
        width: 75%;
   }
   .col-sm-8 {
        width: 66.66666667%;
   }
   .col-sm-7 {
        width: 58.33333333%;
   }
   .col-sm-6 {
        width: 50%;
   }
   .col-sm-5 {
        width: 41.66666667%;
   }
   .col-sm-4 {
        width: 33.33333333%;
   }
   .col-sm-3 {
        width: 25%;
   }
   .col-sm-2 {
        width: 16.66666667%;
   }
   .col-sm-1 {
        width: 8.33333333%;
   }
}
	</style>
@endpush
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
			<a class="btn btn-success btn-sm rounded-round ml-1" href="{{ route($data['route'].'create') }}">
				<i class="icon-stack-plus mr-1"></i>
				{{ __('page.new', ['attribute' => gv($data, 'page', __('page.home'))]) }}
			</a>
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
			<div class="row">
				<div class="col-md-12">
					@include('admin.product.partials.product_list')
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@push('js')
<script src="{{ asset('js/pages/admin/product_list.js') }}"></script>
<script src="{{ asset('js/pages/admin/opening_stock.js') }}"></script>
@endpush