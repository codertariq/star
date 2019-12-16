Lang.setLocale($('html').attr('lang'));
paceOptions = {
    ajax: true,
};
//Set global currency to be used in the application
__currency_symbol = $('input#__symbol').val();
__currency_thousand_separator = $('input#__thousand').val();
__currency_decimal_separator = $('input#__decimal').val();
__currency_symbol_placement = $('input#__symbol_placement').val();
if ($('input#__precision').length > 0) {
    __currency_precision = $('input#__precision').val();
} else {
    __currency_precision = 2;
}
if ($('input#__quantity_precision').length > 0) {
    __quantity_precision = $('input#__quantity_precision').val();
} else {
    __quantity_precision = 2;
}
Pace.start();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Access-Control-Allow-Origin': 'http://127.0.0.1:8000',
        'Access-Control-Allow-Origin': 'http://localhost:8000',
    }
});
var _componentPerfectScrollbar = function(v = '.modal-dialog-scrollable') {
    if (typeof PerfectScrollbar == 'undefined') {
        p_notify(Lang.get('service.not_loaded', {
            attribute: 'perfect_scrollbar.min.js'
        }), 'warning', 'Warning!!');
        return;
    }
    var ps = new PerfectScrollbar(v, {
        wheelSpeed: 5,
        wheelPropagation: true
    });
};
var _componentUniform = function() {
    if (!$().uniform) {
        p_notify(Lang.get('service.not_loaded', {
            attribute: 'uniform.min.js'
        }), 'warning', 'Warning!!');
        return;
    }
    // Default initialization
    $('.form-check-input-styled').uniform();
};
// Select2 for length menu styling
var _componentDataTableSelect2 = function() {
    if (!$().select2) {
        p_notify(Lang.get('service.not_loaded', {
            attribute: 'select2.min.js'
        }), 'warning', 'Warning!!');
        return;
    }
    // Initialize
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        dropdownAutoWidth: true,
        width: 'auto'
    });
};
var _componentSelect2 = function() {
    if (!$().select2) {
        p_notify(Lang.get('service.not_loaded', {
            attribute: 'select2.min.js'
        }), 'warning', 'Warning!!');
        return;
    }
    // Initialize
    $('.modal-content .select').select2({
        dropdownAutoWidth: true,
        dropdownParent: $("#content_modal .modal-content")
    });
    $('.card-body .select').select2({
        // dropdownAutoWidth: true,
    });
};
/*
 * Tooltip Custom Color
 */
var _componentTooltipCustomColor = function() {
    $('[data-popup=tooltip-custom]').tooltip({
        template: '<div class="tooltip"><div class="arrow border-teal"></div><div class="tooltip-inner bg-teal"></div></div>'
    });
};
var _componentBootstrapSwitch = function() {
    if (!$().bootstrapSwitch) {
        p_notify(Lang.get('service.not_loaded', {
            attribute: 'switch.min.js'
        }), 'warning', 'Warning!!');
        return;
    }
    // Initialize
    $('.form-input-switch').bootstrapSwitch();
};
/*
 * For Switchery input field
 */
var _componentInputSwitchery = function() {
        if (typeof Switchery == 'undefined') {
            console.warn('Warning - switchery.min.js is not loaded.');
            return;
        }
        var input_elems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));
        if (input_elems.length > 0) {
            input_elems.forEach(function(html) {
                var switchery = new Switchery(html);
            });
        }
    }
    /*
     * For Delete Item
     */
