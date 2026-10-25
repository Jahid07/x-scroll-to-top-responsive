jQuery(document).ready(function ($) {
    $('#delete-old-settings').on('click', function (e) {
        e.preventDefault();

        if (confirm('Are you sure you want to delete the old settings?')) {
            $.ajax({
                url: xscrollAdmin.ajax_url,
                type: 'post',
                data: {
                    action: 'delete_old_xscroll_settings',
                    nonce: xscrollAdmin.nonce,
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.data.message);
                        window.location.href = response.data.redirect_url;
                    } else {
                        alert('An error occurred while deleting the settings.');
                    }
                },
                error: function () {
                    alert('An error occurred while deleting the settings.');
                }
            });
        }
    });
});
