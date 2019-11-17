document.addEventListener('DOMContentLoaded', function() {
    if ($('.sidebar-fixed .sidebar-content').length > 0) {
        _componentPerfectScrollbar('.sidebar-fixed .sidebar-content');
    }
});