@php
$data['page'] = __('page.business_location');
$data['route'] = 'admin.business-location.';
@endphp
{!! Form::open(['url' => route('admin.business-location.settings_update', [$location->id]), 'method' => 'post', 'id' => 'content_form']) !!}
<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold">
        {{ __('service.update', ['attribute' => gv($data, 'page'). ' '.__('service.settings')]) }}
        <span class="text-danger">*</span>
        <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small>
    </legend>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('print_receipt_on_invoice', __('receipt.print_receipt_on_invoice') . ':') !!}
                @show_tooltip(__('tooltip.print_receipt_on_invoice'))
                <div class="form-group-feedback form-group-feedback-right">
                    {!! Form::select('print_receipt_on_invoice', $printReceiptOnInvoice, $location->print_receipt_on_invoice, ['class' => 'form-control select', 'required']); !!}
                    <div class="form-control-feedback form-control-feedback-sm">
                        <i class="fa fa-file-text-0"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('receipt_printer_type', __('receipt.receipt_printer_type'), ['class' => 'required']) !!} @show_tooltip(__('tooltip.receipt_printer_type'))
                <div class="form-group-feedback form-group-feedback-right">
                    {!! Form::select('receipt_printer_type', $receiptPrinterType, $location->receipt_printer_type, ['class' => 'form-control select', 'required']); !!}
                    <div class="form-control-feedback form-control-feedback-sm">
                        <i class="fa fa-print"></i>
                    </div>
                </div>
                @if(config('app.env') == 'demo')
                <span class="help-block">Only Browser based option is enabled in demo.</span>
                @endif
            </div>
        </div>
        <div class="col-sm-4"
            id="location_printer_div">
            <div class="form-group">
                {!! Form::label('printer_id', __('printer.receipt_printers'), ['class' => 'required']) !!}
                <div class="form-group-feedback form-group-feedback-right">
                    {!! Form::select('printer_id', $printers, $location->printer_id, ['class' => 'form-control select']); !!}
                    <div class="form-control-feedback form-control-feedback-sm">
                        <i class="fa fa-share-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('invoice_layout_id', __('invoice.invoice_layout'), ['class' => 'required']) !!} @show_tooltip(__('tooltip.invoice_layout'))
                <div class="form-group-feedback form-group-feedback-right">
                    {!! Form::select('invoice_layout_id', $invoice_layouts, $location->invoice_layout_id, ['class' => 'form-control select', 'required']); !!}
                    <div class="form-control-feedback form-control-feedback-sm">
                        <i class="fa fa-info"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('invoice_scheme_id', __('invoice.invoice_scheme'), ['class' => 'required']) !!} @show_tooltip(__('tooltip.invoice_scheme'))
                <div class="form-group-feedback form-group-feedback-right">
                    {!! Form::select('invoice_scheme_id', $invoice_schemes, $location->invoice_scheme_id, ['class' => 'form-control select', 'required']); !!}
                    <div class="form-control-feedback form-control-feedback-sm">
                        <i class="fa fa-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row text-center">
        <div class="col-md-12">
            {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page'). ' '. __('service.settings')]), ['class' => 'btn btn-primary', 'id' => 'submit']) }}
            <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
        </div>
    </div>
</fieldset>
{!! Form::close() !!}
<script>
_componentSelect2();
if ($('select#receipt_printer_type').val() == 'printer') {
    $('div#location_printer_div').removeClass('hide');
} else {
    $('div#location_printer_div').addClass('hide');
}

$('select#receipt_printer_type').change(function() {
    var printer_type = $(this).val();
    if (printer_type == 'printer') {
        $('div#location_printer_div').removeClass('hide');
        $('select#printer_id').attr('required', true);
    } else {
        $('div#location_printer_div').addClass('hide');
        $('select#printer_id').attr('required', false);
    }
});
</script>