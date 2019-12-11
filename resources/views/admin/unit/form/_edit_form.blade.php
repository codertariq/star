<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
  <div class="row">
    <div class="form-group col-sm-12">
      {!! Form::label('actual_name', __( 'unit.name' ), ['class' => 'required']) !!}
      {!! Form::text('actual_name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'unit.name' )]); !!}
    </div>
    <div class="form-group col-sm-12">
      {!! Form::label('short_name', __( 'unit.short_name' ), ['class' => 'required']) !!}
      {!! Form::text('short_name', null, ['class' => 'form-control', 'placeholder' => __( 'unit.short_name' ), 'required']); !!}
    </div>
    <div class="form-group col-sm-12">
      {!! Form::label('allow_decimal', __( 'unit.allow_decimal' ), ['class' => 'required']) !!}
      {!! Form::select('allow_decimal', ['1' => __('messages.yes'), '0' => __('messages.no')], null, ['data-placeholder' => __( 'messages.please_select' ), 'required', 'class' => 'form-control select']); !!}
    </div>
    <div class="form-group col-sm-12">
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          {!! Form::checkbox('define_base_unit', 1 , !empty($model->base_unit_id),[ 'class' => 'form-check-input-styled toggler', 'data-toggle_id' => 'base_unit_div', 'data-fouc']) !!}@lang( 'service.add_as_multiple_of_base_unit' )
        </label> @show_tooltip(__('service.multi_unit_help'))
      </div>
    </div>
    <div class="form-group col-sm-12  @if(empty($model->base_unit_id)) hide @endif" id="base_unit_div">
      <table class="table">
        <tr>
          <th style="vertical-align: middle;">1 <span id="unit_name">@lang('product.unit')</span></th>
          <th style="vertical-align: middle;">=</th>
          <td style="vertical-align: middle;">
          {!! Form::text('base_unit_multiplier', null, ['class' => 'form-control input_number', 'placeholder' => __( 'service.times_base_unit' )]); !!}</td>
          <td style="vertical-align: middle;">
            {!! Form::select('base_unit_id', $units, null, ['data-placeholder' => __( 'service.select_base_unit' ), 'class' => 'form-control select']); !!}
          </td>
        </tr>
        <tr>
          <td colspan="4" style="padding-top: 0;">
          <p class="help-block">*@lang('service.edit_multi_unit_help_text')</p>
        </td>
        </tr>
        </table>
      </div>
    </div>
    <div class="form-group row text-center">
      <div class="col-md-12">
        {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
        <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
      </div>
    </div>
  </fieldset>