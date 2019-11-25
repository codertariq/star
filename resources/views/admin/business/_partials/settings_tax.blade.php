<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('tax_label_1', __('business.tax_1_name') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::text('tax_label_1', $business->tax_label_1, ['class' => 'form-control','placeholder' => __('business.tax_1_placeholder')]); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('tax_number_1', __('business.tax_1_no') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::text('tax_number_1', $business->tax_number_1, ['class' => 'form-control', 'placeholder' => __('business.tax_1_no') ]); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('tax_label_2', __('business.tax_2_name') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::text('tax_label_2', $business->tax_label_2, ['class' => 'form-control','placeholder' => __('business.tax_1_placeholder')]); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('tax_number_2', __('business.tax_2_no') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::text('tax_number_2', $business->tax_number_2, ['class' => 'form-control','placeholder' => __('business.tax_2_no')]); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_inline_tax', 1, $business->enable_inline_tax,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_inline_tax']) !!}  {{ __( 'service.enable_inline_tax' ) }}
            </label>
        </div>
    </div>
</div>