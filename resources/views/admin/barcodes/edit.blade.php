@php
$data['page'] = __('page.barcodes');
$data['route'] = 'admin.barcodes.';
@endphp
<div class="row">
    <div class="col-md-12">
         {!! Form::model($model, ['route' => [$data['route'].'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
        @include('admin.barcodes.form._edit_form', ['submit' => __('service.update', ['attribute' => gv($data, 'page')])])

        {!! Form::close() !!}
    </div>
</div>
<script>
_componentTooltipCustomColor();
_componentSelect2();
$(document).on('change', '#is_continuous', function() {
    if ($(this).is(':checked')) {
        $('.stickers_per_sheet_div').addClass('hide');
        $('#stickers_in_one_sheet').attr('disabled', true);
        $('#paper_height').attr('disabled', true);
        $('.paper_height_div').addClass('hide');
    } else {
        $('.stickers_per_sheet_div').removeClass('hide');
        $('.paper_height_div').removeClass('hide');
        $('#stickers_in_one_sheet').attr('disabled', false);
        $('#paper_height').attr('disabled', false);
    }
});
</script>