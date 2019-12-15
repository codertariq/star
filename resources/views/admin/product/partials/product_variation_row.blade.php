
@if(!session('business.enable_price_tax'))
    @php
        $default = 0;
        $class = 'hide';
    @endphp
@else
    @php
        $default = null;
        $class = '';
    @endphp
@endif

<tr class="variation_row">
    <td>
        {!! Form::select('product_variation[' . $row_index .'][variation_template_id]', $variation_templates, null, ['class' => 'form-control select input-sm variation_template', 'required', 'data-placeholder' => 'Please Select']); !!}
        <input type="hidden" class="row_index" value="{{$row_index}}">
    </td>

    <td>
        <table class="table table-sm table-bordered variation_value_table">
            <thead class="bg-warning">
            <tr>
                <th>@lang('product.sku') @show_tooltip(__('tooltip.sub_sku'))</th>
                <th>@lang('product.value')</th>
                <th class="{{$class}}">@lang('product.default_purchase_price')
                    <br/>
                    <span class="float-left"><small><i>@lang('product.exc_of_tax')</i></small></span>

                    <span class="float-right"><small><i>@lang('product.inc_of_tax')</i></small></span>
                </th>
                <th class="{{$class}}">@lang('product.profit_percent')</th>
                <th class="{{$class}}">@lang('product.default_selling_price')
                <br/>
                <small><i><span class="dsp_label"></span></i></small>
                    <!-- &nbsp;&nbsp;<b><i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" data-html="true" data-trigger="hover" data-content="<p class='text-primary'>Drag the mouse over the table cells to copy input values</p>" data-placement="top"></i></b> -->
                </th>
                <th><button type="button" class="btn btn-success btn-sm add_variation_value_row">+</button></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>
                    {!! Form::text('product_variation[' . $row_index .'][variations][0][sub_sku]', null, ['class' => 'form-control input-sm']); !!}
                </td>
                <td>
                    {!! Form::text('product_variation[' . $row_index .'][variations][0][value]', null, ['class' => 'form-control input-sm variation_value_name', 'required']); !!}
                </td>
                <td class="{{$class}}">
                    <div class="row">
<div class="col-sm-6">
                        {!! Form::text('product_variation[' . $row_index .'][variations][0][default_purchase_price]', $default, ['class' => 'form-control input-sm variable_dpp input_number', 'placeholder' => __('product.exc_of_tax'), 'required']); !!}
                    </div>

                    <div class="col-sm-6">
                        {!! Form::text('product_variation[' . $row_index .'][variations][0][dpp_inc_tax]', $default, ['class' => 'form-control input-sm variable_dpp_inc_tax input_number', 'placeholder' => __('product.inc_of_tax'), 'required']); !!}
                    </div>
                    </div>

                </td>
                <td class="{{$class}}">
                    {!! Form::text('product_variation[' . $row_index .'][variations][0][profit_percent]', $profit_percent, ['class' => 'form-control input-sm variable_profit_percent input_number', 'required']); !!}
                </td>
                <td class="{{$class}}">
                    {!! Form::text('product_variation[' . $row_index .'][variations][0][default_sell_price]', $default, ['class' => 'form-control input-sm variable_dsp input_number', 'placeholder' => __('product.exc_of_tax'), 'required']); !!}

                     {!! Form::text('product_variation[' . $row_index .'][variations][0][sell_price_inc_tax]', $default, ['class' => 'form-control input-sm variable_dsp_inc_tax input_number', 'placeholder' => __('product.inc_of_tax'), 'required']); !!}
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove_variation_value_row">-</button>
                    <input type="hidden" class="variation_row_index" value="0">
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>