$(document).on('click', '#delete_item', function(e) {
    e.preventDefault();
    var row = $(this).data('id');
    var url = $(this).data('url');
    $('#action_menu_' + row).hide();
    $('#delete_loading_' + row).show();
    swalInit({
            title: Lang.get('service.are_you_sure'),
            text: Lang.get('service.delete_message'),
            type: 'warning',
            allowOutsideClick: false
        })
        .then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    method: 'Delete',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        ajax_success(data);
                        $('#delete_loading_' + row).hide();
                        $('#action_menu_' + row).show();
                    },
                    error: function(data) {
                        ajax_error(data);
                        $('#delete_loading_' + row).hide();
                        $('#action_menu_' + row).show();
                    }
                });
            } else {
                $('#delete_loading_' + row).hide();
                $('#action_menu_' + row).show();
            }
        });
});
$(document).on('click', '#change_status', function(e) {
    e.preventDefault();
    var row = $(this).data('id');
    var url = $(this).data('url');
    var status = $(this).data('status');
    if (status == 1) {
        msg = Lang.get('service.status_online_to_offline');
    } else {
        msg = Lang.get('service.status_offline_to_online');
    }
    $('#status_' + row).hide();
    $('#status_loading_' + row).show();
    swalInit({
            title: Lang.get('service.are_you_sure'),
            text: msg,
            type: 'warning',
            allowOutsideClick: false
        })
        .then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    method: 'Delete',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    dataType: 'JSON',
                    data: {
                        action: status
                    },
                    success: function(data) {
                        ajax_success(data);
                    },
                    error: function(data) {
                        ajax_error(data);
                        $('#status_loading_' + row).hide();
                        $('#status_' + row).show();
                    }
                });
            } else {
                $('#status_loading_' + row).hide();
                $('#status_' + row).show();
            }
        });
});
$(document).on('click', '#set_default', function(e) {
    e.preventDefault();
    var row = $(this).data('id');
    var url = $(this).data('url');
    var status = $(this).data('status');
    msg = Lang.get('service.make_it_default');
    $('#action_menu_' + row).hide();
    $('#delete_loading_' + row).show();
    swalInit({
            title: Lang.get('service.are_you_sure'),
            text: msg,
            type: 'warning',
            allowOutsideClick: false
        })
        .then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    method: 'Delete',
                    dataType: 'JSON',
                    data: {
                        action: status
                    },
                    success: function(data) {
                        ajax_success(data);
                    },
                    error: function(data) {
                        ajax_error(data);
                        $('#delete_loading_' + row).hide();
                        $('#action_menu_' + row).show();
                    }
                });
            } else {
                $('#delete_loading_' + row).hide();
                $('#action_menu_' + row).show();
            }
        });
});
var _componentStatusSwitchery = function() {
    if (typeof Switchery == 'undefined') {
        p_notify(Lang.get('service.not_loaded', {
            attribute: 'switchery.min.js'
        }), 'warning', 'Warning!!');
        return;
    }
    var elems = Array.prototype.slice.call(document.querySelectorAll('.form-check-status-switchery'));
    if (elems.length > 0) {
        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
    }
};
var swalInit = swal.mixin({
    buttonsStyling: false,
    confirmButtonClass: 'btn btn-primary',
    cancelButtonClass: 'btn btn-light',
    showCancelButton: true,
    confirmButtonText: Lang.get('service.confirm'),
    cancelButtonText: Lang.get('service.cancel')
});
if ($('.content_management_datatable').length > 0 && $().DataTable) {
    let url = $('.content_management_datatable').data('url');
    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        responsive: true,
        select: true,
        pageLength: 25,
        order: [1, 'desc'],
        processing: true,
        serverSide: true,
        dom: '<"dt-buttons-full"B><"datatable-header"fl><"datatable"t><"datatable-footer"ip>',
        ajax: {
            url: url,
            error: function(data) {
                ajax_error(data);
            }
        },
        language: {
            search: '<span>' + Lang.get('service.filter') + ':</span> _INPUT_',
            info: Lang.get('service.datatable_info', {
                start: "_START_",
                end: "_END_",
                total: "_TOTAL_"
            }),
            searchPlaceholder: Lang.get('service.type_of_filter'),
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            lengthMenu: '<span>' + Lang.get('service.show') + ':</span> _MENU_',
            zeroRecords: Lang.get('service.zero_records'),
            emptyTable: Lang.get('service.empty_table'),
            paginate: {
                'first': Lang.get('service.first'),
                'last': Lang.get('service.last'),
                'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
            },
            select: {
                rows: {
                    _: Lang.get('service.selected_rows', {
                        row: "%d"
                    }),
                    1: Lang.get('service.selected_one_row'),
                    0: Lang.get('service.selected_zero_row'),
                }
            }
        }
    });
}

