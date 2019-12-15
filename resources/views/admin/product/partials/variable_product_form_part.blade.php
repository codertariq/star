
<div class="col-sm-12">
<h4>@lang('product.add_variation'):* <button type="button" class="btn btn-primary" id="add_variation" data-action="add">+</button></h4>
</div>
<div class="col-sm-12">
    <div class="table-responsive">
    <table class="table table-bordered add-product-price-table table-sm" id="product_variation_form_part">
        <thead class="bg-success">
          <tr>
            <th width="20%">@lang('service.variation')</th>
            <th width="80%">@lang('product.variation_values')</th>
          </tr>
        </thead>
        <tbody>
            @if($action == 'add')
                @include('admin.product.partials.product_variation_row', ['row_index' => 0])
            @else

                @forelse ($product_variations as $product_variation)
                    @include('admin.product.partials.edit_product_variation_row', ['row_index' => $action == 'edit' ? $product_variation->id : $loop->index])
                @empty
                    @include('admin.product.partials.product_variation_row', ['row_index' => 0])
                @endforelse

            @endif

        </tbody>
    </table>
    </div>
</div>