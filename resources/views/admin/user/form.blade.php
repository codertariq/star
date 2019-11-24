<div class="row">
    <div class="form-group col-md-3">
        {!! Form::label('user_dob', __( 'service.dob' ) . ':') !!}
        {!! Form::text('dob', !empty($model->dob) ? @format_date($model->dob) : null, ['class' => 'form-control', 'placeholder' => __( 'service.dob'), 'readonly', 'id' => 'user_dob', 'data-toggle' => "datepicker" ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('marital_status', __( 'service.marital_status' ) . ':') !!}
        {!! Form::select('marital_status', ['married' => __( 'service.married'), 'unmarried' => __( 'service.unmarried' ), 'divorced' => __( 'service.divorced' )], !empty($model->marital_status) ? $model->marital_status : null, ['class' => 'form-control select', 'placeholder' => __( 'service.marital_status') ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('blood_group', __( 'service.blood_group' ) . ':') !!}
        {!! Form::text('blood_group', !empty($model->blood_group) ? $model->blood_group : null, ['class' => 'form-control', 'placeholder' => __( 'service.blood_group') ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('contact_number', __( 'service.contact_no' ) . ':') !!}
        {!! Form::text('contact_number', !empty($model->contact_number) ? $model->contact_number : null, ['class' => 'form-control', 'placeholder' => __( 'service.contact_no') ]); !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-3">
        {!! Form::label('fb_link', __( 'service.fb_link' ) . ':') !!}
        {!! Form::text('fb_link', !empty($model->fb_link) ? $model->fb_link : null, ['class' => 'form-control', 'placeholder' => __( 'service.fb_link') ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('twitter_link', __( 'service.twitter_link' ) . ':') !!}
        {!! Form::text('twitter_link', !empty($model->twitter_link) ? $model->twitter_link : null, ['class' => 'form-control', 'placeholder' => __( 'service.twitter_link') ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('social_media_1', __( 'service.social_media', ['number' => 1] ) . ':') !!}
        {!! Form::text('social_media_1', !empty($model->social_media_1) ? $model->social_media_1 : null, ['class' => 'form-control', 'placeholder' => __( 'service.social_media', ['number' => 1] ) ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('social_media_2', __( 'service.social_media', ['number' => 2] ) . ':') !!}
        {!! Form::text('social_media_2', !empty($model->social_media_2) ? $model->social_media_2 : null, ['class' => 'form-control', 'placeholder' => __( 'service.social_media', ['number' => 2] ) ]); !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-3">
        {!! Form::label('custom_field_1', __( 'service.custom_field', ['number' => 1] ) . ':') !!}
        {!! Form::text('custom_field_1', !empty($model->custom_field_1) ? $model->custom_field_1 : null, ['class' => 'form-control', 'placeholder' => __( 'service.custom_field', ['number' => 1] ) ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('custom_field_2', __( 'service.custom_field', ['number' => 2] ) . ':') !!}
        {!! Form::text('custom_field_2', !empty($model->custom_field_2) ? $model->custom_field_2 : null, ['class' => 'form-control', 'placeholder' => __( 'service.custom_field', ['number' => 2] ) ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('custom_field_3', __( 'service.custom_field', ['number' => 3] ) . ':') !!}
        {!! Form::text('custom_field_3', !empty($model->custom_field_3) ? $model->custom_field_3 : null, ['class' => 'form-control', 'placeholder' => __( 'service.custom_field', ['number' => 3] ) ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('custom_field_4', __( 'service.custom_field', ['number' => 4] ) . ':') !!}
        {!! Form::text('custom_field_4', !empty($model->custom_field_4) ? $model->custom_field_4 : null, ['class' => 'form-control', 'placeholder' => __( 'service.custom_field', ['number' => 4] ) ]); !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-3">
        {!! Form::label('guardian_name', __( 'service.guardian_name') . ':') !!}
        {!! Form::text('guardian_name', !empty($model->guardian_name) ? $model->guardian_name : null, ['class' => 'form-control', 'placeholder' => __( 'service.guardian_name' ) ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('id_proof_name', __( 'service.id_proof_name') . ':') !!}
        {!! Form::text('id_proof_name', !empty($model->id_proof_name) ? $model->id_proof_name : null, ['class' => 'form-control', 'placeholder' => __( 'service.id_proof_name' ) ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('id_proof_number', __( 'service.id_proof_number') . ':') !!}
        {!! Form::text('id_proof_number', !empty($model->id_proof_number) ? $model->id_proof_number : null, ['class' => 'form-control', 'placeholder' => __( 'service.id_proof_number' ) ]); !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        {!! Form::label('permanent_address', __( 'service.permanent_address') . ':') !!}
        {!! Form::textarea('permanent_address', !empty($model->permanent_address) ? $model->permanent_address : null, ['class' => 'form-control', 'placeholder' => __( 'service.permanent_address'), 'rows' => 3 ]); !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('current_address', __( 'service.current_address') . ':') !!}
        {!! Form::textarea('current_address', !empty($model->current_address) ? $model->current_address : null, ['class' => 'form-control', 'placeholder' => __( 'service.current_address'), 'rows' => 3 ]); !!}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
        <h4>@lang('service.bank_details'):</h4>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-3">
        {!! Form::label('account_holder_name', __( 'service.account_holder_name') . ':') !!}
        {!! Form::text('bank_details[account_holder_name]', !empty($bank_details['account_holder_name']) ? $bank_details['account_holder_name'] : null , ['class' => 'form-control', 'id' => 'account_holder_name', 'placeholder' => __( 'service.account_holder_name') ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('account_number', __( 'service.account_number') . ':') !!}
        {!! Form::text('bank_details[account_number]', !empty($bank_details['account_number']) ? $bank_details['account_number'] : null, ['class' => 'form-control', 'id' => 'account_number', 'placeholder' => __( 'service.account_number') ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('bank_name', __( 'service.bank_name') . ':') !!}
        {!! Form::text('bank_details[bank_name]', !empty($bank_details['bank_name']) ? $bank_details['bank_name'] : null, ['class' => 'form-control', 'id' => 'bank_name', 'placeholder' => __( 'service.bank_name') ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('bank_code', __( 'service.bank_code') . ':') !!} @show_tooltip(__('service.bank_code_help'))
        {!! Form::text('bank_details[bank_code]', !empty($bank_details['bank_code']) ? $bank_details['bank_code'] : null, ['class' => 'form-control', 'id' => 'bank_code', 'placeholder' => __( 'service.bank_code') ]); !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-3">
        {!! Form::label('branch', __( 'service.branch') . ':') !!}
        {!! Form::text('bank_details[branch]', !empty($bank_details['branch']) ? $bank_details['branch'] : null, ['class' => 'form-control', 'id' => 'branch', 'placeholder' => __( 'service.branch') ]); !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('tax_payer_id', __( 'service.tax_payer_id') . ':') !!}
        @show_tooltip(__('service.tax_payer_id_help'))
        {!! Form::text('bank_details[tax_payer_id]', !empty($bank_details['tax_payer_id']) ? $bank_details['tax_payer_id'] : null, ['class' => 'form-control', 'id' => 'tax_payer_id', 'placeholder' => __( 'service.tax_payer_id') ]); !!}
    </div>
</div>