function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function dataTableCardReload(cardblock = true, switchery = false, tooltip = false, unblock = true) {
    var $target = $('#table_card'),
        block = $target.closest('.card');
    if (cardblock) {
        cardBlock($(block));
    }
    if (switchery) {
        $('.switchery').remove();
        _componentStatusSwitchery();
    }
    if (tooltip) {
        _componentTooltipCustomColor();
    }
    if (unblock) {
        cardUnblock($(block));
    }
}
if ($('#reload').length > 0) {
    $(document).on('click', '#reload', function() {
        dataTableReload();
    });
}

function dataTableReload() {
    if (typeof(tariq) != "undefined" && tariq !== null) {
        tariq.ajax.reload(null, false);
    }
}
/*
 * For Get Data Table Selected Rows Id
 */
function getDatatableSelectedRowIds(dt) {
    var ids = [];
    var rows = dt.rows('.selected').data();
    $.each(rows, function(index, value) {
        ids.push(value['id']);
    });
    return ids;
}

function datatableSelectedRowsAction(dt, url, action = 'delete', msg = Lang.get('service.delete_message')) {
    var ids = getDatatableSelectedRowIds(dt);
    var url = BASE_ADMIN_URL + url;
    swalInit({
            title: Lang.get('service.are_you_sure'),
            text: msg,
            type: 'warning',
            allowOutsideClick: false
        })
        .then((result) => {
            if (result.value) {
                dataTableCardReload(true, true, true, false);
                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: {
                        action: action,
                        ids: ids
                    },
                    dataType: 'json',
                    success: function(data) {
                        ajax_success(data);
                        dataTableReload();
                    },
                    error: function(data) {
                        ajax_error(data);
                        dataTableReload();
                    }
                });
            }
        });
}

function p_notify(msg = Lang.get('service.error_msg'), type = 'error', title = Lang.get('service.error_title')) {
    new PNotify({
        title: title,
        text: msg,
        type: type,
        addclass: 'alert alert-styled-left',
    });
}

function noty(msg = Lang.get('service.error_msg'), type = 'error', title = Lang.get('service.error_title'), layout = 'topRight') {
    new Noty({
        theme: 'limitless',
        timeout: 2000,
        title: title,
        text: msg,
        type: type,
        modal: true,
        layout: 'center'
    }).show();
}

function ajax_error(data, form = null, submit = $('#submit')) {
    var audio = $('#error-audio')[0];
    if (audio !== undefined) {
        audio.play();
    }
    if (data.status === 404) {
        p_notify(Lang.get('service.not_found', {
            attribute: 'Requested page'
        }));
        return;
    } else if (data.status === 500) {
        p_notify(Lang.get('service.server_error'));
        return;
    } else if (data.status === 200) {
        p_notify(Lang.get('service.parse_error'));
        return;
    }
    let jsonValue = $.parseJSON(data.responseText);
    let errors = jsonValue.errors;
    if (errors) {
        var i = 0;
        $.each(errors, function(key, value) {
            let first_item = Object.keys(errors)[i];
            let error_el_id = $('#' + first_item);
            if (error_el_id.length > 0) {
                error_el_id.parsley().addError('required', {
                    message: value,
                    updateClass: true
                });
            }
            // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
            p_notify(value);
            i++;
        });
    } else {
        p_notify(jsonValue.message);
    }
}

function ajax_success(data, form = null, submit = $('#submit')) {
    // var audio = $('#success-audio')[0];
    // if (audio !== undefined) {
    //     audio.play();
    // }
    
    p_notify(data.message, 'success', Lang.get('service.success_title'));
    if (check_element('content_modal')) {
        $('#content_modal').modal('hide');
    }
    if (data.goto) {
        noty(Lang.get('auth.redirect'), 'success', Lang.get('service.success_title'), 'center')
        setTimeout(function() {
            window.location.href = data.goto;
        }, 1500);
    } else if (data.window) {
        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
        setTimeout(function() {
            window.location.href = '';
        }, 1000);
    }
    dataTableReload();
    if (form) {
        form[0].reset();
    }
    hide_submit_loading(submit);
};

