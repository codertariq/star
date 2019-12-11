@php
$form_id = 'content_form';
if(isset($quick_add)){
$form_id = 'quick_add_contact';
}

$data['page'] = __('page.contact');
$data['route'] = 'admin.group-taxes.';
@endphp
{!! Form::open(['url' => route('admin.contacts.store'), 'method' => 'post', 'id' => $form_id ]) !!}
<div class="row">
  <div class="col-md-6 contact_type_div">
    <div class="form-group">
      {!! Form::label('contact_type', __('contact.contact_type'), ['class' => 'required'] ) !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::select('type', $types, $type , ['class' => 'form-control select', 'id' => 'contact_type','data-placeholder' => __('messages.please_select'), 'required']); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-user"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      {!! Form::label('name', __('contact.name'), ['class' => 'required']) !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('name', null, ['class' => 'form-control','placeholder' => __('contact.name'), 'required']); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-user"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-4 supplier_fields">
    <div class="form-group">
      {!! Form::label('supplier_business_name', __('business.business_name'), ['class' => 'required']) !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('supplier_business_name', null, ['class' => 'form-control', 'required', 'placeholder' => __('business.business_name')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-briefcase"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('contact_id', __('service.contact_id') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('contact_id', null, ['class' => 'form-control','placeholder' => __('service.contact_id')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-id-badge"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('tax_number', __('contact.tax_no') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('tax_number', null, ['class' => 'form-control', 'placeholder' => __('contact.tax_no')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-info"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('opening_balance', __('service.opening_balance') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('opening_balance', 0, ['class' => 'form-control input_number']); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-money-bill-alt"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('pay_term_number', __('contact.pay_term') . ':') !!} @show_tooltip(__('tooltip.pay_term'))
      <div class="input-group">
        {!! Form::number('pay_term_number', null, ['class' => 'form-control width-40 pull-left', 'placeholder' => __('contact.pay_term')]); !!}
        <span class="input-group-append">
          {!! Form::select('pay_term_type', ['months' => __('service.months'), 'days' => __('service.days')], '', ['class' => 'form-control select width-60 pull-left','data-placeholder' => __('messages.please_select')]); !!}
        </span>
      </div>
    </div>
  </div>
  <div class="col-md-4 customer_fields">
    <div class="form-group">
      {!! Form::label('customer_group_id', __('service.customer_group') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::select('customer_group_id', $customer_groups, '', ['class' => 'form-control select']); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-users"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4 customer_fields">
    <div class="form-group">
      {!! Form::label('credit_limit', __('service.credit_limit') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('credit_limit', null, ['class' => 'form-control input_number']); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-money-bill-alt"></i>
        </div>
      </div>
      <p class="help-block">@lang('service.credit_limit_help')</p>
    </div>
  </div>
  <div class="col-md-12">
    <hr/>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('email', __('business.email') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::email('email', null, ['class' => 'form-control','placeholder' => __('business.email')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-envelope"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('mobile', __('contact.mobile'), ['class' => 'required']) !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('mobile', null, ['class' => 'form-control', 'required', 'placeholder' => __('contact.mobile')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-mobile"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('alternate_number', __('contact.alternate_contact_number') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('alternate_number', null, ['class' => 'form-control', 'placeholder' => __('contact.alternate_contact_number')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-phone"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('landline', __('contact.landline') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('landline', null, ['class' => 'form-control', 'placeholder' => __('contact.landline')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-phone"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('city', __('business.city') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('business.city')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-map-marker"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('state', __('business.state') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('business.state')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-map-marker"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('country', __('business.country') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => __('business.country')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-globe"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('landmark', __('business.landmark') . ':') !!}
      <div class="form-group-feedback form-group-feedback-right">
        {!! Form::text('landmark', null, ['class' => 'form-control',
        'placeholder' => __('business.landmark')]); !!}
        <div class="form-control-feedback form-control-feedback-sm">
          <i class="fa fa-map-marker"></i>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row @if(isset($quick_add)) hide @endif">
  <div class="clearfix"></div>
  <div class="col-md-12">
    <hr/>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('custom_field1', __('service.custom_field', ['number' => 1]) . ':') !!}
      {!! Form::text('custom_field1', null, ['class' => 'form-control',
      'placeholder' => __('service.custom_field', ['number' => 1])]); !!}
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('custom_field2', __('service.custom_field', ['number' => 2]) . ':') !!}
      {!! Form::text('custom_field2', null, ['class' => 'form-control',
      'placeholder' => __('service.custom_field', ['number' => 2])]); !!}
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('custom_field3', __('service.custom_field', ['number' => 3]) . ':') !!}
      {!! Form::text('custom_field3', null, ['class' => 'form-control',
      'placeholder' => __('service.custom_field', ['number' => 3])]); !!}
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      {!! Form::label('custom_field4', __('service.custom_field', ['number' => 4]) . ':') !!}
      {!! Form::text('custom_field4', null, ['class' => 'form-control',
      'placeholder' => __('service.custom_field', ['number' => 4])]); !!}
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
{!! Form::close() !!}
<script>
  _componentSelect2();
  _componentTooltipCustomColor();
$(document).ready(function() {
    //On display of add contact modal
    if ($('select#contact_type').val() == 'customer') {
        $('div.supplier_fields').hide();
        $('#supplier_business_name').attr('disabled', true);
        $('div.customer_fields').show();
    } else if ($('select#contact_type').val() == 'supplier') {
        $('div.supplier_fields').show();
         $('#supplier_business_name').attr('disabled', false);
        $('div.customer_fields').hide();
    }
    $('select#contact_type').change(function() {
        var t = $(this).val();
        if (t == 'supplier') {
            $('div.supplier_fields').fadeIn();
             $('#supplier_business_name').attr('disabled', false);
            $('div.customer_fields').fadeOut();
        } else if (t == 'both') {
            $('div.supplier_fields').fadeIn();
             $('#supplier_business_name').attr('disabled', false);
            $('div.customer_fields').fadeIn();
        } else if (t == 'customer') {
            $('div.customer_fields').fadeIn();
             $('#supplier_business_name').attr('disabled', true);
            $('div.supplier_fields').fadeOut();
        }
    });
});

</script>