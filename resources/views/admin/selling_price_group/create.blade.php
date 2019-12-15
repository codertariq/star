@php
$data['page'] = __('page.selling_price_group');
$data['route'] = 'admin.selling-price-group.';
@endphp
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
        @include('admin.selling_price_group.form._form', ['submit' => __('service.new', ['attribute' => gv($data, 'page')])])

        {!! Form::close() !!}
    </div>
</div>

<script>
_componentTooltipCustomColor();
_componentSelect2();

</script>