function show_submit_loading(form = $('#content_form')) {
    let button = form.closest('#submit');
    button.attr('disabled', true);
    button.append('<i class="icon-spinner10 ml-2 text-danger spinner"></i>');
    let card = button.closest('.card');
    if (card.length > 0) {
        cardBlock(card);
        return;
    }
    let modal = button.closest('.modal-content');
    if (modal.length > 0) {
        cardBlock(modal);
        return;
    }
}

function hide_submit_loading(form = $('#content_form')) {
    let button = form.find('#submit');
    button.attr('disabled', false);
    let modal = button.closest('.modal-content');
    let card = button.closest('.card');
    if (modal.length > 0) {
        cardUnblock(modal);
    }
    if (card.length > 0) {
        cardUnblock(card);
    }
    return;

}

function cardBlock(card) {
    card.block({
        message: '<i class="icon-spinner10 icon-3x text-danger spinner"></i>',
        overlayCSS: {
            backgroundColor: '#1B2024',
            opacity: 0.85,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'none',
            color: '#fff'
        }
    });
}

function cardUnblock(card) {
    card.unblock();
}

function check_element(element) {
    let id = '#' + element;
    if ($(id).length > 0) {
        return true;
    }
    return false;
}
$(document).on('click', '#logout', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
        url: url,
        method: 'Post',
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false,
        dataType: 'JSON',
        success: function(data) {
            ajax_success(data);
        },
        error: function(data) {
            ajax_error(data);
        }
    });
});
if ($('.modal-dialog-scrollable').length > 0) {
    // _componentPerfectScrollbar('.modal-body');
}
$(document).on('click', '.check_all', function() {
    if (this.checked) {
        $(this)
            .closest('.check_group')
            .find('.form-check-input-styled')
            .each(function() {
                $(this).prop('checked', true);
                $.uniform.update();
            });
    } else {
        $(this)
            .closest('.check_group')
            .find('.form-check-input-styled')
            .each(function() {
                $(this).prop('checked', false);
                $.uniform.update();
            });
    }
});
var _componentTooltipCustomColor = function() {
    $('[data-popup=tooltip]').tooltip();
};
$(document).on("wheel", "input[type=number]", function(e) {
    $(this).blur();
});

function checkEmail() {
    $(document).on('change', '#email', function() {
        $('.parsley-required').remove();
        var email = $(this).val();
        var user_id = $('#user_id').val();
        console.log(user_id);
        var field = $(this).parsley();
        if (field.isValid()) {
            $.ajax({
                url: BASE_URL + '/business/register/check-email',
                type: 'POST',
                data: {
                    email: email,
                    user_id: user_id
                },
                dataType: 'JSON',
                success: function(data) {
                    field.validate();
                    p_notify(data.message, 'success', Lang.get('service.success_title'));
                },
                error: function(data) {
                    ajax_error(data);
                }
            });
        } else {
            field.validate();
        }
    });
}

function checkUsername() {
    $(document).on('change', '#username', function() {
        $('.parsley-required').remove();
        var username = $(this).val();
        var user_id = $('#user_id').val();
        var field = $(this).parsley();
        if (field.isValid()) {
            $.ajax({
                url: BASE_URL + '/business/register/check-username',
                type: 'POST',
                data: {
                    username: username,
                    user_id: user_id
                },
                dataType: 'JSON',
                success: function(data) {
                    field.validate();
                    p_notify(data.message, 'success', Lang.get('service.success_title'));
                },
                error: function(data) {
                    ajax_error(data);
                }
            });
        } else {
            field.validate();
        }
    });
}

