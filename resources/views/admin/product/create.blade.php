@php
//arrtibutes : form= true, false; modal= false, full, normal, lg, xs, sm; ;list = true, false
$data['attribute'] = ['form' => true, 'list' => false, 'modal' => true];
$data['breadcrumbs'] = 'products.create';
$data['create'] = 'link';
$data['icon'] = 'fa fa-file';
$data['page'] = __('page.product');
$data['page_title'] = __('page.new', ['attribute' => gv($data, 'page', __('page.home'))]);
$data['permission'] = 'user.';
$data['route'] = 'admin.products.';
$data['page_index'] = 'admin.products.create';
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
	{!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery product_form', 'id' => 'product_form', 'files' => true, 'method' => 'POST']) !!}
	<fieldset class="mb-3">
		<div class="card border-success" id="table_card">
			<div class="card-header header-elements-inline text-success-800 border-bottom-success alpha-info ">
				<h5 class="card-title">
				@if(gv($data, 'icon'))
				<i class="{{ $data['icon'] }} mr-2"></i>
				@endif
				{{ $data['page_title'] }}
				<a class="btn btn-success btn-sm rounded-round ml-1" href="{{ route($data['route'].'index') }}">
					<i class="icon-stack-plus mr-1"></i>
					{{ __('page.product') }}
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
						<legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
						<div class="row">
							<div class="col-sm-4 @if(!session('business.enable_brand')) hide @endif">
								<div class="form-group">
									<label for="brand_id">{{ __('product.brand') }} <span  @if(!auth()->user()->can('brand.create')) disabled @endif  data-url="{{route('admin.brands.create', ['quick_add' => true])}}" title="@lang('brand.add_brand')" class="ml-2" style="cursor: pointer;" id="content_managment"
									data-element="form"><i class="fa fa-plus-circle text-primary fa-lg"></i></span></label>
									<div class="input-group">
										{!! Form::select('brand_id', $brands, !empty($duplicate_product->brand_id) ? $duplicate_product->brand_id : null, ['data-placeholder' => __('messages.please_select'), 'class' => 'form-control select', 'id' => 'brand_id']); !!}
										<span class="input-group-append">
										</span>
									</div>
								</div>
							</div>

							<div class="col-sm-4 @if(!session('business.enable_category')) hide @endif">
								<div class="form-group">
									{!! Form::label('category_id', __('product.category') . ':') !!}
									{!! Form::select('category_id', $categories, !empty($duplicate_product->category_id) ? $duplicate_product->category_id : null, ['data-placeholder' => __('messages.please_select'), 'class' => 'form-control select']); !!}
								</div>
							</div>
							<div class="col-sm-4 @if(!session('business.enable_category') and !session('business.enable_brand')) hide @endif">
								<div class="form-group">
									{!! Form::label('model_id', __('product.model') . ':') !!}
									{!! Form::select('model_id', $sub_categories, !empty($duplicate_product->model_id) ? $duplicate_product->model_id : null, ['data-placeholder' => __('messages.please_select'), 'class' => 'form-control select']); !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									{!! Form::label('name', __('product.product_name') . ':*') !!}
									{!! Form::text('name', !empty($duplicate_product->name) ? $duplicate_product->name : null, ['class' => 'form-control', 'required',
									'placeholder' => __('product.product_name')]); !!}
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label for="unit_id">{{ __('product.unit') }} <span @if(!auth()->user()->can('unit.create')) disabled @endif  data-url="{{route('admin.units.create', ['quick_add' => true])}}" title="@lang('unit.add_unit')" class="ml-2" style="cursor: pointer;" id="content_managment"
									data-element="form"><i class="fa fa-plus-circle text-primary fa-lg"></i></span></label>
									<div class="input-group">
										{!! Form::select('unit_id', $units, !empty($duplicate_product->unit_id) ? $duplicate_product->unit_id : session('business.default_unit'), ['class' => 'form-control select', 'required', 'data-placeholder' => 'Please Select', 'id' => 'unit_id']); !!}
									</div>
								</div>
							</div>
							{{-- <div class="col-sm-4 @if(!(session('business.enable_category') && session('business.enable_sub_category'))) hide @endif">
								<div class="form-group">
									{!! Form::label('sub_category_id', __('product.sub_category') . ':') !!}
									{!! Form::select('sub_category_id', $sub_categories, !empty($duplicate_product->sub_category_id) ? $duplicate_product->sub_category_id : null, ['data-placeholder' => __('messages.please_select'), 'class' => 'form-control select']); !!}
								</div>
							</div> --}}
							<div class="col-sm-4">
								<div class="form-group">
									{!! Form::label('sku', __('product.sku') . ':') !!} @show_tooltip(__('tooltip.sku'))
									{!! Form::text('sku', null, ['class' => 'form-control',
									'placeholder' => __('product.sku')]); !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									{!! Form::label('barcode_type', __('product.barcode_type') . ':*') !!}
									{!! Form::select('barcode_type', $barcode_types, !empty($duplicate_product->barcode_type) ? $duplicate_product->barcode_type : $barcode_default, ['class' => 'form-control select', 'required']); !!}
								</div>
							</div>
							<div class="col-sm-4 mt-auto">
								<div class="form-group">
									<div class="form-check form-check-inline">
										<label class="form-check-label">
											{!! Form::checkbox('enable_stock', 1, !empty($duplicate_product) ? $duplicate_product->enable_stock : true,
											[ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_stock']) !!}  @lang('product.manage_stock')
										</label>
									</div>
								</div>
							</div>
							<div class="col-sm-4 @if(!empty($duplicate_product) && $duplicate_product->enable_stock == 0) hide @endif" id="alert_quantity_div">
								<div class="form-group">
									{!! Form::label('alert_quantity',  __('product.alert_quantity') . ':*') !!} @show_tooltip(__('tooltip.alert_quantity'))
									{!! Form::number('alert_quantity', !empty($duplicate_product->alert_quantity) ? $duplicate_product->alert_quantity : null , ['class' => 'form-control', 'required',
									'placeholder' => __('product.alert_quantity'), 'min' => '0']); !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-8">
								<div class="form-group">
									{!! Form::label('product_description', __('service.product_description') . ':') !!}
									{!! Form::textarea('product_description', !empty($duplicate_product->product_description) ? $duplicate_product->product_description : null, ['class' => 'form-control summernote']); !!}
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									{!! Form::label('image', __('service.product_image') . ':') !!}
									{!! Form::file('image', ['id' => 'upload_image', 'accept' => 'image/*']); !!}
									<small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]) <br> @lang('service.aspect_ratio_should_be_1_1')</p></small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card border-success" id="table_card">
			<div class="card-body">
				<div class="row">
					@if(session('business.enable_product_expiry') )
					@if(session('business.expiry_type') == 'add_expiry')
					@php
					$expiry_period = 12;
					$hide = true;
					@endphp
					@else
					@php
					$expiry_period = null;
					$hide = false;
					@endphp
					@endif
					<div class="col-sm-4 @if($hide) hide @endif">
						<div class="form-group">
							<div class="multi-input">
								{!! Form::label('expiry_period', __('product.expires_in') . ':') !!}<br>
								{!! Form::text('expiry_period', !empty($duplicate_product->expiry_period) ? @num_format($duplicate_product->expiry_period) : $expiry_period, ['class' => 'form-control pull-left input_number',
								'placeholder' => __('product.expiry_period'), 'style' => 'width:60%;']); !!}
								{!! Form::select('expiry_period_type', ['months'=>__('product.months'), 'days'=>__('product.days'), '' =>__('product.not_applicable') ], !empty($duplicate_product->expiry_period_type) ? $duplicate_product->expiry_period_type : 'months', ['class' => 'form-control select pull-left', 'style' => 'width:40%;', 'id' => 'expiry_period_type']); !!}
							</div>
						</div>
					</div>
					@endif
					<div class="col-sm-4">
						<div class="form-group">
							<div class="form-check form-check-inline">
								<label class="form-check-label">
									{!! Form::checkbox('enable_sr_no', 1, !empty($duplicate_product) ? $duplicate_product->enable_sr_no : true,
									[ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_sr_no']) !!}  <strong>@lang('service.enable_imei_or_sr_no')</strong>
								</label>@show_tooltip(__('service.tooltip_sr_no'))
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="form-check form-check-inline">
								<label class="form-check-label">
									{!! Form::checkbox('is_lifetime', 1, !empty($duplicate_product) ? $duplicate_product->is_lifetime : false,
									[ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'is_lifetime']) !!}<strong>@lang('service.is_lifetime')</strong>
								</label> @show_tooltip(__('service.tooltip_is_lifetime'))
							</div>
						</div>
					</div>
					@php
					$warenty_period = 12;
					$hide = !(empty($duplicate_product)) ? $duplicate_product->is_lifetime : false;
					@endphp
					<div class="col-sm-4 @if($hide) hide @endif" id="warenty_row">
						<div class="form-group">
							<div class="form-group">
								{!! Form::label('warenty_period', __('product.warenty') . ':') !!}
								<div class="input-group">
									{!! Form::text('warenty_period', !empty($duplicate_product->warenty_period) ? @num_format($duplicate_product->warenty_period) : $warenty_period, ['class' => 'form-control pull-left input_number', 'placeholder' => __('product.warenty_period'), 'style' => 'width:40%;']); !!}
									<span class="input-group-append">
										{!! Form::select('warenty_period_type', ['months'=>__('product.months'), 'days'=>__('product.days'), '' =>__('product.not_applicable') ], !empty($duplicate_product->warenty_period_type) ? $duplicate_product->warenty_period_type : 'months', ['class' => 'form-control select pull-left', 'style' => 'width:60%;', 'id' => 'warenty_period_type']); !!}
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<!-- Rack, Row & position number -->
					@if(session('business.enable_racks') || session('business.enable_row') || session('business.enable_position'))
					<div class="col-md-12">
						<h4>@lang('service.rack_details'):
						@show_tooltip(__('service.tooltip_rack_details'))
						</h4>
					</div>
					@foreach($business_locations as $id => $location)
					<div class="col-sm-3">
						<div class="form-group">
							{!! Form::label('rack_' . $id,  $location . ':') !!}
							@if(session('business.enable_racks'))
							{!! Form::text('product_racks[' . $id . '][rack]', !empty($rack_details[$id]['rack']) ? $rack_details[$id]['rack'] : null, ['class' => 'form-control', 'id' => 'rack_' . $id,
							'placeholder' => __('service.rack')]); !!}
							@endif
							@if(session('business.enable_row'))
							{!! Form::text('product_racks[' . $id . '][row]', !empty($rack_details[$id]['row']) ? $rack_details[$id]['row'] : null, ['class' => 'form-control', 'placeholder' => __('service.row')]); !!}
							@endif
							@if(session('business.enable_position'))
							{!! Form::text('product_racks[' . $id . '][position]', !empty($rack_details[$id]['position']) ? $rack_details[$id]['position'] : null, ['class' => 'form-control', 'placeholder' => __('service.position')]); !!}
							@endif
						</div>
					</div>
					@endforeach
					@endif
					@if(config('constant.product_weight'))
					<div class="col-sm-4">
						<div class="form-group">
							{!! Form::label('weight',  __('service.weight') . ':') !!}
							{!! Form::text('weight', !empty($duplicate_product->weight) ? $duplicate_product->weight : null, ['class' => 'form-control', 'placeholder' => __('service.weight')]); !!}
						</div>
					</div>
					@endif
					<!--custom fields-->
				</div>
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							{!! Form::label('product_custom_field1',  __('service.product_custom_field1') . ':') !!}
							{!! Form::text('product_custom_field1', !empty($duplicate_product->product_custom_field1) ? $duplicate_product->product_custom_field1 : null, ['class' => 'form-control', 'placeholder' => __('service.product_custom_field1')]); !!}
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							{!! Form::label('product_custom_field2',  __('service.product_custom_field2') . ':') !!}
							{!! Form::text('product_custom_field2', !empty($duplicate_product->product_custom_field2) ? $duplicate_product->product_custom_field2 : null, ['class' => 'form-control', 'placeholder' => __('service.product_custom_field2')]); !!}
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							{!! Form::label('product_custom_field3',  __('service.product_custom_field3') . ':') !!}
							{!! Form::text('product_custom_field3', !empty($duplicate_product->product_custom_field3) ? $duplicate_product->product_custom_field3 : null, ['class' => 'form-control', 'placeholder' => __('service.product_custom_field3')]); !!}
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							{!! Form::label('product_custom_field4',  __('service.product_custom_field4') . ':') !!}
							{!! Form::text('product_custom_field4', !empty($duplicate_product->product_custom_field4) ? $duplicate_product->product_custom_field4 : null, ['class' => 'form-control', 'placeholder' => __('service.product_custom_field4')]); !!}
						</div>
					</div>
					<!--custom fields-->
				</div>
				<div class="row">
					{{-- @include('layouts.partials.module_form_part') --}}
				</div>
			</div>
		</div>
		<div class="card border-success" id="table_card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-4 @if(!session('business.enable_price_tax')) hide @endif">
						<div class="form-group">
							{!! Form::label('tax', __('product.applicable_tax') . ':') !!}
							{!! Form::select('tax', $taxes, !empty($duplicate_product->tax) ? $duplicate_product->tax : null, ['data-placeholder' => __('messages.please_select'), 'class' => 'form-control select'], $tax_attributes); !!}
						</div>
					</div>
					<div class="col-sm-4 @if(!session('business.enable_price_tax')) hide @endif">
						<div class="form-group">
							product
							{!! Form::select('tax_type', ['inclusive' => __('product.inclusive'), 'exclusive' => __('product.exclusive')], !empty($duplicate_product->tax_type) ? $duplicate_product->tax_type : 'exclusive',
							['class' => 'form-control select', 'required', 'id' => 'tax_type']); !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							{!! Form::label('type', __('product.product_type') . ':*') !!} @show_tooltip(__('tooltip.product_type'))
							{!! Form::select('type', ['single' => __('service.single'), 'variable' => __('service.variable')], !empty($duplicate_product->type) ? $duplicate_product->type : null, ['class' => 'form-control select',
							'required', 'data-action' => !empty($duplicate_product) ? 'duplicate' : 'add', 'data-product_id' => !empty($duplicate_product) ? $duplicate_product->id : '0']); !!}
						</div>
					</div>
					<div class="form-group col-sm-12 " id="product_form_part"></div>
					<input type="hidden" id="variation_counter" value="1">
					<input type="hidden" id="default_profit_percent"
					value="{{ $default_profit_percent }}">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<input type="hidden" name="submit_type" id="submit_type">
				<div class="text-center">
					<div class="btn-group">
						@if($selling_price_group_count)
						<button type="submit" value="submit_n_add_selling_prices" class="btn btn-warning submit_product_form">@lang('service.save_n_add_selling_price_group_prices')</button>
						@endif
						<button id="opening_stock_button" @if(!empty($duplicate_product) && $duplicate_product->enable_stock == 0) disabled @endif type="submit" value="submit_n_add_opening_stock" class="btn bg-purple submit_product_form">@lang('service.save_n_add_opening_stock')</button>
						<button type="submit" value="save_n_add_another" class="btn bg-pink submit_product_form">@lang('service.save_n_add_another')</button>
						<button type="submit" value="submit" class="btn btn-primary submit_product_form">@lang('messages.save')</button>
					</div>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
	@stop
	@push('js')
	<script src="{{ asset('js/pages/admin/product.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
	<script>
		_componentTooltipCustomColor();
		_componentSelect2();
		_componentUniform();
		$('select#design').change(function() {
		if ($(this).val() == 'columnize-taxes') {
		$('div#columnize-taxes').removeClass('hide');
		$('div#columnize-taxes')
		.find('input')
		.removeAttr('disabled', 'false');
		} else {
		$('div#columnize-taxes').addClass('hide');
		$('div#columnize-taxes')
		.find('input')
		.attr('disabled', 'true');
		}
		});
	</script>
	@endpush