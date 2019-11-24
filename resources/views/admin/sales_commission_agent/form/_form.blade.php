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
                {!! Form::label('email', __( 'business.email' )) !!}
                {!! Form::email('email', null, [
                'class' => 'form-control',
                'placeholder' => __( 'business.email' ),
                'data-parsley-type-message' => __('validation.email', ['attribute' => __('business.email')]),
                ]); !!}
            </div>
        </div>
    </div>
      <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('contact_no', __( 'service.contact_no' )) !!}
                {!! Form::number('contact_no', null, [
                'class' => 'form-control',
                'placeholder' => __( 'service.contact_no' ),
                ]); !!}
            </div>
        </div>
    </div>
      <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('address', __( 'service.address' )) !!}
                {!! Form::textarea('address', null, [
                'class' => 'form-control',
                'placeholder' => __( 'service.address' ),
                'style' => 'resize: none;',
                'rows' => 3
                ]); !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('cmmsn_percent', __( 'service.cmmsn_percent' ), ['class' => 'required']) !!}
                {!! Form::number('cmmsn_percent', null, [
                'class' => 'form-control',
                'placeholder' => __( 'service.cmmsn_percent' ),
                'step' => 0.01,
                'required',
                'data-parsley-type' => 'number',
                'data-parsley-type-message' => __('validation.numeric', ['attribute' => __('service.cmmsn_percent')]),
                ]); !!}
            </div>
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-md-12">
            {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
            <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
        </div>
    </div>
</fieldset>