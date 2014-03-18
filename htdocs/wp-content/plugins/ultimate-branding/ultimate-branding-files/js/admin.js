/* Selecting valid menu item based on the current tab */

jQuery(document).ready(function() {
    if (ub_admin.current_menu_sub_item !== null) {
        jQuery('#adminmenu .wp-submenu li.current').removeClass("current");
        jQuery('a[href="admin.php?page=branding&tab=' + ub_admin.current_menu_sub_item + '"]').parent().addClass("current");
    }
});

/* Native WP media for custom login image module */

jQuery(document).ready(function()
{
    jQuery('#wp_login_image_button').click(function()
    {
        wp.media.editor.send.attachment = function(props, attachment)
        {
            jQuery('#wp_login_image').val(attachment.url);
            jQuery('#wp_login_image_id').val(attachment.id);
            jQuery('#wp_login_image_size').val(props.size);
        }

        wp.media.string.props = function(props, attachment)
        {
            jQuery('#wp_login_image').val(props.url);
            jQuery('#wp_login_image_id').val("");
            jQuery('#wp_login_image_size').val("full");
            jQuery('#wp_login_image_width').val(props.width);
            jQuery('#wp_login_image_height').val(props.height);
        }

        wp.media.editor.open(this);
        return false;
    });

    jQuery('#wp_favicon_button').click(function()
    {
        wp.media.editor.send.attachment = function(props, attachment)
        {
            jQuery('#wp_favicon').val(attachment.url);
            jQuery('#wp_favicon_id').val(attachment.id);
            jQuery('#wp_favicon_size').val(props.size);
        }

        wp.media.string.props = function(props, attachment)
        {
            jQuery('#wp_favicon').val(props.url);
            jQuery('#wp_favicon_id').val("");
            jQuery('#wp_favicon_size').val("full");
        }


        wp.media.editor.open(this);
        return false;
    });
});