function checkLocationId() {
    $(document).on('change', '#location_id', function() {
        $('.parsley-required').remove();
        var location_id = $(this).val();
        var hidden_id = $('#hidden_id').val();
        var field = $(this).parsley();
        if (field.isValid()) {
            $.ajax({
                url: BASE_ADMIN_URL + 'business-location/check-location-id',
                type: 'POST',
                data: {
                    location_id: location_id,
                    hidden_id: hidden_id
                },
                dataType: 'JSON',
                success: function(data) {
                    field.validate();
                    p_notify(data.message, 'success', Lang.get('service.success_title'));
                },
                error: function(data) {
                    ajax_error(data);
                }
            });
        } else {
            field.validate();
        }
    });
}
$('#content_modal').on('hide.bs.modal', function() {
    hide_submit_loading();
    $('.modal-body').html('');
});
$('#content_modal').on('shown.bs.modal', function(e) {
    var ele = $(e.target).find('input[type=text],textarea,select').filter(':visible:first');
    // find the first input on the bs modal
    if (ele.length > 0) {
        ele.focus();
    }
});
$(document).on('click', '.option-div-group .option-div', function() {
    $(this)
        .closest('.option-div-group')
        .find('.option-div')
        .each(function() {
            $(this).removeClass('active');
        });
    $(this).addClass('active');
    $(this)
        .find('input:radio')
        .prop('checked', true)
        .change();
});
$(document).on('change', 'input[type=radio][name=scheme_type]', function() {
    $('#invoice_format_settings').removeClass('hide');
    var scheme_type = $(this).val();
    if (scheme_type == 'blank') {
        $('#prefix')
            .val('')
            .attr('placeholder', 'XXXX')
            .prop('disabled', false);
    } else if (scheme_type == 'year') {
        var d = new Date();
        var this_year = d.getFullYear();
        $('#prefix')
            .val(this_year + '-')
            .attr('placeholder', '')
            .prop('disabled', true);
    }
    show_invoice_preview();
});
$(document).on('change', '#prefix', function() {
    show_invoice_preview();
});
$(document).on('keyup', '#prefix', function() {
    show_invoice_preview();
});
$(document).on('keyup', '#start_number', function() {
    show_invoice_preview();
});
$(document).on('change', '#total_digits', function() {
    show_invoice_preview();
});

function show_invoice_preview() {
    var prefix = $('#prefix').val();
    var start_number = $('#start_number').val();
    var total_digits = $('#total_digits').val();
    var preview = prefix + pad_zero(start_number, total_digits);
    $('#preview_format').text('#' + preview);
}

function pad_zero(str, max) {
    str = str.toString();
    return str.length < max ? pad_zero('0' + str, max) : str;
}
$(document).on('change', '.toggler', function() {
    var parent_id = $(this).attr('data-toggle_id');
    if ($(this).is(':checked')) {
        $('#' + parent_id).removeClass('hide');
    } else {
        $('#' + parent_id).addClass('hide');
    }
});

if ($('.product_form').length) {
    show_product_type_form();
}
$('#type').change(function() {
    show_product_type_form();
});
$(document).on('change', '#category_id, #brand_id', function() {
    get_models();
});

function show_product_type_form() {
    var product_type = 'single';
    if ($('#type').val() === 'variable') {
        product_type = 'variable';
    }
    var action = $('#type').attr('data-action');
    var product_id = $('#type').attr('data-product_id');
    $.ajax({
        method: 'POST',
        url: '/admin/products/product_form_part',
        dataType: 'html',
        data: {
            type: product_type,
            product_id: product_id,
            action: action
        },
        success: function(result) {
            if (result) {
                $('#product_form_part').html(result);
                toggle_dsp_input();
                _componentSelect2();
                _componentTooltipCustomColor();
            }
        },
    });
}

function toggle_dsp_input() {
    var tax_type = $('#tax_type').val();
    if (tax_type == 'inclusive') {
        $('.dsp_label').each(function() {
            $(this).text(Lang.get('product.inc_of_tax'));
        });
        $('#single_dsp').addClass('hide');
        $('#single_dsp_inc_tax').removeClass('hide');
        $('.add-product-price-table')
            .find('.variable_dsp_inc_tax')
            .each(function() {
                $(this).removeClass('hide');
            });
        $('.add-product-price-table')
            .find('.variable_dsp')
            .each(function() {
                $(this).addClass('hide');
            });
    } else if (tax_type == 'exclusive') {
        $('.dsp_label').each(function() {
            $(this).text(Lang.get('product.exc_of_tax'));
        });
        $('#single_dsp').removeClass('hide');
        $('#single_dsp_inc_tax').addClass('hide');
        $('.add-product-price-table')
            .find('.variable_dsp_inc_tax')
            .each(function() {
                $(this).addClass('hide');
            });
        $('.add-product-price-table')
            .find('.variable_dsp')
            .each(function() {
                $(this).removeClass('hide');
            });
    }
}

