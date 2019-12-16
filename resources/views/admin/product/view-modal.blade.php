<div class="print_row">
	<div class="row">
	<div class="col-md-12 text-center">
		<h2 class="font-weight-bold">{{ $product->name }}</h2>
		<hr>
	</div>
	<div class="col-sm-9">
		<div class="row">
			<div class="col-sm-4 invoice-col">
				<b>@lang('product.sku'):</b>
				{{$product->sku }}<br>
				<b>@lang('product.brand'): </b>
				{{ $product->brand ? $product->brand->name : '--' }}<br>
				<b>@lang('product.unit'): </b>
				{{$product->unit ? $product->unit->short_name : '--' }}<br>
				<b>@lang('product.model'): </b>
				{{$product->model ? $product->model->name : '--' }}<br>
				<b>@lang('product.barcode_type'): </b>
				{{ $product->barcode_type ? $product->barcode_type : '--' }}
				@if(!empty($product->product_custom_field1))
				<br/>
				<b>@lang('service.product_custom_field1'): </b>
				{{$product->product_custom_field1 }}
				@endif
				@if(!empty($product->product_custom_field2))
				<br/>
				<b>@lang('service.product_custom_field2'): </b>
				{{$product->product_custom_field2 }}
				@endif
				@if(!empty($product->product_custom_field3))
				<br/>
				<b>@lang('service.product_custom_field3'): </b>
				{{$product->product_custom_field3 }}
				@endif
				@if(!empty($product->product_custom_field4))
				<br/>
				<b>@lang('service.product_custom_field4'): </b>
				{{$product->product_custom_field4 }}
				@endif
			</div>
			<div class="col-sm-4 invoice-col">
				<b>@lang('product.category'): </b>
				{{$product->category ? $product->category->name : '--' }}<br>
				<b>@lang('product.model'): </b>
				{{$product->model ? $product->model->name : '--' }}<br>
				<b>@lang('product.manage_stock'): </b>
				@if($product->enable_stock)
				@lang('messages.yes')
				@else
				@lang('messages.no')
				@endif
				<br>
				@if($product->enable_stock)
				<b>@lang('product.alert_quantity'): </b>
				{{$product->alert_quantity ? $product->alert_quantity : '--' }}
				@endif
			</div>
			<div class="col-sm-4 invoice-col">
				<b>@lang('product.expires_in'): </b>
				@php
				$expiry_array = ['months'=>__('product.months'), 'days'=>__('product.days'), '' =>__('product.not_applicable') ];
				@endphp
				@if(!empty($product->expiry_period) && !empty($product->expiry_period_type))
				{{$product->expiry_period}} {{$expiry_array[$product->expiry_period_type]}}
				@else
				{{$expiry_array['']}}
				@endif
				<br>
				@if($product->weight)
				<b>@lang('service.weight'): </b>
				{{$product->weight }}<br>
				@endif
				<b>@lang('product.applicable_tax'): </b>
				{{ $product->product_tax ? $product->product_tax->name : __('service.none') }}<br>
				@php
				$tax_type = ['inclusive' => __('product.inclusive'), 'exclusive' => __('product.exclusive')];
				@endphp
				<b>@lang('product.selling_price_tax_type'): </b>
				{{$tax_type[$product->tax_type]  }}<br>
				<b>@lang('product.product_type'): </b>
				@lang('service.' . $product->type)
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				{!! $product->product_description !!}
			</div>
		</div>
	</div>
	<div class="col-sm-3 col-md-3 invoice-col">
		<div class="thumbnail">
			<img src="{{$product->image_url}}" alt="Product image" height="203px">
		</div>
	</div>
</div>
@if($rack_details->count())
@if(session('business.enable_racks') || session('business.enable_row') || session('business.enable_position'))
<div class="row">
	<div class="col-md-12">
		<h4>@lang('service.rack_details'):</h4>
	</div>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-sm">
				<tr class="bg-green">
					<th>@lang('business.location')</th>
					@if(session('business.enable_racks'))
					<th>@lang('service.rack')</th>
					@endif
					@if(session('business.enable_row'))
					<th>@lang('service.row')</th>
					@endif
					@if(session('business.enable_position'))
					<th>@lang('service.position')</th>
					@endif
				</tr>
				@foreach($rack_details as $rd)
				<tr>
					<td>{{$rd->name}}</td>
					@if(session('business.enable_racks'))
					<td>{{$rd->rack}}</td>
					@endif
					@if(session('business.enable_row'))
					<td>{{$rd->row}}</td>
					@endif
					@if(session('business.enable_position'))
					<td>{{$rd->position}}</td>
					@endif
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
@endif
@endif
@if($product->type == 'single')
@include('admin.product.partials.single_product_details')
@else
@include('admin.product.partials.variable_product_details')
@endif
</div>

<div class="row">
	<div class="col-md-12 text-center">
		{{-- <button type="button" class="btn btn-primary no-print"
		aria-label="Print"
		onclick='$(".print_row").printThis({pageTitle: "{{ $product->name }}", importCSS: false});'>
		<i class="fa fa-print"></i> @lang( 'messages.print' )
		</button> --}}
		<button type="button" class="btn btn-default no-print" data-dismiss="modal">@lang( 'messages.close' )</button>
	</div>
</div>