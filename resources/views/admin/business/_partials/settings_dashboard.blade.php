<div class="pos-tab-content">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('stock_expiry_alert_days', __('business.view_stock_expiry_alert_for'), ['class' => 'required']) !!}
                <div class="form-group-feedback form-group-feedback-right">
                    {!! Form::number('stock_expiry_alert_days', $business->stock_expiry_alert_days, ['class' => 'form-control','required']); !!}
                    <div class="form-control-feedback form-control-feedback-sm">
                        @lang('business.days')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>