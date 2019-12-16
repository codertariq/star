<div class="table-responsive">
    <table class="table content_management_datatable table-striped" data-url="@if(isset($data['route']) and Route::has($data['route'].'create')){{ route($data['route'].'index', ['get' => 'datatable']) }}@endif">
        <thead>
            <tr>
                <th></th>
                <th>#</th>
                <th>@lang('sale.product')</th>
                <th>@lang('service.selling_price')</th>
                <th>@lang('report.current_stock')</th>
                <th>@lang('product.product_type')</th>
                <th>@lang('product.category')</th>
                <th>@lang('product.model')</th>
                <th>@lang('product.brand')</th>
                <th>@lang('product.tax')</th>
                <th>@lang('product.sku')</th>
                <th>@lang('messages.action')</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>