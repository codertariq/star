@php
$data['page'] = __('page.role');
$data['route'] = 'admin.role.';
$data['page_title'] = __('page.role_title');
@endphp
<div class="row">
    <div class="col-md-12">
        {!! Form::model($model, ['route' => [$data['route'].'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
        @include('admin.role.form._edit_form', ['submit' => __('service.update', ['attribute' => gv($data, 'page')])])
        {!! Form::close() !!}
    </div>
</div>
<script>
_componentInputSwitchery();
_componentUniform();
_componentTooltipCustomColor();
</script>