function get_product_details(rowData) {
    var div = $('<div/>')
        .addClass('loading')
        .text('Loading...');
    $.ajax({
        url: '/admin/products/' + rowData.id,
        dataType: 'html',
        success: function(data) {
            div.html(data).removeClass('loading');
        },
    });
    return div;
}


$(document).on('click', '#add_variation', function() {
    var row_index = $('#variation_counter').val();
    var action = $(this).attr('data-action');
    $.ajax({
        method: 'POST',
        url: '/admin/products/get_product_variation_row',
        data: {
            row_index: row_index,
            action: action
        },
        dataType: 'html',
        success: function(result) {
            if (result) {
                $('#product_variation_form_part  > tbody').append(result);
                $('#variation_counter').val(parseInt(row_index) + 1);
                toggle_dsp_input();
            }
        },
    });
});

function get_models() {
    var cat = $('#category_id').val();
    var brand = $('#brand_id').val();
    if (cat && brand) {
        $.ajax({
            method: 'POST',
            url: '/admin/products/get_models',
            dataType: 'html',
            data: {
                cat_id: cat,
                brand_id: brand
            },
            success: function(result) {
                if (result) {
                    $('#model_id').html(result);
                }
            },
        });
    }

}

function __read_number(input_element, use_page_currency = false) {
    return __number_uf(input_element.val(), use_page_currency);
}

function __number_uf(input, use_page_currency = false) {
    if (use_page_currency && __currency_decimal_separator) {
        var decimal = __p_currency_decimal_separator;
    } else {
        var decimal = __currency_decimal_separator;
    }

    return accounting.unformat(input, decimal);
}

//Add specified percentage to the input amount.
function __add_percent(amount, percentage = 0) {
    var amount = parseFloat(amount);
    var percentage = isNaN(percentage) ? 0 : parseFloat(percentage);

    return amount + (percentage / 100) * amount;
}


//Write input by converting to formatted number
function __write_number(
    input_element,
    value,
    use_page_currency = false,
    precision = __currency_precision
) {
    if (input_element.hasClass('input_quantity')) {
        precision = __quantity_precision;
    }

    input_element.val(__number_f(value, false, use_page_currency, precision));
}

//Alias of currency format, formats number
function __number_f(
    input,
    show_symbol = false,
    use_page_currency = false,
    precision = __currency_precision
) {
    return __currency_trans_from_en(input, show_symbol, use_page_currency, precision);
}

//Returns the principle amount for the calculated amount and percentage
function __get_principle(amount, percentage = 0, minus = false) {
    var amount = parseFloat(amount);
    var percentage = isNaN(percentage) ? 0 : parseFloat(percentage);

    if (minus) {
        return (100 * amount) / (100 - percentage);
    } else {
        return (100 * amount) / (100 + percentage);
    }
}

$(document).on('change', '#brand_id, #category_id, #model_id', function() {

    var product_name = '';

    var brand_name = $('#brand_id option:selected').html();
    var brand_val = $('#brand_id').val();
    if (brand_name && brand_val) {
        product_name += ' ' + brand_name;
    }

    var model_name = $('#model_id option:selected').html();
    var model_val = $('#model_id').val();
    if (model_name && model_val) {
        product_name += ' ' + model_name;
    }

    var category_name = $('#category_id option:selected').html();
    var category_val = $('#category_id').val();
    if (category_name && category_val) {
        product_name += ' ' + category_name;
    }


    $('#name').val(product_name);
})

$(document).on('click', '.submit_product_form', function(e) {
    var submit_type = $(this).attr('value');
    $('#submit_type').val(submit_type);
});