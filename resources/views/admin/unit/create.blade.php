@php
$data['page'] = __('page.unit');
$data['route'] = 'admin.units.';
@endphp
<div class="row">
	<div class="col-md-12">
		{!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
		@include('admin.unit.form._form', ['submit' => __('service.new', ['attribute' => gv($data, 'page')])])
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