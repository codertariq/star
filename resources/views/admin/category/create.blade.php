@php
$data['page'] = __('page.category');
$data['route'] = 'admin.categories.';
@endphp
<div class="row">
	<div class="col-md-12">
		{!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
		@include('admin.category.form._form', ['submit' => __('service.new', ['attribute' => gv($data, 'page')])])
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