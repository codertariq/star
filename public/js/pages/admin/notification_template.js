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
            FormHandle.init('#content_form');
        }
    }
}();
// Initialize module
// ------------------------------
document.addEventListener('DOMContentLoaded', function() {
    DatatableResponsive.init();
});