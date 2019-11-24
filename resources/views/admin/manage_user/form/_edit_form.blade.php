<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('prefix', __( 'business.prefix' )) !!}
                {!! Form::text('prefix', null, ['class' => 'form-control', 'placeholder' => __( 'business.prefix_placeholder' ) ]); !!}
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                {!! Form::label('first_name', __( 'business.first_name' ), ['class' => 'required']) !!}
                {!! Form::text('first_name', null, [
                'class' => 'form-control',
                'required',
                'placeholder' => __( 'business.first_name' ),
                'data-parsley-required-message' => __('validation.required', ['attribute' => __('business.first_name')]),
                ]); !!}
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                {!! Form::label('last_name', __( 'business.last_name' )) !!}
                {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __( 'business.last_name' ) ]); !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('email', __( 'business.email' ) , ['class' => 'required']) !!}
                {!! Form::email('email', null, [
                'class' => 'form-control',
                'required',
                'placeholder' => __( 'business.email' ),
                'data-parsley-required-message' => __('validation.required', ['attribute' => __('business.email')]),
                'data-parsley-type-message' => __('validation.email', ['attribute' => __('business.email')]),
                ]); !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('role', __( 'user.role' ) , ['class' => 'required']) !!}
                {!! Form::select('role', $roles, $model->roles->first()->id, [
                'class' => 'form-control select',
                'data-parsley-required-message' => __('validation.required', ['attribute' => __('user.role')]),
                'data-parsley-errors-container'=>"#error_role_container"
                ]) !!}
                <span id="error_role_container"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('username', __( 'business.username' )) !!}
                @if(!empty($username_ext))
                <div class="input-group">
                    {!! Form::text('username', null, [
                    'class' => 'form-control',
                    'placeholder' => __( 'business.username' ),
                    'required',
                    'data-parsley-required-message' => __('validation.required', ['attribute' => __('business.username')]),
                    ]); !!}
                    <span class="input-group-addon">{{$username_ext}}</span>
                </div>
                <p class="help-block" id="show_username"></p>
                @else
                {!! Form::text('username', null, [
                'class' => 'form-control',
                'placeholder' => __( 'business.username' ),
                'autocomplete' => 'username',
                'data-parsley-required-message' => __('validation.required', ['attribute' => __('business.username')]),
                ]); !!}
                @endif
                <p class="help-block">@lang('service.username_help')</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('password', __( 'business.password' )) !!}
                {!! Form::password('password', [
                'class' => 'form-control',
                'placeholder' => __( 'business.password' ),
                'autocomplete' => 'new-password',
                'data-parsley-minlength-message' => __('validation.min.string', ['attribute' => __('business.confirm_password'), 'min' => 6]),
                'minlength' => 6,
                ]); !!}
                 <p class="help-block">@lang('user.leave_password_blank')</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('confirm_password', __( 'business.confirm_password' )) !!}
                {!! Form::password('confirm_password', [
                'class' => 'form-control',
                'placeholder' => __( 'business.confirm_password' ),
                'data-parsley-minlength-message' => __('validation.min.string', ['attribute' => __('business.confirm_password'), 'min' => 6]),
                'data-parsley-equalto-message' => __('validation.confirmed', ['attribute' => __('business.password')]),
                'minlength' => 6,
                'data-parsley-equalTo' => '#password',
                ]); !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('cmmsn_percent', __( 'service.cmmsn_percent' )) !!} @show_tooltip(__('service.commsn_percent_help'))
                {!! Form::number('cmmsn_percent', null, [
                    'class' => 'form-control',
                    'placeholder' => __( 'service.cmmsn_percent' ),
                     'step' => 0.01,
                     'data-parsley-type' => 'number',
                     'data-parsley-type-message' => __('validation.numeric', ['attribute' => __('service.cmmsn_percent')]),
                     ]); !!}
            </div>
        </div>
        <div class="col-md-2 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('selected_contacts', 1,  $model->selected_contacts,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'selected_contacts']) !!}  {{ __( 'service.allow_selected_contacts' ) }}
                </label>
                @show_tooltip(__('service.allow_selected_contacts_tooltip'))
            </div>
        </div>
        <div class="col-md-6 hide selected_contacts_div" @if(isset($model) and $model->selected_contacts) @else style="display: none; " @endif >
            <div class="form-group">
                {!! Form::label('selected_contact_ids', __('service.selected_contacts')) !!}
                <div class="form-group">
                    {!! Form::select('selected_contact_ids[]', $contacts, null, ['class' => 'form-control select', 'multiple' ]); !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('is_active', 'active', $is_checked_checkbox,
                    [ 'class' => 'form-check-input-styled']) !!}  {{ __('service.status_for_user') }}
                </label>

                @show_tooltip(__('service.tooltip_enable_user_active'))
            </div>
        </div>
    </div>
    <legend class="text-uppercase font-size-sm font-weight-bold"> {{ __('service.more_info') }}</legend>
    @include('admin.user.form', ['bank_details' => !empty($model->bank_details) ? json_decode($model->bank_details, true) : null])
    <div class="form-group row text-center">
        <div class="col-md-12">
            {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
            <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
        </div>
    </div>
</fieldset>