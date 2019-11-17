/* ------------------------------------------------------------------------------
 *
 *  # Velocity animations - advanced examples
 *
 *  Demo JS code for animations_velocity_examples.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var AnimationsVelocityAdvanced = function() {


    //
    // Setup module components
    //

    // Velocity advanced
    var _componentAnimationVelocityAdvanced = function() {
        if (!$().velocity) {
            console.warn('Warning - velocity.min.js is not loaded.');
            return;
        }

        //
        // Animate layout on page load
        //

        // Hide elements first
        $('.sidebar, .navbar, .navbar-text, .navbar-nav .nav-item, .page-header, .page-title, .page-header .header-elements, .breadcrumb, .breadcrumb-elements-item, .content > .card, .content .row > [class*=col-], .footer')
            .css('opacity', 0);
    };


    // Animate layout on window load
    var _componentAnimationVelocityLayout = function() {
        if (!$().velocity) {
            console.warn('Warning - velocity.min.js is not loaded.');
            return;
        }

        // Layout parts - flex
        $('.navbar, .page-title, .page-header .header-elements, .breadcrumb, .content > .card, .footer')
            .css('opacity', 1)
            .velocity('transition.slideDownIn', {
                stagger: 200,
                duration: 200,
                display: 'flex',
                complete: function(elements) {
                    $(this).removeAttr('style');
                }
            });

        // Layout parts - block
        $('.navbar-text, .navbar-nav .nav-item, .page-header, .content .row > [class*=col-], .breadcrumb-elements-item')
            .css('opacity', 1)
            .velocity('transition.slideUpIn', {
                stagger: 200,
                duration: 200,
                complete: function(elements) {
                    $(this).removeAttr('style');
                }
            });

        // Sidebar
        $('.sidebar')
            .css({
                opacity: 0,
                borderColor: 'transparent'
            })
            .velocity('transition.slideUpIn', {
                delay: 100,
                duration: 500,
                complete: function(elements) {
                    $(this).removeAttr('style');
                }
            });

        // Navigation list on load
        $('.nav-sidebar > .nav-item, .nav-sidebar > .nav-item-header')
            .css('opacity', 0)
            .velocity('transition.slideLeftIn', {
                delay: 500,
                stagger: 75,
                duration: 200,
                complete: function(elements) {
                    $(this).removeAttr('style')
                }
            });

        // Navigation list on click
        $('.nav-sidebar .nav-item-submenu > .nav-link').on('click', function() {
            if (!$(this).parent().hasClass('nav-item-open')) {
                $(this).next('.nav-group-sub').children('.nav-item').css('opacity', 0).velocity('transition.fadeIn', {
                    delay: 100,
                    stagger: 30,
                    duration: 200,
                    complete: function(elements) {
                        $(this).removeAttr('style')
                    }
                });
            } else {
                $(this).next('.nav-group-sub').children('.nav-item').css('opacity', 0).velocity('transition.fadeOut', {
                    duration: 200,
                    complete: function(elements) {
                        $(this).removeAttr('style')
                    }
                });
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentAnimationVelocityAdvanced();
        },
        initOnLoad: function() {
            _componentAnimationVelocityLayout();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    AnimationsVelocityAdvanced.init();
});

$(window).on('load', function() {
    AnimationsVelocityAdvanced.initOnLoad();
});