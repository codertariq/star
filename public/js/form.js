/* ------------------------------------------------------------------------------
 *
 *  # Responsive extension for Datatables
 *
 *  Demo JS code for datatable_responsive.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var FormHandle = function() {


    // Basic Datatable examples
    var _componentValidation = function(form) {
        form.parsley().on('field:validated', function() {
            const ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });

    };

    // Select2 for length menu styling
    var _componentSubmit = function(form) {
        form.on('submit', function(e) {
            e.preventDefault();
            $('.parsley-required').remove();
            const submit = $('#submit');
            show_submit_loading(submit);
            const submit_val = submit.val();
            const submit_url = form.attr('action');
            //Start Ajax
            const formData = new FormData(form[0]);
            formData.append('submit', submit_val);
            $.ajax({
                url: submit_url,
                type: 'POST',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    ajax_success(data, form);
                    hide_submit_loading(form);
                },
                error: function(data) {
                    ajax_error(data, form);
                    hide_submit_loading(form);
                }
            });
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function(form_id = '#content_form') {
            let form = $(form_id);
            if (form.length <= 0) {
                p_notify(Lang.get('service.not_loaded', {
                    attribute: Lang.get('service.content_management_form')
                }), 'warning', Lang.get('service.warning_title'));
                return;
            }
            _componentValidation(form);
            _componentSubmit(form);
        }
    }
}();
