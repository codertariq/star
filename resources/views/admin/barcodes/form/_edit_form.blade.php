<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        {!! Form::label('name', __('barcode.setting_name') , ['class' => 'required']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required',
        'placeholder' => __('barcode.setting_name')]); !!}
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        {!! Form::label('description', __('barcode.setting_description') ) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control',
        'placeholder' => __('barcode.setting_description'), 'rows' => 3]); !!}
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        <div class="checkbox">
          <label>
          {!! Form::checkbox('is_continuous', 1, $model->is_continuous, ['id' => 'is_continuous']); !!} @lang('barcode.is_continuous')</label>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        {!! Form::label('top_margin', __('barcode.top_margin') . ' ('. __('barcode.in_in') . ')', ['class' => 'required']) !!}
        <div class="input-group">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
          </span>
          {!! Form::number('top_margin', $model->top_margin, ['class' => 'form-control',
          'placeholder' => __('barcode.top_margin'), 'min' => 0, 'step' => 0.00001, 'required']); !!}
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        {!! Form::label('left_margin', __('barcode.left_margin') . ' ('. __('barcode.in_in') . ')', ['class' => 'required']) !!}
        <div class="input-group">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
          </span>
          {!! Form::number('left_margin', $model->left_margin, ['class' => 'form-control',
          'placeholder' => __('barcode.left_margin'), 'min' => 0, 'step' => 0.00001, 'required']); !!}
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-6">
      <div class="form-group">
        {!! Form::label('width', __('barcode.width') . ' ('. __('barcode.in_in') . ')', ['class' => 'required']) !!}
        <div class="form-group-feedback form-group-feedback-right">
          {!! Form::number('width', $model->width, ['class' => 'form-control',
          'placeholder' => __('barcode.width'), 'min' => 0.1, 'step' => 0.00001, 'required']); !!}
          <div class="form-control-feedback form-control-feedback-sm">
            <i class="fa fa-text-width"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        {!! Form::label('height', __('barcode.height') . ' ('. __('barcode.in_in') . ')', ['class' => 'required']) !!}
        <div class="form-group-feedback form-group-feedback-right">
          {!! Form::number('height', null, ['class' => 'form-control',
          'placeholder' => __('barcode.height'), 'min' => 0.1, 'step' => 0.00001, 'required']); !!}
          <div class="form-control-feedback form-control-feedback-sm">
            <i class="fa fa-text-height"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-6">
      <div class="form-group">
        {!! Form::label('paper_width', __('barcode.paper_width') . ' ('. __('barcode.in_in') . ')', ['class' => 'required']) !!}
        <div class="form-group-feedback form-group-feedback-right">
          {!! Form::number('paper_width', null, ['class' => 'form-control',
          'placeholder' => __('barcode.paper_width'), 'min' => 0.1, 'step' => 0.00001, 'required']); !!}
          <div class="form-control-feedback form-control-feedback-sm">
            <i class="fa fa-text-width"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 paper_height_div @if( $model->is_continuous ) hide @endif">
      <div class="form-group">
        {!! Form::label('paper_height', __('barcode.paper_height') . ' ('. __('barcode.in_in') . ')', ['class' => 'required']) !!}
        <div class="form-group-feedback form-group-feedback-right">
          {!! Form::number('paper_height', null, ['class' => 'form-control',
          'placeholder' => __('barcode.paper_height'), 'min' => 0.1, 'step' => 0.00001, 'required']); !!}
          <div class="form-control-feedback form-control-feedback-sm">
            <i class="fa fa-text-height"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        {!! Form::label('stickers_in_one_row', __('barcode.stickers_in_one_row') , ['class' => 'required']) !!}
        <div class="form-group-feedback form-group-feedback-right">
          {!! Form::number('stickers_in_one_row', null, ['class' => 'form-control',
          'placeholder' => __('barcode.stickers_in_one_row'), 'min' => 1, 'required']); !!}
          <div class="form-control-feedback form-control-feedback-sm">
            <i class="fa fa-ellipsis-h"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-6">
      <div class="form-group">
        {!! Form::label('row_distance', __('barcode.row_distance') . ' ('. __('barcode.in_in') . ')', ['class' => 'required']) !!}
        <div class="form-group-feedback form-group-feedback-right">
          {!! Form::number('row_distance', $model->row_distance, ['class' => 'form-control',
          'placeholder' => __('barcode.row_distance'), 'min' => 0, 'step' => 0.00001, 'required']); !!}
          <div class="form-control-feedback form-control-feedback-sm">
            <i class="icon-arrow-resize8"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        {!! Form::label('col_distance', __('barcode.col_distance') . ' ('. __('barcode.in_in') . ')', ['class' => 'required']) !!}
        <div class="form-group-feedback form-group-feedback-right">
          {!! Form::number('col_distance', $model->col_distance, ['class' => 'form-control',
          'placeholder' => __('barcode.col_distance'), 'min' => 0, 'step' => 0.00001, 'required']); !!}
          <div class="form-control-feedback form-control-feedback-sm">
            <i class="icon-arrow-resize7"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-6 stickers_per_sheet_div @if( $model->is_continuous ) {{ 'hide' }} @endif">
      <div class="form-group">
        {!! Form::label('stickers_in_one_sheet', __('barcode.stickers_in_one_sheet') , ['class' => 'required']) !!}
        <div class="form-group-feedback form-group-feedback-right">
          {!! Form::number('stickers_in_one_sheet', null, ['class' => 'form-control',
          'placeholder' => __('barcode.stickers_in_one_sheet'), 'min' => 1, 'required']); !!}
          <div class="form-control-feedback form-control-feedback-sm">
            <i class="fa fa-th"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

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