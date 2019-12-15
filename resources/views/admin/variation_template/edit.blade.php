@php
$data['page'] = __('page.variation_template');
$data['route'] = 'admin.variation-templates.';
@endphp
<div class="row">
    <div class="col-md-12">
         {!! Form::model($model, ['route' => [$data['route'].'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
        @include('admin.variation_template.form._edit_form', ['submit' => __('service.update', ['attribute' => gv($data, 'page')])])

        {!! Form::close() !!}
    </div>
</div>
<script>
_componentTooltipCustomColor();
_componentSelect2();

</script>