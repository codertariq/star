@php
$data['page'] = __('page.unit');
$data['route'] = 'admin.units.';
@endphp
<div class="row">
    <div class="col-md-12">
         {!! Form::model($model, ['route' => [$data['route'].'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
        @include('admin.unit.form._edit_form', ['submit' => __('service.update', ['attribute' => gv($data, 'page')])])

        {!! Form::close() !!}
    </div>
</div>
<script>
_componentTooltipCustomColor();
_componentSelect2();
_componentUniform();
$(document).on('keyup', '#actual_name', function() {
    $('#unit_name').text($(this).val());
});
</script>