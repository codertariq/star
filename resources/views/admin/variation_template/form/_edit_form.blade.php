<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group row">
        {!! Form::label('name',__('service.variation_name') , ['class' => 'col-sm-3 control-label required']) !!}

        <div class="col-sm-9">
          {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('service.variation_name')]); !!}
        </div>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group row">
        {!! Form::label('name',__('service.variation_name') , ['class' => 'col-sm-3 control-label required']) !!}
        @foreach( $model->values as $attr)
          @if( $loop->first )
            <div class="col-sm-7">
              {!! Form::text('edit_variation_values[' . $attr->id . ']', $attr->name, ['class' => 'form-control', 'required']); !!}
            </div>
          @endif
        @endforeach
        <div class="col-sm-2">
          <button type="button" class="btn btn-primary" id="add_variation_values">+</button>
        </div>
      </div>
    </div>
  </div>
  <div id="variation_values">
    @foreach( $model->values as $attr)
          @if( !$loop->first )
            <div class="form-group row">
              <div class="col-sm-7 ml-auto">
                {!! Form::text('edit_variation_values[' . $attr->id . ']', $attr->name, ['class' => 'form-control', 'required']); !!}
              </div>
              <div class="col-sm-2">
              </div>
            </div>
          @endif
        @endforeach
  </div>
  <div class="form-group row text-center">
    <div class="col-md-12">
      {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
      <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
    </div>
  </div>
</fieldset>