<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('default_sales_discount', __('business.default_sales_discount') . ':*') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::number('default_sales_discount', $business->default_sales_discount, ['class' => 'form-control', 'min' => 0, 'step' => 0.01, 'max' => 100]); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-percent"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('default_sales_tax', __('business.default_sales_tax') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('default_sales_tax', $tax_rates, $business->default_sales_tax, ['class' => 'form-control select','placeholder' => __('business.default_sales_tax'), 'style' => 'width: 100%;']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 hide">
        <div class="form-group">
            {!! Form::label('sell_price_tax', __('business.sell_price_tax') . ':') !!}
            <div class="input-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="sell_price_tax" value="includes"
                        class="input-icheck" @if($business->sell_price_tax == 'includes') {{'checked'}} @endif> Includes the Sale Tax
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="sell_price_tax" value="excludes"
                        class="input-icheck" @if($business->sell_price_tax == 'excludes') {{'checked'}} @endif>Excludes the Sale Tax (Calculate sale tax on Selling Price provided in Add Purchase)
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('sales_cmsn_agnt', __('service.sales_commission_agent') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('sales_cmsn_agnt', $commission_agent_dropdown, $business->sales_cmsn_agnt, ['class' => 'form-control select', 'style' => 'width: 100%;']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('item_addition_method', __('service.sales_item_addition_method') . ':') !!}
            {!! Form::select('item_addition_method', [ 0 => __('service.add_item_in_new_row'), 1 =>  __('service.increase_item_qty')], $business->item_addition_method, ['class' => 'form-control select', 'style' => 'width: 100%;']); !!}
        </div>
    </div>
    <div class="col-sm-8 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('pos_settings[enable_msp]', 1, !empty($pos_settings['enable_msp']) ? true : false,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_msp']) !!}  {{ __( 'service.sale_price_is_minimum_sale_price' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-4 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('pos_settings[allow_overselling]', 1, !empty($pos_settings['allow_overselling']) ? true : false,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'allow_overselling']) !!}  {{ __( 'service.allow_overselling' ) }}
            </label>
            @show_tooltip(__('service.allow_overselling_help'))
        </div>
    </div>
</div>