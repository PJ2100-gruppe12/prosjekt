<?php
/*
  Plugin Name: Custom Multisite Favicons
  Plugin URI:
  Description: Change the Favicon for the network
  Author: Marko Miljus (Incsub), Barry (Incsub), Philip John (Incsub)
  Version: 2.0
  Author URI:
  Network: true

  Copyright 2013 Incsub

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

class ub_favicons {

    var $build = 2;
    var $db;

    function __construct() {

        // Admin interface
        add_action('ultimatebranding_settings_menu_images', array(&$this, 'manage_output'));
        add_filter('ultimatebranding_settings_menu_images_process', array(&$this, 'process'));

        add_action('admin_head', array(&$this, 'admin_head'));
        add_action('admin_head', array(&$this, 'global_head'));
        add_action('wp_head', array(&$this, 'global_head'));

        add_action('wp_before_admin_bar_render', array(&$this, 'change_blavatar_icon'));
    }

    function ub_favicons() {
        $this->__construct();
    }

    function get_url_valid_shema($url) {
        $image = $url;

        $v_image_url = parse_url($url);

        if (isset($v_image_url['scheme']) && $v_image_url['scheme'] == 'https') {
            if (!is_ssl()) {
                $image = str_replace('https', 'http', $image);
            }
        } else {
            if (is_ssl()) {
                $image = str_replace('http', 'https', $image);
            }
        }

        return $image;
    }

    function process() {
        global $plugin_page;

        if (isset($_GET['resetfavicon']) && isset($_GET['page']) && $_GET['page'] == 'branding') {
            //login_image_save
            ub_delete_option('ub_favicon');
            ub_delete_option('ub_favicon_id');
            ub_delete_option('ub_favicon_size');
            ub_delete_option('ub_favicon_dir');
            ub_delete_option('ub_favicon_url');

            $uploaddir = ub_wp_upload_dir();
            $uploadurl = ub_wp_upload_url();

            $response = wp_remote_head(admin_url() . 'images/wordpress-logo.svg');

            ub_update_option('ub_favicon', false);

            wp_redirect('admin.php?page=branding&tab=images');
        } elseif (isset($_POST['wp_favicon'])) {
            ub_update_option('ub_favicon', $_POST['wp_favicon']);
            ub_update_option('ub_favicon_id', $_POST['wp_favicon_id']);
            ub_update_option('ub_favicon_size', $_POST['wp_favicon_size']);
        }

        return true;
    }

    function manage_output() {
        global $wpdb, $current_site, $page;

        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');
        wp_enqueue_media();
        wp_enqueue_script('media-upload');

        if (isset($_GET['error']))
            echo '<div id="message" class="error fade"><p>' . __('There was an error uploading the file, please try again.', 'ub') . '</p></div>';
        elseif (isset($_GET['updated']))
            echo '<div id="message" class="updated fade"><p>' . __('Changes saved.', 'ub') . '</p></div>';


        $uploaddir = ub_wp_upload_dir();
        $uploadurl = ub_wp_upload_url();

        $favicon = ub_get_option('ub_favicon', false);
        $favicon_dir = ub_get_option('ub_favicon_dir', false);
        $favicon_url = ub_get_option('ub_favicon_url', false);

        /* if (!$favicon) {

          // Check for backwards compatibility
          if (!$favicon_dir && file_exists($uploaddir . '/ultimate-branding/includes/favicon/favicon.png')) {
          ub_update_option('ub_favicon_dir', $uploaddir . '/ultimate-branding/includes/favicon/favicon.png');
          ub_update_option('ub_favicon_url', $uploadurl . '/ultimate-branding/includes/favicon/favicon.png');

          $favicon_dir = ub_get_option('ub_favicon_dir', false);
          $favicon_url = ub_get_option('ub_favicon_url', false);
          }
          } */
        ?>

        <div class='wrap nosubsub'>
            <div class="icon32" id="icon-themes"><br /></div>
            <h2><?php _e('Favicons', 'ub') ?></h2>

            <div class="postbox">
                <div class="inside">
                    <p class='description'><?php _e('This is the image that is displayed as a Favicon - ', 'ub'); ?>
                        <a href='<?php echo wp_nonce_url("admin.php?page=" . $page . "&amp;tab=images&amp;resetfavicon=yes&amp;action=process", 'ultimatebranding_settings_menu_images') ?>'><?php _e('Reset the image', 'login_image') ?></a>
                    </p>
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_images');
                    $favicon_old = ub_get_option('ub_favicon_url', false);
                    $favicon_id = ub_get_option('ub_favicon_id', false);
                    $favicon_size = ub_get_option('ub_favicon_size', false);
                    $favicon = ub_get_option('ub_favicon', false);

                    if (!$favicon) {
                        if (isset($favicon_old) && trim($favicon_old) !== '') {
                            $favicon = $this->get_url_valid_shema($favicon_old);
                        } else {
                            if ($favicon_id) {
                                if (is_multisite() && function_exists('is_plugin_active_for_network') && is_plugin_active_for_network('ultimate-branding/ultimate-branding.php')) {
                                    switch_to_blog(1);
                                    $favicon_src = wp_get_attachment_image_src($favicon_id, $favicon_size, $icon = false);
                                    restore_current_blog();
                                } else {
                                    $favicon_src = wp_get_attachment_image_src($favicon_id, $favicon_size, $icon = false);
                                }
                                $favicon = $favicon_src[0];
                                $width = $favicon_src[1];
                                $height = $favicon_src[2];
                            } else if ($favicon) {
                                list($width, $height) = getimagesize($favicon);
                            } else {
                                $response = wp_remote_head(admin_url() . 'images/wordpress-logo.svg');
                                if (!is_wp_error($response) && !empty($response['response']['code']) && $response['response']['code'] == '200') {//support for 3.8+
                                    $favicon = false; //admin_url() . 'images/wordpress-logo.svg';
                                } else {
                                    $favicon = false; //admin_url() . 'images/wordpress-logo.png';
                                }
                            }
                        }
                    }
                    ?>
                    <?php if ($favicon) { ?>
                        <img src="<?php echo $this->get_url_valid_shema($favicon) . '?' . md5(time()); ?>" width="16" height="16" />
                    <?php } else { ?>
                        <img src="<?php echo admin_url() . 'images/wordpress-logo.svg' . '?' . md5(time()); ?>" width="16" height="16" />
                    <?php } ?>
                    <h4><?php _e('Change Favicon', 'ub'); ?></h4>

                    <input class="upload-url" id="wp_favicon" type="text" size="36" name="wp_favicon" value="<?php echo esc_attr($this->get_url_valid_shema($favicon)); ?>" />
                    <input class="st_upload_button" id="wp_favicon_button" type="button" value="<?php _e('Browse', 'ub'); ?>" />
                    <input type="hidden" name="favicon_id" id="wp_favicon_id" value="<?php echo esc_attr($favicon_id); ?>" />
                    <input type="hidden" name="wp_favicon_size" id="wp_favicon_size" value="<?php echo esc_attr($favicon_size); ?>" />
                </div>
            </div>
        </div>

        <?php
    }

    function remove_file($file) {
        @chmod($file, 0777);
        if (@unlink($file)) {
            return true;
        } else {
            return false;
        }
    }

    function admin_head() {

        $uploaddir = ub_wp_upload_dir();
        $uploadurl = ub_wp_upload_url();

        $uploadurl = preg_replace(array('/http:/i', '/https:/i'), '', $uploadurl);
        $favicon = ub_get_option('ub_favicon', false);

        if (file_exists($uploaddir . '/ultimate-branding/includes/favicon/favicon.png') || $favicon) {

            if (!$favicon) {
                $site_ico = $uploadurl . '/ultimate-branding/includes/favicon/favicon.png';
            } else {
                $site_ico = $this->get_url_valid_shema($favicon);
            }

            echo '<style type="text/css">
			#header-logo { background-image: url(' . $site_ico . '); }
			#wp-admin-bar-wp-logo > .ab-item .ab-icon { background-image: url(' . $site_ico . '); background-position: 0; }
			#wp-admin-bar-wp-logo:hover > .ab-item .ab-icon { background-image: url(' . $site_ico . '); background-position: 0 !Important; }
			#wp-admin-bar-wp-logo.hover > .ab-item .ab-icon { background-image: url(' . $site_ico . '); background-position: 0 !Important; }
			</style>';
        }
    }

    function global_head() {

        $uploaddir = ub_wp_upload_dir();
        $uploadurl = ub_wp_upload_url();

        $favicon_dir = ub_get_option('ub_favicon_dir', false);
        $favicon_url = ub_get_option('ub_favicon_url', false);
        $favicon = ub_get_option('ub_favicon', false);

        // Check for backwards compatibility
        /* if (!$favicon_dir && file_exists($uploaddir . '/ultimate-branding/includes/favicon/favicon.png')) {
          ub_update_option('ub_favicon_dir', $uploaddir . '/ultimate-branding/includes/favicon/favicon.png');
          ub_update_option('ub_favicon_url', $uploadurl . '/ultimate-branding/includes/favicon/favicon.png');

          $favicon_dir = ub_get_option('ub_favicon_dir', false);
          $favicon_url = ub_get_option('ub_favicon_url', false);
          } */

        if ($favicon) {
            $favicon_url = $favicon;
        }

        if ($favicon_dir && file_exists($favicon_dir) || $favicon) {
            $favicon_url = preg_replace(array('/http:/i', '/https:/i'), '', $favicon_url);
            echo '<link rel="shortcut icon" href="' . $this->get_url_valid_shema($favicon_url) . '" />';
        }
    }

    function change_blavatar_icon() {
        global $wp_admin_bar;

        $favicon = ub_get_option('ub_favicon', false);

        foreach ((array) $wp_admin_bar->user->blogs as $blog) {
            // Our new blavatar
            if (is_multisite() && function_exists('is_plugin_active_for_network') && is_plugin_active_for_network('ultimate-branding/ultimate-branding.php')) {
                $favicon_url = get_site_option('ub_favicon_url', false);

                if ($favicon) {
                    $favicon_url = $favicon;
                }
            } else {
                if (function_exists('switch_to_blog')) {
                    switch_to_blog($blog->userblog_id);
                }

                $favicon_url = get_option('ub_favicon_url', false);

                if ($favicon) {
                    $favicon_url = $favicon;
                }

                if (function_exists('restore_current_blog')) {
                    restore_current_blog();
                }
            }

            if (empty($favicon_url)) {
                //$blue_wp_logo_url = includes_url('images/wpmini-blue.png');
                //$blavatar = '<img src="' . esc_url($blue_wp_logo_url) . '" alt="' . esc_attr__('Blavatar') . '" width="16" height="16" class="blavatar"/>';
            } else {
                echo '<style>#wpadminbar .quicklinks li .blavatar{width: 16px;height: 16px;padding-right: 5px;padding-top: 5px;}</style>';
                $favicon_url = preg_replace(array('/http:/i', '/https:/i'), '', $favicon_url);
                if ($favicon) {
                    $favicon_url = $favicon;
                }
                $blavatar = '<img src="' . $this->get_url_valid_shema(esc_url($favicon_url)) . '" alt="' . esc_attr__('Blavatar') . '" width="16" height="16" class="blavatar"/>';
            }

            $blogname = empty($blog->blogname) ? $blog->domain : $blog->blogname;
            $menu_id = 'blog-' . $blog->userblog_id;

            // Get the information for our menu item
            $oldnode = $wp_admin_bar->get_node('blog-' . $blog->userblog_id);
            // Remove it
            $wp_admin_bar->remove_node('blog-' . $blog->userblog_id);
            // Update and add it back in again
            $wp_admin_bar->add_menu(array(
                'parent' => 'my-sites-list',
                'id' => 'blog-' . $blog->userblog_id,
                'title' => $blavatar . $blogname,
                'href' => get_admin_url($blog->userblog_id),
            ));
        }
    }

}

$ub_favicons = new ub_favicons();
?>