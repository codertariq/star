@php
$data['page'] = __('page.user');
$data['route'] = 'admin.user.';
@endphp
<div class="row">
    <div class="col-md-12">
         {!! Form::model($model, ['route' => [$data['route'].'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
         {!! Form::hidden('user_id', $model->id, ['id' => 'user_id']) !!}
        @include('admin.manage_user.form._edit_form', ['submit' => __('service.new', ['attribute' => gv($data, 'page')])])

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

 function focusFirst(parent) {
    $(parent).find('input, textarea, select')
        .not('input[type=hidden],input[type=button],input[type=submit],input[type=reset],input[type=image],button')
        .filter(':enabled:visible:first')
        .focus();
}
focusFirst($('#content_form'));
</script>