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
    var _componentDatatableResponsive = function() {
        if (!$().DataTable) {
            p_notify(Lang.get('service.not_loaded', {
                attribute: 'datatable.min.js'
            }), 'warning', Lang.get('service.warning_title'));
            return;
        }
        tariq = $('.content_management_datatable').DataTable({
            fnDrawCallback: function(oSettings) {
                dataTableCardReload(true, true, true);

            },
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [{
                className: 'control',
                orderable: false,
                width: '30px',
                targets: 0
            }, {
                orderable: false,
                width: '100px',
                targets: -1
            }, {
                width: '50px',
                targets: 1
            }],
            buttons: [{
                extend: 'selectAll',
                className: 'btn bg-indigo-800'
            }, {
                extend: 'selectNone',
                className: 'btn bg-blue-800',
                text: 'Unselect All'
            }, {
                extend: 'selected',
                className: 'btn btn-danger',
                text: 'Delete',
                action: function(e, dt, node, config) {
                    datatableSelectedRowsAction(dt, 'action/variation-templates', action = 'delete', msg = Lang.get('service.delete_message'));
                }
            }],
            columns: [{
                defaultContent: '',
            }, {
                data: 'DT_RowIndex',
                name: 'id'
            }, {
                data: 'name'
            }, {
                data: 'values'
            }, {
                data: 'action'
            }]
        });

    };
    var _componentRemoteModalLoad = function() {
            $(document).on('click', '#content_managment', function(e) {
                e.preventDefault();
                $('#modal-loader').show();
                var modal = $('#content_modal');
                //open modal
                modal.modal('show');

                var element = $(this).data('element');
                // it will get action url
                var url = $(this).data('url');
                // leave it blank before ajax call
                // load ajax loader
                $.ajax({
                        url: url,
                        type: 'Get',
                        dataType: 'html'
                    })
                    .done(function(data) {
                        $('#modal-loader').hide();
                        $('.modal-body').html(data).fadeIn();
                        if (element == 'form') {
                            FormHandle.init();
                        }
                    })
                    .fail(function(data) {
                        $('#modal-loader').hide();
                        $('.modal-body').html('<span class="text-danger font-weight-bold" > ' + Lang.get('service.something_wrong') + '</span>').fadeIn();
                        ajax_error(data);
                    });
            });
        }
        //
        // Return objects assigned to module
        //
    return {
        init: function() {
            if ($('.content_management_datatable').length > 0) {
                _componentDatatableResponsive();
                _componentDataTableSelect2();
            }
            _componentRemoteModalLoad();


            $(document).on('click', '#add_variation_values', function() {
                var html =
                    '<div class="form-group row"><div class="col-sm-7 ml-auto"><input type="text" name="variation_values[]" class="form-control" required></div><div class="col-sm-2"><button type="button" class="btn btn-danger delete_variation_value">-</button></div></div>';
                $('#variation_values').append(html);
            });
            $(document).on('click', '.delete_variation_value', function() {
                $(this)
                    .closest('.form-group')
                    .remove();
            });
        }
    }
}();
// Initialize module
// ------------------------------
document.addEventListener('DOMContentLoaded', function() {
    DatatableResponsive.init();
});