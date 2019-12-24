{!! Form::open(['url' => route('admin.opening-stock.store'), 'method' => 'post', 'id' => 'content_form' ]) !!}
<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{ __('service.add_opening_stock') }}</legend>
{!! Form::hidden('product_id', $product->id); !!}
	@include('admin.opening_stock.form-part')
	<div class="form-group row text-center">
    <div class="col-md-12">
      {{ Form::submit(__('messages.save'), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
      <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close') }} </button>
    </div>
  </div>
</fieldset>
{!! Form::close() !!}