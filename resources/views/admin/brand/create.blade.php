@php
$data['page'] = __('page.brand');
$data['route'] = 'admin.brands.';
@endphp
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery', 'id' => $quick_add ? 'quick_add_form' : 'content_form', 'files' => true, 'method' => 'POST']) !!}
        @if ($quick_add)
        	<input type="hidden" value="brand_id" id="quick_add">
        @endif
        @include('admin.brand.form._form', ['submit' => __('service.new', ['attribute' => gv($data, 'page')])])

        {!! Form::close() !!}
    </div>
</div>

<script>
_componentTooltipCustomColor();
_componentSelect2();

</script>