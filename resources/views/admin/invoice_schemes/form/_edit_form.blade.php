<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
  <div class="option-div-group">
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <div class="option-div  @if($model->scheme_type == 'blank') {{ 'active'}} @endif">
            <h4>FORMAT: <br>XXXX <i class="fa fa-check-circle float-right icon"></i></h4>
            {!! Form::radio('scheme_type', 'blank'); !!}
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <div class="option-div  @if($model->scheme_type == 'year') {{ 'active'}} @endif">
            <h4>FORMAT: <br>{{ date('Y') }}-XXXX <i class="fa fa-check-circle float-right icon"></i></h4>
            {!! Form::radio('scheme_type', 'year'); !!}
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>@lang('invoice.preview'):</label>
          <div id="preview_format">@lang('invoice.not_selected')</div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        {!! Form::label('name', __( 'invoice.name' ) . ':*') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'invoice.name' ) ]); !!}
      </div>
    </div>
  </div>
  <div id="invoice_format_settings">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          {!! Form::label('prefix', __( 'invoice.prefix' ) . ':') !!}
          <div class="form-group-feedback form-group-feedback-right">
             @php
                  $disabled = '';
                  $prefix = $model->prefix;
                  if( $model->scheme_type == 'year'){
                    $prefix = date('Y') . '-';
                    $disabled = 'disabled';
                  }
                @endphp
            {!! Form::text('prefix', $prefix, ['class' => 'form-control', 'placeholder' => '', $disabled]); !!}
            <div class="form-control-feedback form-control-feedback-sm">
              <i class="fa fa-info"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          {!! Form::label('start_number', __( 'invoice.start_number' ) . ':') !!}
          <div class="form-group-feedback form-group-feedback-right">
            {!! Form::number('start_number', 0, ['class' => 'form-control', 'required', 'min' => 0 ]); !!}
            <div class="form-control-feedback form-control-feedback-sm">
              <i class="fa fa-info"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          {!! Form::label('total_digits', __( 'invoice.total_digits' ) . ':') !!}
          <div class="form-group-feedback form-group-feedback-right">
            {!! Form::select('total_digits', ['4' => '4', '5' => '5', '6' => '6', '7' => '7',
            '8' => '8', '9'=>'9', '10' => '10'], 4, ['class' => 'form-control select', 'required']); !!}
            <div class="form-control-feedback form-control-feedback-sm">
              <i class="fa fa-balance-scale"></i>
            </div>
          </div>
        </div>
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

<script>
  _componentUniform();
</script>