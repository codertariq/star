<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('sku_prefix', __('business.sku_prefix') . ':') !!}
            {!! Form::text('sku_prefix', $business->sku_prefix, ['class' => 'form-control text-uppercase']); !!}
        </div>
    </div>
    @if(!config('constants.disable_expiry', true))
    <div class="col-sm-4">
        {!! Form::label('enable_product_expiry', __( 'product.enable_product_expiry' ) . ':') !!}
        @show_tooltip(__('service.tooltip_enable_expiry'))
        <div class="input-group-prepend">
            <span class="input-group-text">
                {!! Form::checkbox('enable_product_expiry', 1, $business->enable_product_expiry ); !!}
            </span>
            <select class="form-control select" id="expiry_type"
                name="expiry_type"
                @if(!$business->enable_product_expiry) disabled @endif>
                <option value="add_expiry" @if($business->expiry_type == 'add_expiry') selected @endif>
                    {{__('service.add_expiry')}}
                </option>
                <option value="add_manufacturing" @if($business->expiry_type == 'add_manufacturing') selected @endif>{{__('service.add_manufacturing_auto_expiry')}}</option>
            </select>
        </div>
    </div>
    <div class="col-sm-4 @if(!$business->enable_product_expiry) hide @endif" id="on_expiry_div">
        <div class="form-group">
            <div class="multi-input">
                {!! Form::label('on_product_expiry', __('service.on_product_expiry') . ':') !!}
                @show_tooltip(__('service.tooltip_on_product_expiry'))
                <br>
                {!! Form::select('on_product_expiry',     ['keep_selling'=>__('service.keep_selling'), 'stop_selling'=>__('service.stop_selling') ], $business->on_product_expiry, ['class' => 'form-control float-left', 'style' => 'width:60%;']); !!}
                @php
                $disabled = '';
                if($business->on_product_expiry == 'keep_selling'){
                $disabled = 'disabled';
                }
                @endphp
                {!! Form::number('stop_selling_before', $business->stop_selling_before, ['class' => 'form-control float-left', 'placeholder' => 'stop n days before', 'style' => 'width:40%;', $disabled, 'required', 'id' => 'stop_selling_before']); !!}
            </div>
        </div>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-sm-4 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_brand', 1, $business->enable_brand,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_brand']) !!}  {{ __( 'service.enable_brand' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-4 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_category', 1, $business->enable_category,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_category']) !!}  {{ __( 'service.enable_category' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-4 my-auto enable_sub_category">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_sub_category', 1, $business->enable_sub_category,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_sub_category']) !!}  {{ __( 'service.enable_sub_category' ) }}
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4 my-auto ">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_model', 1, $business->enable_model,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_model']) !!}  {{ __( 'service.enable_model' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-4 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_price_tax', 1, $business->enable_price_tax,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_price_tax']) !!}  {{ __( 'service.enable_price_tax' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('default_unit', __('service.default_unit') . ':') !!}
            <div class="form-group-feedback form-group-feedback-right">
                {!! Form::select('default_unit', $units_dropdown, $business->default_unit, ['class' => 'form-control select', 'style' => 'width: 100%;', 'data-placeholder' => 'Please Select' ]); !!}
                <div class="form-control-feedback form-control-feedback-sm">
                    <i class="fa fa-balance-scale"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_racks', 1, $business->enable_racks,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_racks']) !!}  {{ __( 'service.enable_racks' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-4 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_row', 1, $business->enable_row,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_row']) !!}  {{ __( 'service.enable_row' ) }}
            </label>
        </div>
    </div>
    <div class="col-sm-4 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enable_position', 1, $business->enable_position,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_position']) !!}  {{ __( 'service.enable_position' ) }}
            </label>
        </div>
    </div>
</div>