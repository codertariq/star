<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold">
        {{isset($submit) ? $submit : '' }}
        <span class="text-danger">*</span>
        <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small>
    </legend>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('name', __('service.name', ['attribute' => gv($data, 'page')]) , ['class' => 'col-form-label required']) }}
                {{ Form::text('name', Null, ['class' => 'form-control', 'placeholder' =>  __('service.name', ['attribute' => gv($data, 'page')]), 'required']) }}
            </div>
        </div>
    </div>
    @if(in_array('service_staff', $enabled_modules))
    <div class="row">
        <div class="col-md-3">
            <h5 class="font-weight-bold">@lang( 'service.user_type' )</h5>
        </div>
        <div class="col-lg-9">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                     {!! Form::checkbox('is_service_staff', 1, false,
                        [ 'class' => 'form-check-input-styled']); !!} {{ __( 'restaurant.service_staff' ) }}
                </label>
                @show_tooltip(__('restaurant.tooltip_service_staff'))
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-3">
            <h4 class="font-weight-bold">{{ $data['page_title'] }}</h4>
        </div>
    </div>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.user' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('permissions[]', 'user.view', false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'data-fouc']) !!} {{ __( 'role.user.view' ) }}
                </label>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'user.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.user.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'user.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.user.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'user.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.user.delete' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'user.roles' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'roles.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'service.view_role' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'roles.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.add_role' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'roles.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.edit_role' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'roles.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'service.delete_role' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.supplier' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'supplier.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.supplier.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'supplier.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.supplier.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'supplier.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.supplier.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'supplier.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.supplier.delete' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.customer' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'customer.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.customer.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'customer.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.customer.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'customer.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.customer.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'customer.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.customer.delete' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'business.product' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'product.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.product.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'product.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.product.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'product.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.product.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'product.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.product.delete' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'product.opening_stock', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'service.add_opening_stock' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'view_purchase_price', false,['class' => 'form-check-input-styled', 'data-fouc']); !!}
                        {{ __('service.view_purchase_price') }}
                    </label>
                    @show_tooltip(__('service.view_purchase_price_tooltip'))
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.purchase' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'purchase.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.purchase.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'purchase.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.purchase.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'purchase.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.purchase.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'purchase.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.purchase.delete' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'purchase.payments', false,['class' => 'form-check-input-styled', 'data-fouc']); !!}
                        {{ __('service.purchase.payments') }}
                    </label>
                    @show_tooltip(__('service.purchase_payments'))
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'sale.sale' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'sell.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.sell.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'sell.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.sell.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'sell.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.sell.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'sell.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.sell.delete' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'direct_sell.access', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.direct_sell.access' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'sell.payments', false, ['class' => 'form-check-input-styled', 'data-fouc']); !!}
                        {{ __('service.sell.payments') }}
                    </label>
                    @show_tooltip(__('service.sell_payments'))
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'edit_product_price_from_sale_screen', false, ['class' => 'form-check-input-styled', 'data-fouc']); !!}
                        {{ __('service.edit_product_price_from_sale_screen') }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'edit_product_discount_from_sale_screen', false, ['class' => 'form-check-input-styled', 'data-fouc']); !!}
                        {{ __('service.edit_product_discount_from_sale_screen') }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'discount.access', false, ['class' => 'form-check-input-styled', 'data-fouc']); !!}
                        {{ __('service.discount.access') }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.brand' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'brand.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.brand.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'brand.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.brand.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'brand.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.brand.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'brand.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.brand.delete' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.tax_rate' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'tax_rate.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.tax_rate.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'tax_rate.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.tax_rate.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'tax_rate.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.tax_rate.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'tax_rate.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.tax_rate.delete' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.unit' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'unit.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.unit.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'unit.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.unit.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'unit.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.unit.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'unit.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.unit.delete' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'category.category' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'category.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.category.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'category.create', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.category.create' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'category.update', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.category.update' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'category.delete', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.category.delete' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.report' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'purchase_n_sell_report.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.purchase_n_sell_report.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'tax_report.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.tax_report.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'contacts_report.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.contacts_report.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'expense_report.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.expense_report.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'profit_loss_report.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.profit_loss_report.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'stock_report.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.stock_report.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'trending_product_report.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.trending_product_report.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'register_report.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.register_report.view' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'sales_representative.view', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.sales_representative.view' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.settings' )</p>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox"  name="select_all[]" class="check_all form-check-input-styled" > {{ __( 'role.select_all' ) }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'business_settings.access', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.business_settings.access' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'barcode_settings.access', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.barcode_settings.access' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'invoice_settings.access', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.invoice_settings.access' ) }}
                    </label>
                </div>
            </div>
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'expense.access', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.expense.access' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.dashboard' ) @show_tooltip(__('tooltip.dashboard_permission'))</p>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'dashboard.data', true,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.dashboard.data' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row check_group">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'account.account' )</p>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'account.access', false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'service.access_accounts' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'role.access_locations' ) @show_tooltip(__('tooltip.access_locations_permission'))</p>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'access_all_locations', true,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __( 'role.all_locations' ) }}
                    </label>
                    @show_tooltip(__('tooltip.all_location_permission'))
                </div>
            </div>
            @foreach($locations as $location)
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('location_permissions[]', 'location.' . $location->id, false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ $location->name }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <p class="font-weight-bold">@lang( 'service.access_selling_price_groups' )</p>
        </div>
        <div class="col-md-6">
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('permissions[]', 'access_default_selling_price', true,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ __('service.default_selling_price') }}
                    </label>
                </div>
            </div>
            {{--  @if(count($selling_price_groups) > 0)
            @foreach($selling_price_groups as $selling_price_group)
            <div class="col-md-12 form-check form-check-inline">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        {!! Form::checkbox('spg_permissions[]', 'selling_price_group.' . $selling_price_group->id, false,
                        [ 'class' => 'form-check-input-styled', 'data-fouc']); !!} {{ $selling_price_group->name }}
                    </label>
                </div>
            </div>
            @endforeach
            @endif --}}
        </div>
    </div>
    <div class="form-group row text-center">
        <div class="col-md-12">
            {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
            {{--   <button type="button" class="btn btn-link" id="submiting" style="display: none;" disabled="">{{ __('service.submiting', ['attribute' => gv($data, 'page')]) }} <img src="{{ asset('asset/ajaxloader.gif') }}"></button> --}}
            <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
        </div>
    </div>
</fieldset>