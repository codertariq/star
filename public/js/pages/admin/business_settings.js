/* ------------------------------------------------------------------------------
 *
 *  # Responsive extension for Datatables
 *
 *  Demo JS code for datatable_responsive.html page
 *
 * ---------------------------------------------------------------------------- */
// Setup module
// ------------------------------
var tariq = '';
var DatatableResponsive = function() {
    // Basic Datatable examples
    return {
        init: function() {
            FormHandle.init();
            _componentSelect2();
            _componentUniform();
            _componentTooltipCustomColor();
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                zIndex: 2048,
            });
            //Purchase currency
            $('input#purchase_in_diff_currency').on('ifChecked', function(event) {
                $('div#settings_purchase_currency_div, div#settings_currency_exchange_div').removeClass(
                    'hide'
                );
            });
            $('input#purchase_in_diff_currency').on('ifUnchecked', function(event) {
                $('div#settings_purchase_currency_div, div#settings_currency_exchange_div').addClass(
                    'hide'
                );
            });
            $('input#purchase_in_diff_currency').change(function() {
                if ($(this).is(':checked')) {
                   $('div#settings_purchase_currency_div, div#settings_currency_exchange_div').removeClass(
                    'hide'
                );
                } else {
                     $('div#settings_purchase_currency_div, div#settings_currency_exchange_div').addClass(
                    'hide'
                );
                }
            })
            //Product expiry
            $('input#enable_product_expiry').change(function() {
                if ($(this).is(':checked')) {
                    $('select#expiry_type').attr('disabled', false);
                    $('div#on_expiry_div').removeClass('hide');
                } else {
                    $('select#expiry_type').attr('disabled', true);
                    $('div#on_expiry_div').addClass('hide');
                }
            });
            $('select#on_product_expiry').change(function() {
                if ($(this).val() == 'stop_selling') {
                    $('input#stop_selling_before').attr('disabled', false);
                    $('input#stop_selling_before')
                        .focus()
                        .select();
                } else {
                    $('input#stop_selling_before').attr('disabled', true);
                }
            });
            //enable_category
            $('input#enable_category').change(function() {
                if ($(this).is(':checked')) {
                    $('div.enable_sub_category').removeClass('hide');
                } else {
                    $('div.enable_sub_category').addClass('hide');
                }
            })
        }
    }
}();
// Initialize module
// ------------------------------
document.addEventListener('DOMContentLoaded', function() {
    DatatableResponsive.init();
});