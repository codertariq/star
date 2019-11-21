@php
$data['page'] = __('page.role');
$data['route'] = 'admin.role.';
$data['page_title'] = __('page.role_title');
@endphp
<div class="row">
    <div class="col-md-11 mx-auto">
        {!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery', 'method' => 'POST', 'id' => 'content_form']) !!}
        @include('admin.role.form._form', ['submit' => __('service.new', ['attribute' => gv($data, 'page')])])
        {!! Form::close() !!}
    </div>
</div>
<script>
_componentInputSwitchery();
_componentUniform();
_componentTooltipCustomColor();

</script>
