<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        {!! Form::label('name', __( 'category.category_name' ) , ['class' => 'required']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'category.category_name' )]); !!}
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        {!! Form::label('short_code', __( 'category.code' ) . ':') !!}
        {!! Form::text('short_code', null, ['class' => 'form-control', 'placeholder' => __( 'category.code' )]); !!}
        <p class="help-block">{!! __('service.category_code_help') !!}</p>
      </div>
    </div>
    @if(!empty($parent_categories))
    <div class="col-md-12">
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          {!! Form::checkbox('add_as_sub_cat', 1 , $is_parent,[ 'class' => 'form-check-input-styled toggler', 'data-toggle_id' => 'parent_cat_div', 'data-fouc']) !!}@lang( 'category.add_as_sub_category' )
        </label>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group @if(!$is_parent) {{'hide' }} @endif" id="parent_cat_div">
        {!! Form::label('parent_id', __( 'category.select_parent_category' ) . ':') !!}
        {!! Form::select('parent_id', $parent_categories, $selected_parent, ['class' => 'form-control select']); !!}
      </div>
    </div>
    @endif
  </div>
  <div class="form-group row text-center">
    <div class="col-md-12">
      {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
      <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
    </div>
  </div>
</fieldset>