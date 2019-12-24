<div class="row">
	<div class="col-sm-12">
		@foreach($locations as $key => $value)
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">@lang('sale.location'): {{$value}}</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-sm table-bordered text-center table-striped add_opening_stock_table">
							<thead class="bg-success">
								<tr>
									<th>@lang( 'product.product_name' )</th>
									<th>@lang( 'service.quantity_left' )</th>
									<th>@lang( 'purchase.unit_cost_before_tax' )</th>
									@if($enable_expiry == 1 && $product->enable_stock == 1)
									<th>Exp. Date</th>
									@endif
									@if($product->enable_sr_no == 1)
									<th>Sr No. @show_tooltip(__( 'service.tooltip_opening_stock_sr_no' ))</th>
									@endif
									@if($enable_lot == 1)
									<th>@lang( 'service.lot_number' )</th>
									@endif
									<th>@lang( 'purchase.subtotal_before_tax' )</th>
									{{-- <th>&nbsp;</th> --}}
								</tr>
							</thead>
							<tbody>
								@php
								$subtotal = 0;
								@endphp
								@foreach($product->variations as $variation)
								@if(empty($purchases[$key][$variation->id]))
								@php
								$purchases[$key][$variation->id][] = ['quantity' => 0,
								'purchase_price' => $variation->default_purchase_price,
								'purchase_line_id' => null,
								'lot_number' => null
								]
								@endphp
								@endif
								@foreach($purchases[$key][$variation->id] as $sub_key => $var)
								@php
								$purchase_line_id = $var['purchase_line_id'];
								$qty = $var['quantity'];
								$purcahse_price = $var['purchase_price'];
								$row_total = $qty * $purcahse_price;
								$subtotal += $row_total;
								$lot_number = $var['lot_number'];
								$serial_no =productSerialForShow($product->id, $purchase_line_id, $variation->id);
								@endphp
								<tr>
									<td>
										{{ $product->name }} @if( $product->type == 'variable' ) (<b>{{ $variation->product_variation->name }}</b> : {{ $variation->name }}) @endif
										@if(!empty($purchase_line_id))
										{!! Form::hidden('stocks[' . $key . '][' . $variation->id . '][' . $sub_key . '][purchase_line_id]', $purchase_line_id); !!}
										@endif
									</td>
									<td>
										<div class="input-group-append">
											{!! Form::text('stocks[' . $key . '][' . $variation->id . '][' . $sub_key . '][quantity]', @format_quantity($qty) , ['class' => 'form-control input-sm input_number purchase_quantity input_quantity', 'required']); !!}
											<span class="input-group-text">
												{{ $product->unit->short_name }}
											</span>
										</div>
									</td>
									<td>
										{!! Form::text('stocks[' . $key . '][' . $variation->id . '][' . $sub_key . '][purchase_price]', @num_format($purcahse_price) , ['class' => 'form-control input-sm input_number unit_price', 'required']); !!}
									</td>
									@if($enable_expiry == 1 && $product->enable_stock == 1)
									<td>
										{!! Form::text('stocks[' . $key . '][' . $variation->id . '][' . $sub_key . '][exp_date]', !empty($var['exp_date']) ? @format_date($var['exp_date']) : null , ['class' => 'form-control input-sm os_exp_date', 'readonly']); !!}
									</td>
									@endif
									@if($product->enable_sr_no == 1)
									<td>
										{!! Form::text('stocks[' . $key . '][' . $variation->id . '][' . $sub_key . '][serial_no]', !empty($serial_no) ? $serial_no : null , ['class' => 'form-control input-sm serial_no']); !!}
									</td>
									@endif
									@if($enable_lot == 1)
									<td>
										{!! Form::text('stocks[' . $key . '][' . $variation->id . '][' . $sub_key . '][lot_number]', $lot_number , ['class' => 'form-control input-sm']); !!}
									</td>
									@endif
									<td>
										<span class="row_subtotal_before_tax">{{@num_format($row_total)}}</span>
									</td>
									{{-- <td>
										@if($loop->index == 0)
										<button type="button" class="btn btn-primary btn-sm add_stock_row" data-sub-key="{{ count($purchases[$key][$variation->id])}}"
										data-row-html='<tr>
											<td>
												{{ $product->name }} @if( $product->type == "variable" ) (<b>{{ $variation->product_variation->name }}</b> : {{ $variation->name }}) @endif
											</td>
											<td>
												<div class="input-group-append">
													<input class="form-control input-sm input_number purchase_quantity" required="" name="stocks[{{$key}}][{{$variation->id}}][__subkey__][quantity]" type="text" value="0">
													<span class="input-group-text">
														{{ $product->unit->short_name }}
													</span>
												</div>
											</td>
											<td>
												<input class="form-control input-sm input_number unit_price" required="" name="stocks[{{$key}}][{{$variation->id}}][__subkey__][purchase_price]" type="text" value="{{@num_format($purcahse_price)}}">
											</td>
											@if($enable_expiry == 1 && $product->enable_stock == 1)
											<td>
												<input class="form-control input-sm os_exp_date" required="" name="stocks[{{$key}}][{{$variation->id}}][__subkey__][exp_date]" type="text" readonly>
											</td>
											@endif
											@if($product->enable_sr_no == 1)
											<td>
												<input class="form-control input-sm" required="" name="stocks[{{$key}}][{{$variation->id}}][__subkey__][serial_no]" type="text">
											</td>
											@endif
											@if($enable_lot == 1)
											<td>
												<input class="form-control input-sm" name="stocks[{{$key}}][{{$variation->id}}][__subkey__][lot_number]" type="text">
											</td>
											@endif
											<td>
												<span class="row_subtotal_before_tax">
													0.00
												</span>
											</td>
											<td>&nbsp;</td></tr>'
											><i class="fa fa-plus"></i></button>
											@else
											&nbsp;
											@endif
										</td> --}}
									</tr>
									@endforeach
									@endforeach
								</tbody>
								<tfoot>
								<tr>
									<td colspan="
										@if($enable_expiry == 1 && $product->enable_stock == 1 && $enable_lot == 1) 4 @elseif($product->enable_sr_no == 1) 4 @elseif(($enable_expiry == 1 && $product->enable_stock == 1) || $enable_lot == 1) @else 2 @endif
									" class="text-right"><strong>@lang( 'service.total_amount_exc_tax' ): </strong></td>
									<td> <span id="total_subtotal">{{@num_format($subtotal)}}</span>
									<input type="hidden" id="total_subtotal_hidden" value=0>
								</td>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			</div> <!--box end-->
			@endforeach
		</div>
	</div>