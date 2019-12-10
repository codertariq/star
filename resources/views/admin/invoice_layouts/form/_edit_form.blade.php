 @php
    $product_custom_fields = !empty($model->product_custom_fields) ? $model->product_custom_fields : [];
    $contact_custom_fields = !empty($model->contact_custom_fields) ? $model->contact_custom_fields : [];
    $location_custom_fields = !empty($model->location_custom_fields) ? $model->location_custom_fields : [];
  @endphp
<fieldset class="mb-3">
  <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($submit) ? $submit : ''}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
  <section class="content">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div class="form-group">
              {!! Form::label('name', __('invoice.layout_name'), ['class' => 'required']) !!}
              {!! Form::text('name', $model->name, ['class' => 'form-control', 'required',
              'placeholder' => __('invoice.layout_name')]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6">
            <div class="form-group">
              {!! Form::label('design', __('service.design'), ['class' => 'required']) !!}
              {!! Form::select('design', $designs, $model->design, ['class' => 'form-control select']); !!}
              <span class="help-block">Used for browser based printing</span>
            </div>
            <div class="form-group  @if($model->design != 'columnize-taxes') hide @endif" id="columnize-taxes">
              <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-3">
                <input type="text" class="form-control"
                name="table_tax_headings[]" required="required"
                placeholder="tax 1 name"
                value="{{$model->table_tax_headings[1]}}"
              @if($model->design != 'columnize-taxes') disabled @endif>
                @show_tooltip(__('service.tooltip_columnize_taxes_heading'))
              </div>
              <div class="col-sm-12 col-md-6 col-lg-3">
                <input type="text" class="form-control"
                name="table_tax_headings[]" placeholder="tax 2 name"
                value="{{$model->table_tax_headings[2]}}"
              @if($model->design != 'columnize-taxes') disabled @endif>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-3">
                <input type="text" class="form-control"
                name="table_tax_headings[]" placeholder="tax 3 name"
                value="{{$model->table_tax_headings[3]}}"
              @if($model->design != 'columnize-taxes') disabled @endif>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-3">
                <input type="text" class="form-control"
                name="table_tax_headings[]" placeholder="tax 4 name"
                disabled>
              </div>
              </div>

            </div>
          </div>
          <!-- Logo -->
          <div class="col-sm-12 col-md-6">
            <div class="form-group">
              {!! Form::label('logo', __('invoice.invoice_logo') ) !!}
              {!! Form::file('logo'); !!}
              <span class="help-block">@lang('service.invoice_logo_help', ['max_size' => '1 MB'])<br> @lang('service.invoice_logo_help2')</span>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_logo', 1, $model->show_logo,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_logo']) !!}  {{ __( 'invoice.show_logo' ) }}
              </label>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              {!! Form::label('header_text', __('invoice.header_text')  ) !!}
              {!! Form::textarea('header_text',$model->header_text, ['class' => 'form-control summernote',
              'placeholder' => __('invoice.header_text'), 'rows' => 3]); !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('sub_heading_line1', __('service.sub_heading_line', ['_number_' => 1])  ) !!}
              {!! Form::text('sub_heading_line1', $model->sub_heading_line1, ['class' => 'form-control',
              'placeholder' => __('service.sub_heading_line', ['_number_' => 1]) ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('sub_heading_line2', __('service.sub_heading_line', ['_number_' => 2])  ) !!}
              {!! Form::text('sub_heading_line2', $model->sub_heading_line2, ['class' => 'form-control',
              'placeholder' => __('service.sub_heading_line', ['_number_' => 2]) ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('sub_heading_line3', __('service.sub_heading_line', ['_number_' => 3])  ) !!}
              {!! Form::text('sub_heading_line3', $model->sub_heading_line3, ['class' => 'form-control',
              'placeholder' => __('service.sub_heading_line', ['_number_' => 3]) ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('sub_heading_line4', __('service.sub_heading_line', ['_number_' => 4])  ) !!}
              {!! Form::text('sub_heading_line4', $model->sub_heading_line4, ['class' => 'form-control',
              'placeholder' => __('service.sub_heading_line', ['_number_' => 4]) ]); !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('sub_heading_line5', __('service.sub_heading_line', ['_number_' => 5])  ) !!}
              {!! Form::text('sub_heading_line5', $model->sub_heading_line5, ['class' => 'form-control',
              'placeholder' => __('service.sub_heading_line', ['_number_' => 5]) ]); !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('invoice_heading', __('invoice.invoice_heading')  ) !!}
              {!! Form::text('invoice_heading', $model->invoice_heading, ['class' => 'form-control',
              'placeholder' => __('invoice.invoice_heading') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('invoice_heading_not_paid', __('invoice.invoice_heading_not_paid')  ) !!}
              {!! Form::text('invoice_heading_not_paid', $model->invoice_heading_not_paid, ['class' => 'form-control',
              'placeholder' => __('invoice.invoice_heading_not_paid') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('invoice_heading_paid', __('invoice.invoice_heading_paid')  ) !!}
              {!! Form::text('invoice_heading_paid', $model->invoice_heading_paid, ['class' => 'form-control',
              'placeholder' => __('invoice.invoice_heading_paid') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('quotation_heading', __('service.quotation_heading')  ) !!}
              @show_tooltip(__('service.tooltip_quotation_heading'))
              {!! Form::text('quotation_heading', $model->quotation_heading, ['class' => 'form-control',
              'placeholder' => __('service.quotation_heading') ]); !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('invoice_no_prefix', __('invoice.invoice_no_prefix')  ) !!}
              {!! Form::text('invoice_no_prefix', $model->invoice_no_prefix, ['class' => 'form-control',
              'placeholder' => __('invoice.invoice_no_prefix') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('quotation_no_prefix', __('service.quotation_no_prefix')  ) !!}
              {!! Form::text('quotation_no_prefix', $model->quotation_no_prefix, ['class' => 'form-control',
              'placeholder' => __('service.quotation_no_prefix') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('date_label', __('service.date_label')  ) !!}
              {!! Form::text('date_label', $model->date_label, ['class' => 'form-control',
              'placeholder' => __('service.date_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('date_time_format', __('service.date_time_format')  ) !!}
              {!! Form::text('date_time_format', $model->date_time_format, ['class' => 'form-control',
              'placeholder' => __('service.date_time_format') ]); !!}
              <p class="help-block">{!! __('service.date_time_format_help') !!}</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('sales_person_label', __('service.sales_person_label')  ) !!}
              {!! Form::text('sales_person_label', $model->sales_person_label, ['class' => 'form-control',
              'placeholder' => __('service.sales_person_label') ]); !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_business_name', 1, $model->show_business_name,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_business_name']) !!}   @lang('invoice.show_business_name')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_location_name', 1, $model->show_location_name,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_location_name']) !!}   @lang('invoice.show_location_name')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_sales_person', 1, $model->show_sales_person,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_sales_person']) !!}   @lang('invoice.show_sales_person')
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <h4>@lang('service.fields_for_customer_details'):</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_customer', 1, $model->show_customer,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_customer']) !!}   @lang('invoice.show_customer')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('customer_label', __('invoice.customer_label')  ) !!}
              {!! Form::text('customer_label', $model->customer_label, ['class' => 'form-control',
              'placeholder' => __('invoice.customer_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_client_id', $model->show_client_id, false,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_client_id']) !!}   @lang('service.show_client_id')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('client_id_label', __('service.client_id_label')  ) !!}
              {!! Form::text('client_id_label', $model->client_id_label, ['class' => 'form-control',
              'placeholder' => __('service.client_id_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('client_tax_label', __('service.client_tax_label')  ) !!}
              {!! Form::text('client_tax_label', $model->client_tax_label, ['class' => 'form-control',
              'placeholder' => __('service.client_tax_label') ]); !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('contact_custom_fields[]', 'custom_field1', in_array('custom_field1', $contact_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'contact_custom_fields']) !!}    @lang('service.custom_field', ['number' => 1])
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('contact_custom_fields[]', 'custom_field2', in_array('custom_field2', $contact_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'contact_custom_fields']) !!}    @lang('service.custom_field', ['number' => 2])
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('contact_custom_fields[]', 'custom_field3', in_array('custom_field3', $contact_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'contact_custom_fields']) !!}    @lang('service.custom_field', ['number' => 3])
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('contact_custom_fields[]', 'custom_field4', in_array('custom_field4', $contact_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'contact_custom_fields']) !!}    @lang('service.custom_field', ['number' => 4])
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <h4>@lang('invoice.fields_to_be_shown_in_address'):</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_landmark', 1, $model->show_landmark,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_landmark']) !!}   @lang('business.landmark')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_city', 1, $model->show_city,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_city']) !!}   @lang('business.city')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_state', 1, $model->show_state,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_state']) !!}   @lang('business.state')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_country', 1, $model->show_country,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_country']) !!}   @lang('business.country')
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_zip_code', 1, $model->show_zip_code,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_zip_code']) !!}   @lang('business.zip_code')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('location_custom_fields[]', 'custom_field1', in_array('custom_field1', $location_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'location_custom_fields']) !!}    @lang('service.custom_field', ['number' => 1])
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('contact_custom_fieldslocation_custom_fields[]', 'custom_field2', in_array('custom_field2', $location_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'location_custom_fields']) !!}    @lang('service.custom_field', ['number' => 2])
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('location_custom_fields[]', 'custom_field3', in_array('custom_field3', $location_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'location_custom_fields']) !!}    @lang('service.custom_field', ['number' => 3])
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('location_custom_fields[]', 'custom_field4', in_array('custom_field4', $location_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'location_custom_fields']) !!}    @lang('service.custom_field', ['number' => 4])
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Shop Communication details -->
          <div class="col-sm-12">
            <h4>@lang('invoice.fields_to_shown_for_communication'):</h4>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_mobile_number', 1, $model->show_mobile_number,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_mobile_number']) !!}   @lang('invoice.show_mobile_number')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_alternate_number', 1, $model->show_alternate_number,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_alternate_number']) !!}   @lang('invoice.show_alternate_number')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_email', 1, $model->show_email,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_email']) !!}   @lang('invoice.show_email')
              </label>
            </div>
          </div>
          <div class="col-sm-12">
            <h4>@lang('invoice.fields_to_shown_for_tax'):</h4>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_tax_1', 1,  $model->show_tax_1,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_tax_1']) !!}   @lang('invoice.show_tax_1')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_tax_2', 1, $model->show_tax_2,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_tax_2']) !!}   @lang('invoice.show_tax_2')
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('table_product_label', __('service.product_label')  ) !!}
              {!! Form::text('table_product_label', $model->table_product_label, ['class' => 'form-control',
              'placeholder' => __('service.product_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('table_qty_label', __('service.qty_label')  ) !!}
              {!! Form::text('table_qty_label', $model->table_qty_label, ['class' => 'form-control',
              'placeholder' => __('service.qty_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('table_unit_price_label', __('service.unit_price_label')  ) !!}
              {!! Form::text('table_unit_price_label', $model->table_unit_price_label, ['class' => 'form-control',
              'placeholder' => __('service.unit_price_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('table_subtotal_label', __('service.subtotal_label')  ) !!}
              {!! Form::text('table_subtotal_label', $model->table_subtotal_label, ['class' => 'form-control',
              'placeholder' => __('service.subtotal_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('cat_code_label', __('service.cat_code_label')  ) !!}
              {!! Form::text('cat_code_label', $model->cat_code_label, ['class' => 'form-control',
              'placeholder' => 'HSN or Category Code' ]); !!}
            </div>
          </div>
          <div class="col-sm-12">
            <h4>@lang('service.product_details_to_be_shown'):</h4>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_brand', 1, $model->show_brand,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_brand']) !!}   @lang('service.show_brand')
              </label>
            </div>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_sku', 1, $model->show_sku,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_sku']) !!}   @lang('service.show_sku')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_cat_code', 1, $model->show_cat_code,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_cat_code']) !!}   @lang('service.show_cat_code')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_sale_description', 1, $model->show_sale_description,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_sale_description']) !!}   @lang('service.show_sale_description')
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('product_custom_fields[]', 'product_custom_field1', in_array('product_custom_field1', $product_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'product_custom_fields']) !!}    @lang('service.product_custom_field1')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('product_custom_fields[]', 'product_custom_field2', in_array('product_custom_field2', $product_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'product_custom_fields']) !!}    @lang('service.product_custom_field2')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('product_custom_fields[]', 'product_custom_field3', in_array('product_custom_field3', $product_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'product_custom_fields']) !!}  @lang('service.product_custom_field3')
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('product_custom_fields[]', 'product_custom_field4', in_array('product_custom_field4', $product_custom_fields),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'product_custom_fields']) !!}    @lang('service.product_custom_field4')
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          @if(request()->session()->get('business.enable_product_expiry') == 1)
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_expiry', 'show_expiry', $model->show_expiry,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_expiry']) !!}    @lang('service.show_product_expiry')
              </label>
            </div>
          </div>
          @endif
          @if(request()->session()->get('business.enable_lot_number') == 1)
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_lot', 'show_lot', $model->show_lot,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_lot']) !!}    @lang('service.show_lot_number')
              </label>
            </div>
          </div>
          @endif
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_image', 'show_image', !empty($model->show_image),
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_image']) !!}    @lang('service.show_product_image')
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('sub_total_label', __('invoice.sub_total_label')  ) !!}
              {!! Form::text('sub_total_label', $model->sub_total_label, ['class' => 'form-control',
              'placeholder' => __('invoice.sub_total_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('discount_label', __('invoice.discount_label')  ) !!}
              {!! Form::text('discount_label', $model->discount_label, ['class' => 'form-control',
              'placeholder' => __('invoice.discount_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('tax_label', __('invoice.tax_label')  ) !!}
              {!! Form::text('tax_label', $model->tax_label, ['class' => 'form-control',
              'placeholder' => __('invoice.tax_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('total_label', __('invoice.total_label')  ) !!}
              {!! Form::text('total_label', $model->total_label, ['class' => 'form-control',
              'placeholder' => __('invoice.total_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('total_due_label', __('invoice.total_due_label') . ' (' . __('service.current_sale') . '):' ) !!}
              {!! Form::text('total_due_label', $model->total_due_label, ['class' => 'form-control',
              'placeholder' => __('invoice.total_due_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('paid_label', __('invoice.paid_label')  ) !!}
              {!! Form::text('paid_label', $model->paid_label, ['class' => 'form-control',
              'placeholder' => __('invoice.paid_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_payments', 1, $model->show_payments,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_payments']) !!}    @lang('invoice.show_payments')
              </label>
            </div>
          </div>
          <!-- Barcode -->
          <div class="col-sm-12 col-md-6 col-lg-3 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_barcode', 1, $model->show_barcode,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_barcode']) !!}    @lang('invoice.show_barcode')
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('prev_bal_label', __('invoice.total_due_label') . ' (' . __('service.all_sales') . '):' ) !!}
              {!! Form::text('prev_bal_label', $model->model, ['class' => 'form-control',
              'placeholder' => __('invoice.total_due_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-5 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('show_previous_bal', 1, $model->show_previous_bal,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'show_previous_bal']) !!}    @lang('service.show_previous_bal_due')
              </label>
              @show_tooltip(__('service.previous_bal_due_help'))
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-md-6 hide">
            <div class="form-group">
              {!! Form::label('highlight_color', __('invoice.highlight_color')  ) !!}
              {!! Form::text('highlight_color', $model->highlight_color, ['class' => 'form-control',
              'placeholder' => __('invoice.highlight_color') ]); !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 hide">
            <hr/>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              {!! Form::label('footer_text', __('invoice.footer_text')  ) !!}
              {!! Form::textarea('footer_text', $model->footer_text, ['class' => 'form-control summernote',
              'placeholder' => __('invoice.footer_text'), 'rows' => 3]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 my-auto">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                {!! Form::checkbox('is_default', 1, $model->is_default,
                [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'is_default']) !!}    @lang('barcode.set_as_default')
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Call restaurant module if defined -->
    {{--   @if(Module::has('Repair'))
    @include('repair::layouts.partials.invoice_layout_settings')
    @endif --}}
    <div class="card">
      <div class="card-header with-border">
        <div class="row">
          <div class="col-md-12">
            <h3 class="box-title">@lang('service.layout_credit_note')</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('cn_heading', __('service.cn_heading')  ) !!}
              {!! Form::text('cn_heading', $model->cn_heading, ['class' => 'form-control',
              'placeholder' => __('service.cn_heading') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('cn_no_label', __('service.cn_no_label')  ) !!}
              {!! Form::text('cn_no_label', $model->cn_no_label, ['class' => 'form-control',
              'placeholder' => __('service.cn_no_label') ]); !!}
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
              {!! Form::label('cn_amount_label', __('service.cn_amount_label')  ) !!}
              {!! Form::text('cn_amount_label', $model->cn_amount_label, ['class' => 'form-control', 'placeholder' => __('service.cn_amount_label') ]); !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="form-group row text-center">
    <div class="col-md-12">
      {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
    </div>
  </div>
</fieldset>