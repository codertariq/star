Lang.setLocale($('html').attr('lang'));
paceOptions = {
    ajax: true,
};
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
                        status: status
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
    var audio = $('#success-audio')[0];
    if (audio !== undefined) {
        audio.play();
    }
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
    let card = button.closest('.card');
    if (card.length > 0) {
        cardUnblock(card);
        return;
    }
    let modal = button.closest('.modal-content');
    if (modal.length > 0) {
        cardUnblock(modal);
        return;
    }
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

$('#content_modal').on('hide.bs.modal', function() {
    hide_submit_loading();
    $('.modal-body').html('');
});
$('#content_modal').on('shown.bs.modal', function(e) {
    var ele = $(e.target).find('input[type=text],textarea,select').filter(':visible:first'); // find the first input on the bs modal
    console.log(ele);
    if (ele.length > 0) {
        ele.focus();
    }
});
