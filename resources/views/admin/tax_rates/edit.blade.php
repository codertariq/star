@php
$data['page'] = __('page.tax_rates');
$data['route'] = 'admin.tax-rates.';
@endphp
<div class="row">
    <div class="col-md-12">
         {!! Form::model($model, ['route' => [$data['route'].'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
        @include('admin.tax_rates.form._form', ['submit' => __('service.update', ['attribute' => gv($data, 'page')])])

        {!! Form::close() !!}
    </div>
</div>
<script>
_componentTooltipCustomColor();
_componentSelect2();

</script>