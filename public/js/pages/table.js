/* ------------------------------------------------------------------------------
 *
 *  # Responsive extension for Datatables
 *
 *  Demo JS code for datatable_responsive.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var DatatableResponsive = function() {

    // Basic Datatable examples
    var _componentDatatableResponsive = function() {
        if (!$().DataTable) {
            p_notify(Lang.get('service.not_loaded', {
                attribute: 'datatable.min.js'
            }), 'warning', 'Warning!!');
            return;
        }
        $(document).on('search.dt', function(e, settings) {
            dataTableCardReload(false);
        });
        $(document).on('change', 'page.dt', function(e, settings) {
            dataTableCardReload(false);
        });
        $(document).on('change', 'preInit.dt', function(e, settings) {
            dataTableCardReload(false);
        });
        $(document).on('change', 'order.dt', function(e, settings) {
            dataTableCardReload(false);
        });
        $(document).on('change', 'preInit.dt', function(e, settings) {
            dataTableCardReload(false);
        });
        //Column controlled child rows
        $('.content_management_datatable').DataTable({
            fnDrawCallback: function(oSettings) {
                dataTableCardReload();
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
                extend: 'selected',
                className: 'btn btn-light'
            }, {
                extend: 'selectAll',
                className: 'btn bg-blue'
            }, {
                extend: 'selectNone',
                className: 'btn bg-blue'
            }, ]
        });

    };

    // Select2 for length menu styling
    var _componentSelect2 = function() {
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


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableResponsive();
            _componentSelect2();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableResponsive.init();
});