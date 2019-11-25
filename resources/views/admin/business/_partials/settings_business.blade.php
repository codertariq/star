<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('name',__('business.business_name') , ['class' => 'required']) !!}
            {!! Form::text('name', $business->name, ['class' => 'form-control', 'required',
            'placeholder' => __('business.business_name')]); !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('start_date', __('business.start_date') . ':') !!}
            @php
            $start_date = null;
            if(!empty($business->start_date)){
            $start_date = date('m/d/Y', strtotime($business->start_date));
            }
            @endphp
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::text('start_date', $start_date, ['class' => 'form-control start-date-picker','placeholder' => __('business.start_date'), 'readonly', 'data-toggle'=>"datepicker"]); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="icon-calendar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('default_profit_percent', __('business.default_profit'), ['class' => 'required']) !!} @show_tooltip(__('tooltip.default_profit_percent'))
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::number('default_profit_percent', $business->default_profit_percent, ['class' => 'form-control', 'min' => 0,
                'step' => 0.01]); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('profit_on_fixed', 1, $business->profit_on_fixed,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'profit_on_fixed']) !!}  {{ __( 'service.profit_on_fixed' ) }}
            </label>
            @show_tooltip(__('service.profit_on_fixed_tooltip'))
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('currency_id', __('business.currency') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('currency_id', $currencies, $business->currency_id, ['class' => 'form-control select','placeholder' => __('business.currency'), 'required']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('currency_symbol_placement', __('service.currency_symbol_placement') . ':') !!}
            {!! Form::select('currency_symbol_placement', ['before' => __('service.before_amount'), 'after' => __('service.after_amount')], $business->currency_symbol_placement, ['class' => 'form-control select', 'required']); !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('time_zone', __('business.time_zone') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('time_zone', $timezone_list, $business->time_zone, ['class' => 'form-control select', 'required']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('business_logo', __('business.upload_logo') . ':') !!}
            {!! Form::file('business_logo', ['accept' => 'image/*']); !!}
            <p class="help-block"><i> @lang('business.logo_help')</i></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('fy_start_month', __('business.fy_start_month') . ':') !!} @show_tooltip(__('tooltip.fy_start_month'))
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('fy_start_month', $months, $business->fy_start_month, ['class' => 'form-control select', 'required']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="icon-calendar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('accounting_method', __('business.accounting_method') , ['class' => 'required']) !!}
            @show_tooltip(__('tooltip.accounting_method'))
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('accounting_method', $accounting_methods, $business->accounting_method, ['class' => 'form-control select', 'required']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-calculator"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('transaction_edit_days', __('business.transaction_edit_days') , ['class' => 'required']) !!}
            @show_tooltip(__('tooltip.transaction_edit_days'))
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::number('transaction_edit_days', $business->transaction_edit_days, ['class' => 'form-control','placeholder' => __('business.transaction_edit_days'), 'required']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-edit"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('date_format', __('service.date_format'), ['class' => 'required']) !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('date_format', $date_formats, $business->date_format, ['class' => 'form-control select', 'required']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="icon-calendar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('time_format', __('service.time_format') , ['class' => 'required']) !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('time_format', [12 => __('service.12_hour'), 24 => __('service.24_hour')], $business->time_format, ['class' => 'form-control select', 'required']); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
</div>