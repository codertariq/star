<!-- business information here -->
<style>

.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #000000;
}

.table-bordered {
    border: 1px solid #000;
}


     table, tbody, thead, tr, th, td{border-color:  #000}
     
     *{border-color:  #000 !important}
     
   
    @media print{
      
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #000000 !important;
}
        .madani{
            width: 40%;
            display: inline-block;
             float: left;
        }
        .madani-2{
            width: 40%;
             display: inline-block;
             float: right;
        }
        
        
    }

</style>
<div class="row">
	<!-- Logo -->
	@if(!empty($receipt_details->logo))
	<img src="{{$receipt_details->logo}}" class="img img-responsive center-block" height="100px" width="200px">
	@endif
	<!-- Header text -->
	<!-- business information here -->
	<div class="col-xs-12 text-center">
		@if(!empty($receipt_details->display_name))
		<h2 class="text-center " style=" font-size: 49px; font-weight: bold; @if(!empty($receipt_details->logo)) margin-top: 0px; @endif" >
		<!-- Shop & Location Name  -->
		{{$receipt_details->display_name}}
		</h2>
		@endif
		<!-- Address -->
		<p>
			@if(!empty($receipt_details->address))
			<small class="text-center">
			{!! $receipt_details->address !!}
			</small>
			@endif
			@if(!empty($receipt_details->contact))
			<br/>{{ $receipt_details->contact }}
			@endif
			@if(!empty($receipt_details->contact) && !empty($receipt_details->website))
			,
			@endif
			@if(!empty($receipt_details->website))
			{{ $receipt_details->website }}
			@endif
			@if(!empty($receipt_details->location_custom_fields))
			<br>{{ $receipt_details->location_custom_fields }}
			@endif
		</p>
		<!-- Header text -->
		@if(!empty($receipt_details->header_text))
		<p">
			{!! $receipt_details->header_text !!}
		</p>
		@endif
		<p>
			@if(!empty($receipt_details->sub_heading_line1))
			{{ $receipt_details->sub_heading_line1 }}
			@endif
			@if(!empty($receipt_details->sub_heading_line2))
			<br>{{ $receipt_details->sub_heading_line2 }}
			@endif
			@if(!empty($receipt_details->sub_heading_line3))
			<br>{{ $receipt_details->sub_heading_line3 }}
			@endif
			@if(!empty($receipt_details->sub_heading_line4))
			<br>{{ $receipt_details->sub_heading_line4 }}
			@endif
			@if(!empty($receipt_details->sub_heading_line5))
			<br>{{ $receipt_details->sub_heading_line5 }}
			@endif
		</p>
		<p>
			@if(!empty($receipt_details->tax_info1))
			<b>{{ $receipt_details->tax_label1 }}</b> {{ $receipt_details->tax_info1 }}
			@endif
			@if(!empty($receipt_details->tax_info2))
			<b>{{ $receipt_details->tax_label2 }}</b> {{ $receipt_details->tax_info2 }}
			@endif
		</p>
		<!-- Title of receipt -->
		@if(!empty($receipt_details->invoice_heading))
		<h3 class="text-center">
		{!! $receipt_details->invoice_heading !!}
		</h3>
		@endif
		<!-- Invoice  number, Date  -->
		<p style="width: 100% !important" class="word-wrap">
			<span class="pull-left text-left word-wrap">
				@if(!empty($receipt_details->invoice_no_prefix))
				<b>{!! $receipt_details->invoice_no_prefix !!}</b>
				@endif
				{{$receipt_details->invoice_no}}
				<!-- Table information-->
				@if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
				<br/>
				<span class="pull-left text-left">
					@if(!empty($receipt_details->table_label))
					<b>{!! $receipt_details->table_label !!}</b>
					@endif
					{{$receipt_details->table}}
					<!-- Waiter info -->
				</span>
				@endif
				<!-- customer info -->
				@if(!empty($receipt_details->customer_name))
				<br/>
				<b>{{ $receipt_details->customer_label }}</b> {{ $receipt_details->customer_name }}
				@endif
				@if(!empty($receipt_details->customer_info))
				{!! $receipt_details->customer_info !!}
				@endif
				@if(!empty($receipt_details->client_id_label))
				<br/>
				<b>{{ $receipt_details->client_id_label }}</b> {{ $receipt_details->client_id }}
				@endif
				@if(!empty($receipt_details->customer_tax_label))
				<br/>
				<b>{{ $receipt_details->customer_tax_label }}</b> {{ $receipt_details->customer_tax_number }}
				@endif
				@if(!empty($receipt_details->customer_custom_fields))
				<br/>{!! $receipt_details->customer_custom_fields !!}
				@endif
			</span>
			<span class="pull-right text-left">
				<b>{{$receipt_details->date_label}}</b> {{$receipt_details->invoice_date}}
				@if(!empty($receipt_details->sales_person_label))
				<br/>
				<b>{{ $receipt_details->sales_person_label }}</b> {{ $receipt_details->sales_person }}
				@endif
				@if(!empty($receipt_details->serial_no_label) || !empty($receipt_details->repair_serial_no))
				{{-- <br> --}}
				@if(!empty($receipt_details->serial_no_label))
				<b>{!! $receipt_details->serial_no_label !!}</b>
				@endif
				{{$receipt_details->repair_serial_no}}<br>
				@endif
				@if(!empty($receipt_details->repair_status_label) || !empty($receipt_details->repair_status))
				@if(!empty($receipt_details->repair_status_label))
				<b>{!! $receipt_details->repair_status_label !!}</b>
				@endif
				{{$receipt_details->repair_status}}<br>
				@endif
				@if(!empty($receipt_details->repair_warranty_label) || !empty($receipt_details->repair_warranty))
				@if(!empty($receipt_details->repair_warranty_label))
				<b>{!! $receipt_details->repair_warranty_label !!}</b>
				@endif
				{{$receipt_details->repair_warranty}}
				{{-- <br> --}}
				@endif
				<!-- Waiter info -->
				@if(!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
				<br/>
				@if(!empty($receipt_details->service_staff_label))
				<b>{!! $receipt_details->service_staff_label !!}</b>
				@endif
				{{$receipt_details->service_staff}}
				@endif
			</span>
		</p>
	</div>
	@if(!empty($receipt_details->defects_label) || !empty($receipt_details->repair_defects))
	<div class="col-xs-12">
		{{-- <br> --}}
		@if(!empty($receipt_details->defects_label))
		<b>{!! $receipt_details->defects_label !!}</b>
		@endif
		{{$receipt_details->repair_defects}}
	</div>
	@endif
	<!-- /.col -->
</div>
<div class="row">
	<div class="col-xs-12">
		{{-- <br/><br/> --}}
		<table class="table table-responsive table-bordered">
			<thead>
				<tr>
					<th>{{$receipt_details->table_product_label}}</th>
					<th>{{$receipt_details->table_qty_label}}</th>
					<th>{{$receipt_details->table_unit_price_label}}</th>
					<th>{{$receipt_details->table_subtotal_label}}</th>
				</tr>
			</thead>
			<tbody>
				@forelse($receipt_details->lines as $line)
				<tr>
					<td style="word-break: break-all;">
						@if(!empty($line['image']))
						<img src="{{$line['image']}}" alt="Image" width="50" style="float: left; margin-right: 8px;">
						@endif
						@if(!empty($line['brand'])) {{$line['brand']}} @endif
						@if(!empty($line['category'])) {{$line['category']}} @endif
						{{$line['name']}} {{$line['variation']}}
						@if(!empty($line['sub_sku'])), {{$line['sub_sku']}} @endif  @if(!empty($line['cat_code'])), {{$line['cat_code']}}@endif
						@if(!empty($line['product_custom_fields'])), {{$line['product_custom_fields']}} @endif
						@if(!empty($line['sell_line_note']))({{$line['sell_line_note']}}) @endif
						@if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif
						@if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif
						
						@if(!empty($line['warenty_period']))
						<br>
						Warenty:
						@if($line['is_lifetime'] == 0)
						{{$line['warenty_period']}} 
						{{$line['warenty_period_type']}}
						  @else
						   Lifetime
						   @endif
						@endif
					</td>
					<td>{{$line['quantity']}} {{$line['units']}} </td>
					<td>{{$line['unit_price_inc_tax']}}</td>
					<td>{{$line['line_total']}}</td>
				</tr>
				@if(!empty($line['modifiers']))
				@foreach($line['modifiers'] as $modifier)
				<tr>
					<td>
						{{$modifier['name']}} {{$modifier['variation']}}
						@if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif @if(!empty($modifier['cat_code'])), {{$modifier['cat_code']}}@endif
						@if(!empty($modifier['sell_line_note']))({{$modifier['sell_line_note']}}) @endif
					</td>
					<td>{{$modifier['quantity']}} {{$modifier['units']}} </td>
					<td>{{$modifier['unit_price_inc_tax']}}</td>
					<td>{{$modifier['line_total']}}</td>
				</tr>
				@endforeach
				@endif
				@empty
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<br/>
	<!--<div class="col-md-12"><hr/></div>-->
	<br/>
	<div class="col-xs-6">
		<table class="table table-condensed">
			@if(!empty($receipt_details->payments))
			@foreach($receipt_details->payments as $payment)
			<tr>
				<td>{{$payment['method']}}</td>
				<td>{{$payment['amount']}}</td>
				<td>{{$payment['date']}}</td>
			</tr>
			@endforeach
			@endif
			<!-- Total Paid-->
			@if(!empty($receipt_details->total_paid))
			<tr>
				<th>
					{!! $receipt_details->total_paid_label !!}
				</th>
				<td>
					{{$receipt_details->total_paid}}
				</td>
			</tr>
			@endif
			<!-- Total Due-->
			@if(!empty($receipt_details->total_due))
			<tr>
				<th>
					{!! $receipt_details->total_due_label !!}
				</th>
				<td>
					{{$receipt_details->total_due}}
				</td>
			</tr>
			@endif
			@if(!empty($receipt_details->all_due))
			<tr>
				<th>
					{!! $receipt_details->all_bal_label !!}
				</th>
				<td>
					{{$receipt_details->all_due}}
				</td>
			</tr>
			@endif
		</table>
		{{$receipt_details->additional_notes}}
	</div>
	<div class="col-xs-6">
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<th style="width:70%">
							{!! $receipt_details->subtotal_label !!}
						</th>
						<td>
							{{$receipt_details->subtotal}}
						</td>
					</tr>
					<!-- Shipping Charges -->
					@if(!empty($receipt_details->shipping_charges))
					<tr>
						<th style="width:70%">
							{!! $receipt_details->shipping_charges_label !!}
						</th>
						<td>
							{{$receipt_details->shipping_charges}}
						</td>
					</tr>
					@endif
					<!-- Discount -->
					@if( !empty($receipt_details->discount) )
					<tr>
						<th>
							{!! $receipt_details->discount_label !!}
						</th>
						<td>
							(-) {{$receipt_details->discount}}
						</td>
					</tr>
					@endif
					<!-- Tax -->
					@if( !empty($receipt_details->tax) )
					<tr>
						<th>
							{!! $receipt_details->tax_label !!}
						</th>
						<td>
							(+) {{$receipt_details->tax}}
						</td>
					</tr>
					@endif
					<!-- Total -->
					<tr>
						<th>
							{!! $receipt_details->total_label !!}
						</th>
						<td>
							{{$receipt_details->total}}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@if($receipt_details->show_barcode)
<div class="row">
	<div class="col-xs-12">
		{{-- Barcode --}}
		<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
	</div>
</div>
@endif
@if(!empty($receipt_details->footer_text))
<div class="row">
	<div class="col-xs-12">
		{!! $receipt_details->footer_text !!}
	</div>
</div>
@endif

<div class="row">
		<div class="col-sm-3 madani">
			<div style="font-weight: bold;">
				<hr class="hrr mb-0 w-25">
				<p class="d-inline-block" style="font-weight: bold;">Receiver's Signature</p>
			</div>
		</div>
<div class="col-sm-6"> </div>
		<div class="col-sm-3 madani-2">
			<div style="font-weight: bold;text-align: right;">
				<hr class="hrr2 mb-0 w-25">
				<p class="mr-2 d-inline-block" style="font-weight: bold;">Manager Signature</p>
			</div>
		</div>
		</div>
			<div class="row pt-4" style="border-top:solid 1px;">
				<div class="col-md-6 madani">
					<div class="text-left" >
						<p>Printing Date : {{date('Y-m-d h:i:s a')}}</p>
					</div>
				</div>
				<div class="col-md-6 madani-2">
					<div class="text-right">
						<p> Powered by : Satt IT- 0185 0054 500</p>
					</div>
				</div>
</div>
@if(!empty($receipt_details->footer_text))
<div class="row">
	<div class="col-xs-12">
		{!! $receipt_details->footer_text !!}
	</div>
</div>
@endif