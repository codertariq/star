@php
$data['page'] = __('page.sales_commission_agents');
$data['route'] = 'admin.sales-commission-agents.';
@endphp
<div class="row">
    <div class="col-md-12">
         {!! Form::model($model, ['route' => [$data['route'].'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
         {!! Form::hidden('user_id', $model->id, ['id' => 'user_id']) !!}
        @include('admin.sales_commission_agent.form._form', ['submit' => __('service.update', ['attribute' => gv($data, 'page')])])

        {!! Form::close() !!}
    </div>
</div>
<script>
_componentUniform();
_componentTooltipCustomColor();
_componentSelect2();

 $(document).on('click', '#selected_contacts', function(event) {
     if (this.checked) {
         $('div.selected_contacts_div').show();
     } else {
         $('div.selected_contacts_div').hide();
     }
 });


 $('[data-toggle="datepicker"]').datepicker({
    autoHide: true,
    zIndex: 2048,
});
</script>