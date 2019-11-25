<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
    <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('name', __( 'invoice.name' ), ['class' => 'required']) !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'invoice.name' ) ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('location_id', __( 'service.location_id' ) . ':') !!}
              {!! Form::text('location_id', null, ['class' => 'form-control', 'placeholder' => __( 'service.location_id' ) ]); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('landmark', __( 'business.landmark' ) . ':') !!}
              {!! Form::text('landmark', null, ['class' => 'form-control', 'placeholder' => __( 'business.landmark' ) ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('city', __( 'business.city' ), ['class' => 'required']) !!}
              {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => __( 'business.city'), 'required' ]); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('zip_code', __( 'business.zip_code' ), ['class' => 'required']) !!}
              {!! Form::text('zip_code', null, ['class' => 'form-control', 'placeholder' => __( 'business.zip_code'), 'required' ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('state', __( 'business.state' ), ['class' => 'required']) !!}
              {!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => __( 'business.state'), 'required' ]); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('country', __( 'business.country' ), ['class' => 'required']) !!}
              {!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => __( 'business.country'), 'required' ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('mobile', __( 'business.mobile' ) . ':') !!}
            {!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => __( 'business.mobile')]); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('alternate_number', __( 'business.alternate_number' ) . ':') !!}
            {!! Form::text('alternate_number', null, ['class' => 'form-control', 'placeholder' => __( 'business.alternate_number')]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('email', __( 'business.email' ) . ':') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __( 'business.email')]); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('website', __( 'service.website' ) . ':') !!}
            {!! Form::text('website', null, ['class' => 'form-control', 'placeholder' => __( 'service.website')]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('invoice_scheme_id', __('invoice.invoice_scheme'), ['class' => 'required']) !!} @show_tooltip(__('tooltip.invoice_scheme'))
              {!! Form::select('invoice_scheme_id', $invoice_schemes, null, ['class' => 'form-control select', 'required',
              'placeholder' => __('messages.please_select')]); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('invoice_layout_id', __('invoice.invoice_layout'), ['class' => 'required']) !!} @show_tooltip(__('tooltip.invoice_layout'))
              {!! Form::select('invoice_layout_id', $invoice_layouts, null, ['class' => 'form-control select', 'required',
              'placeholder' => __('messages.please_select')]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-12">
        <hr/>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('custom_field1', __('service.custom_field', ['number' => 1]) . ':') !!}
            {!! Form::text('custom_field1', null, ['class' => 'form-control',
                'placeholder' => __('service.custom_field', ['number' => 1])]); !!}
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('custom_field2', __('service.custom_field', ['number' => 2]) . ':') !!}
            {!! Form::text('custom_field2', null, ['class' => 'form-control',
                'placeholder' => __('service.custom_field', ['number' => 2])]); !!}
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('custom_field3', __('service.custom_field', ['number' => 3]) . ':') !!}
            {!! Form::text('custom_field3', null, ['class' => 'form-control',
                'placeholder' => __('service.custom_field', ['number' => 3])]); !!}
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('custom_field4', __('service.custom_field', ['number' => 4]) . ':') !!}
            {!! Form::text('custom_field4', null, ['class' => 'form-control',
                'placeholder' => __('service.custom_field', ['number' => 4])]); !!}
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