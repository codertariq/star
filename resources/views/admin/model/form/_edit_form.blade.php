<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group row">
        {!! Form::label('category_id',__('category.categories') , ['class' => 'col-sm-3 control-label required']) !!}
        <div class="col-sm-9">
          {!! Form::select('category_id', $categories, null, ['class' => 'form-control select', 'required', 'data-placeholder' => __('category.categories')]); !!}
        </div>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group row">
        {!! Form::label('brand_id',__('brand.brands') , ['class' => 'col-sm-3 control-label required']) !!}
        <div class="col-sm-9">
          {!! Form::select('brand_id', $brands, null, ['class' => 'form-control select', 'required', 'data-placeholder' => __('brand.brands')]); !!}
        </div>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group row">
        {!! Form::label('name',__('page.model') , ['class' => 'col-sm-3 control-label required']) !!}
        <div class="col-sm-9">
           {!! Form::text('name', null, ['class' => 'form-control', 'required']); !!}
        </div>
      </div>
    </div>
  </div>
  <div id="variation_values"></div>
  <div class="form-group row text-center">
    <div class="col-md-12">
      {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
      <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
    </div>
  </div>
</fieldset>