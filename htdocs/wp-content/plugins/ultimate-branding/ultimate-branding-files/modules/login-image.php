<?php
/*
  Plugin Name: Login Image
  Plugin URI: http://premium.wpmudev.org/project/login-image
  Description: Allows you to change the login image
  Author: Marko Miljus (Incsub), Andrew Billits, Ulrich Sossou (Incsub)
  Version: 2.1
  Author URI: http://premium.wpmudev.org/
  Text_domain: login_image
  Network: true
  WDP ID: 169
 */

/*
  Copyright 2007-2014 Incsub (http://incsub.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
  the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

class ub_Login_Image {

    function __construct() {
        global $wp_version;

        //Check for backwards compatibility

        $uploaddir = ub_wp_upload_dir();
        $login_image_old = ub_get_option('ub_login_image_url', false);
        $login_image = ub_get_option('ub_login_image', false);

        if (!isset($login_image_old) || $login_image_old == '') {
            //there is no any old record
            if (!$login_image) {//add default image if not exists
                $response = wp_remote_head(admin_url() . 'images/wordpress-logo.svg');
                if (!is_wp_error($response) && !empty($response['response']['code']) && $response['response']['code'] == '200') {//support for 3.8+
                    ub_update_option('ub_login_image', admin_url() . 'images/wordpress-logo.svg');
                } else {
                    ub_update_option('ub_login_image', admin_url() . 'images/wordpress-logo.png'); // for older version
                }
            }
        } else {//there IS an OLD RECORD
            ub_update_option('ub_login_image', $login_image_old); //we will assume that file is in place
            ub_update_option('ub_login_image_url', '');
        }

        // Admin interface

        add_action('ultimatebranding_settings_menu_images', array(&$this, 'manage_output'));
        add_filter('ultimatebranding_settings_menu_images_process', array(&$this, 'process'));

        // Login interface
        add_action('login_head', array(&$this, 'stylesheet'), 999);



        if (!is_multisite()) {
            add_filter('login_headerurl', array(&$this, 'home_url'));
        }
    }

    /*
      function add_delete_page_style(){
      add_action('wp_admin_css', array(&$this, 'stylesheet'));
      } */

    function ub_Login_Image() {
        $this->__construct();
    }

    /**
     * Add site admin page
     * */
    function change_wp_login_title() {
        return esc_attr(bloginfo('name'));
    }

    function home_url() {
        return home_url();
    }

    function stylesheet() {
        global $current_site;

        $login_image_old = ub_get_option('ub_login_image_url', false);
        $login_image_id = ub_get_option('ub_login_image_id', false);
        $login_image_size = ub_get_option('ub_login_image_size', false);
        $login_image_width = ub_get_option('ub_login_image_width', false);
        $login_image_height = ub_get_option('ub_login_image_height', false);
        $login_image = ub_get_option('ub_login_image', false);

        if (isset($login_image_old) && trim($login_image_old) !== '') {
            $login_image = $login_image_old;
        } else {
            if ($login_image_id) {
                if (is_multisite() && function_exists('is_plugin_active_for_network') && is_plugin_active_for_network('ultimate-branding/ultimate-branding.php')) {
                    switch_to_blog(1);
                    $login_image_src = wp_get_attachment_image_src($login_image_id, $login_image_size, $icon = false);
                    restore_current_blog();
                } else {
                    $login_image_src = wp_get_attachment_image_src($login_image_id, $login_image_size, $icon = false);
                }
                $login_image = $login_image_src[0];
                $width = $login_image_src[1];
                $height = $login_image_src[2];
            } else if ($login_image) {
                if ($login_image_width && $login_image_height) {
                    $width = $login_image_width;
                    $height = $login_image_height;
                } else {
                    list($width, $height) = getimagesize($login_image);
                }
            } else {
                $response = wp_remote_head(admin_url() . 'images/wordpress-logo.svg');
                if (!is_wp_error($response) && !empty($response['response']['code']) && $response['response']['code'] == '200') {//support for 3.8+
                    $login_image = admin_url() . 'images/wordpress-logo.svg';
                } else {
                    $login_image = admin_url() . 'images/wordpress-logo.png';
                }
            }
        }

        $login_image = ub_get_url_valid_shema($login_image);

        ?>
        <style type="text/css">
            .login h1 a {
                background-image: url("<?php echo $login_image; ?>");
                background-size: <?php echo $width; ?>px <?php echo $height; ?>px;
                background-position: center top;
                background-repeat: no-repeat;
                color: rgb(153, 153, 153);
                height: <?php echo $height; ?>px;
                font-size: 20px;
                font-weight: 400;
                line-height: 1.3em;
                margin: 0px auto 25px;
                padding: 0px;
                text-decoration: none;
                width: <?php echo $width; ?>px;
                text-indent: -9999px;
                outline: 0px none;
                overflow: hidden;
                display: block;
            }
        </style>
        <?php
    }

    function process() {
        global $plugin_page;

        if (isset($_GET['reset']) && isset($_GET['page']) && $_GET['page'] == 'branding') {
            //login_image_save
            ub_delete_option('ub_login_image');
            ub_delete_option('ub_login_image_id');
            ub_delete_option('ub_login_image_size');
            ub_delete_option('ub_login_image_width');
            ub_delete_option('ub_login_image_height');

            $uploaddir = ub_wp_upload_dir();
            $uploadurl = ub_wp_upload_url();

            $response = wp_remote_head(admin_url() . 'images/wordpress-logo.svg');

            if (!is_wp_error($response) && !empty($response['response']['code']) && $response['response']['code'] == '200') {//support for 3.8+
                ub_update_option('ub_login_image', admin_url() . 'images/wordpress-logo.svg');
            } else {
                ub_update_option('ub_login_image', admin_url() . 'images/wordpress-logo.png');
            }

            wp_redirect('admin.php?page=branding&tab=images');
        } elseif (isset($_POST['wp_login_image'])) {
            ub_update_option('ub_login_image', $_POST['wp_login_image']);
            ub_update_option('ub_login_image_id', $_POST['wp_login_image_id']);
            ub_update_option('ub_login_image_size', $_POST['wp_login_image_size']);
            ub_update_option('ub_login_image_width', $_POST['wp_login_image_width']);
            ub_update_option('ub_login_image_height', $_POST['wp_login_image_height']);
        }

        return true;
    }

    function manage_output() {
        global $wpdb, $current_site, $page;

        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');
        wp_enqueue_media();
        wp_enqueue_script('media-upload');

        $page = $_GET['page'];

        if (isset($_GET['error']))
            echo '<div id="message" class="error fade"><p>' . __('There was an error uploading the file, please try again.', 'login_image') . '</p></div>';
        elseif (isset($_GET['updated']))
            echo '<div id="message" class="updated fade"><p>' . __('Changes saved.', 'ub') . '</p></div>';
        ?>
        <div class='wrap nosubsub'>
            <div class="icon32" id="icon-themes"><br /></div>
            <h2><?php _e('Login Image', 'login_image') ?></h2>
            <!--<form name="login_image_form" id="login_image_form" method="post">-->
            <div class="postbox">
                <div class="inside">
                    <p class='description'><?php _e('This is the image that is displayed on the login page (wp-login.php) - ', 'login_image'); ?>
                        <a href='<?php echo wp_nonce_url("admin.php?page=" . $page . "&amp;tab=images&amp;reset=yes&amp;action=process", 'ultimatebranding_settings_menu_images') ?>'><?php _e('Reset the image', 'login_image') ?></a>
                    </p>
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_images');
                    $login_image_old = ub_get_option('ub_login_image_url', false);
                    $login_image_id = ub_get_option('ub_login_image_id', false);
                    $login_image_size = ub_get_option('ub_login_image_size', false);
                    $login_image_width = ub_get_option('ub_login_image_width', false);
                    $login_image_height = ub_get_option('ub_login_image_height', false);
                    $login_image = ub_get_option('ub_login_image', false);

                    if (isset($login_image_old) && trim($login_image_old) !== '') {
                        $login_image = $login_image_old;
                    } else {
                        if ($login_image_id) {
                            if (is_multisite() && function_exists('is_plugin_active_for_network') && is_plugin_active_for_network('ultimate-branding/ultimate-branding.php')) {
                                switch_to_blog(1);
                                $login_image_src = wp_get_attachment_image_src($login_image_id, $login_image_size, $icon = false);
                                restore_current_blog();
                            } else {
                                $login_image_src = wp_get_attachment_image_src($login_image_id, $login_image_size, $icon = false);
                            }
                            $login_image = $login_image_src[0];
                            $width = $login_image_src[1];
                            $height = $login_image_src[2];
                        } else if ($login_image) {
                            if ($login_image_width && $login_image_height) {
                                $width = $login_image_width;
                                $height = $login_image_height;
                            } else {
                                list($width, $height) = getimagesize($login_image);
                            }
                        } else {
                            $response = wp_remote_head(admin_url() . 'images/wordpress-logo.svg');
                            if (!is_wp_error($response) && !empty($response['response']['code']) && $response['response']['code'] == '200') {//support for 3.8+
                                $login_image = admin_url() . 'images/wordpress-logo.svg';
                            } else {
                                $login_image = admin_url() . 'images/wordpress-logo.png';
                            }
                        }
                    }
                    ?>
                    <img src="<?php echo $login_image . '?' . md5(time()); ?>" />
                    </p>

                    <h4><?php _e('Change Image', 'login_image'); ?></h4>

                    <input class="upload-url" id="wp_login_image" type="text" size="36" name="wp_login_image" value="<?php echo esc_attr($login_image); ?>" />
                    <input class="st_upload_button" id="wp_login_image_button" type="button" value="<?php _e('Browse', 'login_image'); ?>" />
                    <input type="hidden" name="wp_login_image_id" id="wp_login_image_id" value="<?php echo esc_attr($login_image_id); ?>" />
                    <input type="hidden" name="wp_login_image_size" id="wp_login_image_size" value="<?php echo esc_attr($login_image_size); ?>" />
                    <input type="hidden" name="wp_login_image_width" id="wp_login_image_width" value="<?php echo esc_attr($login_image_width); ?>" />
                    <input type="hidden" name="wp_login_image_height" id="wp_login_image_height" value="<?php echo esc_attr($login_image_height); ?>" />
                </div>
            </div>
        </div>

        <?php
    }

}

$ub_loginimage = new ub_Login_Image();