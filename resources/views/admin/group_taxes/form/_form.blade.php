<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        {!! Form::label('name', __( 'tax_rate.name' ), ['class' => 'required']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'tax_rate.name' ) ]); !!}
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        {!! Form::label('taxes[]', __( 'tax_rate.sub_taxes' ) . ':', ['class' => 'required']) !!}
        {!! Form::select('taxes[]', $taxes, null, ['class' => 'form-control select', 'required', 'multiple']); !!}
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