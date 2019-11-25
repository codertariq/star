
    <h4>@lang('business.add_keyboard_shortcuts'):</h4>
    <p class="help-block">@lang('service.shortcut_help'); @lang('service.example'): <b>ctrl+shift+b</b>, <b>ctrl+h</b></p>
    <p class="help-block">
        <b>@lang('service.available_key_names_are'):</b>
        <br> shift, ctrl, alt, backspace, tab, enter, return, capslock, esc, escape, space, pageup, pagedown, end, home, <br>left, up, right, down, ins, del, and plus
    </p>
    <div class="row">
        <div class="col-sm-6">
            <table class="table table-striped">
                <tr>
                    <th>@lang('business.operations')</th>
                    <th>@lang('business.keyboard_shortcut')</th>
                </tr>
                <tr>
                    <td>{!! __('sale.express_finalize') !!}:</td>
                    <td>
                        {!! Form::text('shortcuts[pos][express_checkout]',
                        !empty($shortcuts["pos"]["express_checkout"]) ? $shortcuts["pos"]["express_checkout"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
                <tr>
                    <td>@lang('sale.finalize'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][pay_n_ckeckout]', !empty($shortcuts["pos"]["pay_n_ckeckout"]) ? $shortcuts["pos"]["pay_n_ckeckout"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
                <tr>
                    <td>@lang('sale.draft'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][draft]', !empty($shortcuts["pos"]["draft"]) ? $shortcuts["pos"]["draft"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
                <tr>
                    <td>@lang('messages.cancel'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][cancel]', !empty($shortcuts["pos"]["cancel"]) ? $shortcuts["pos"]["cancel"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
                <tr>
                    <td>@lang('service.recent_product_quantity'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][recent_product_quantity]', !empty($shortcuts["pos"]["recent_product_quantity"]) ? $shortcuts["pos"]["recent_product_quantity"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-sm-6">
            <table class="table table-striped">
                <tr>
                    <th>@lang('business.operations')</th>
                    <th>@lang('business.keyboard_shortcut')</th>
                </tr>
                <tr>
                    <td>@lang('sale.edit_discount'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][edit_discount]', !empty($shortcuts["pos"]["edit_discount"]) ? $shortcuts["pos"]["edit_discount"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
                <tr>
                    <td>@lang('sale.edit_order_tax'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][edit_order_tax]', !empty($shortcuts["pos"]["edit_order_tax"]) ? $shortcuts["pos"]["edit_order_tax"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
                <tr>
                    <td>@lang('sale.add_payment_row'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][add_payment_row]', !empty($shortcuts["pos"]["add_payment_row"]) ? $shortcuts["pos"]["add_payment_row"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
                <tr>
                    <td>@lang('sale.finalize_payment'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][finalize_payment]', !empty($shortcuts["pos"]["finalize_payment"]) ? $shortcuts["pos"]["finalize_payment"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
                <tr>
                    <td>@lang('service.add_new_product'):</td>
                    <td>
                        {!! Form::text('shortcuts[pos][add_new_product]', !empty($shortcuts["pos"]["add_new_product"]) ? $shortcuts["pos"]["add_new_product"] : null, ['class' => 'form-control']); !!}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h5>@lang('service.pos_settings'):</h5>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[disable_pay_checkout]', 1, !empty($pos_settings['disable_pay_checkout']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'disable_pay_checkout']) !!}  {{ __( 'service.disable_pay_checkout' ) }}
                </label>
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[disable_draft]', 1, !empty($pos_settings['disable_draft']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'disable_draft']) !!}  {{ __( 'service.disable_draft' ) }}
                </label>
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[disable_express_checkout]', 1, !empty($pos_settings['disable_express_checkout']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'disable_express_checkout']) !!}  {{ __( 'service.disable_express_checkout' ) }}
                </label>
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[hide_product_suggestion]', 1, !empty($pos_settings['hide_product_suggestion']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'hide_product_suggestion']) !!}  {{ __( 'service.hide_product_suggestion' ) }}
                </label>
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[hide_recent_trans]', 1, !empty($pos_settings['hide_recent_trans']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'hide_recent_trans']) !!}  {{ __( 'service.hide_recent_trans' ) }}
                </label>
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[disable_discount]', 1, !empty($pos_settings['disable_discount']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'disable_discount']) !!}  {{ __( 'service.disable_discount' ) }}
                </label>
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[disable_order_tax]', 1, !empty($pos_settings['disable_order_tax']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'disable_order_tax']) !!}  {{ __( 'service.disable_order_tax' ) }}
                </label>
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[is_pos_subtotal_editable]', 1, !empty($pos_settings['is_pos_subtotal_editable']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'is_pos_subtotal_editable']) !!}  {{ __( 'service.pos_subtotal_editable' ) }}
                </label>
                @show_tooltip(__('service.subtotal_editable_help_text'))
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[disable_suspend]', 1, !empty($pos_settings['disable_suspend']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'disable_suspend']) !!}  {{ __( 'service.disable_suspend_sale' ) }}
                </label>
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[inline_service_staff]', 1, !empty($pos_settings['inline_service_staff']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'inline_service_staff']) !!}  {{ __( 'service.enable_service_staff_in_product_line' ) }}
                </label>
                @show_tooltip(__('service.inline_service_staff_tooltip'))
            </div>
        </div>
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('pos_settings[is_service_staff_required]', 1, !empty($pos_settings['is_service_staff_required']) ? true : false,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'is_service_staff_required']) !!}  {{ __( 'service.is_service_staff_required' ) }}
                </label>
            </div>
        </div>
    </div>
