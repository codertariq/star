@php
$data['page'] = __('page.invoice_schemes');
$data['route'] = 'admin.invoice-schemes.';
@endphp
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
        @include('admin.invoice_schemes.form._form', ['submit' => __('service.new', ['attribute' => gv($data, 'page')])])

        {!! Form::close() !!}
    </div>
</div>

<script>
_componentTooltipCustomColor();
_componentSelect2();

</script>