<div class="row">
    @if(!config('constants.disable_purchase_in_other_currency', true))
    <div class="col-sm-12 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('purchase_in_diff_currency', 1, $business->purchase_in_diff_currency,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'purchase_in_diff_currency']) !!}  {{ __( 'purchase.allow_purchase_different_currency' ) }}
            </label>
            @show_tooltip(__('tooltip.purchase_different_currency'))
        </div>
    </div>
    <div class="col-sm-12 @if($business->purchase_in_diff_currency != 1) hide @endif" id="settings_purchase_currency_div">
        <div class="form-group">
            {!! Form::label('purchase_currency_id', __('purchase.purchase_currency') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('purchase_currency_id', $currencies, $business->purchase_currency_id, ['class' => 'form-control select', 'placeholder' => __('business.currency'), 'style' => 'width:100% !important']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-money"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 @if($business->purchase_in_diff_currency != 1) hide @endif" id="settings_currency_exchange_div">
        <div class="form-group">
            {!! Form::label('p_exchange_rate', __('purchase.p_exchange_rate') . ':') !!}
            @show_tooltip(__('tooltip.currency_exchange_factor'))
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::number('p_exchange_rate', $business->p_exchange_rate, ['class' => 'form-control', 'placeholder' => __('business.p_exchange_rate'), 'required', 'step' => '0.001']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-money"></i>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="clearfix"></div>
    <div class="col-sm-12 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_editing_product_from_purchase', 1, $business->enable_editing_product_from_purchase,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_editing_product_from_purchase']) !!}  {{ __( 'service.enable_editing_product_from_purchase' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-12 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_purchase_status', 1, $business->enable_purchase_status,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_purchase_status']) !!}  {{ __( 'service.enable_purchase_status' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-12 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_lot_number', 1, $business->enable_lot_number,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_lot_number']) !!}  {{ __( 'service.enable_lot_number' ) }}
            </label>
        </div>
    </div>
</div>