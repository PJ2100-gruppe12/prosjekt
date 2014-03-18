<?php
if (!class_exists('UltimateBrandingAdmin')) {

    class UltimateBrandingAdmin {

        var $build = 1.53;
        var $modules = array(
            'login-image.php' => 'login-image/login-image.php',
            'custom-admin-bar.php' => 'custom-admin-bar/custom-admin-bar.php',
            'custom-email-from.php' => 'custom-email-from/custom-email-from.php',
            'remove-wp-dashboard-widgets.php' => 'remove-wp-dashboard-widgets/remove-wp-dashboard-widgets.php',
            'remove-dashboard-link-for-users-without-site.php' => 'remove-dashboard-link-for-users-without-site/remove-dashboard-link-for-users-without-site.php',
            'admin-help-content.php' => 'admin-help-content/admin-help-content.php',
            'global-footer-content.php' => 'global-footer-content/global-footer-content.php',
            'global-header-content.php' => 'global-header-content/global-header-content.php',
            //'admin-menu.php' => 'admin-menu/admin-menu.php',
            'admin-footer-text.php' => 'admin-footer-text/admin-footer-text.php',
            'rebranded-meta-widget.php' => 'rebranded-meta-widget/rebranded-meta-widget.php',
            'remove-permalinks-menu-item.php' => 'remove-permalinks-menu-item/remove-permalinks-menu-item.php',
            'site-generator-replacement.php' => 'site-generator-replacement/site-generator-replacement.php',
            'site-wide-text-change.php' => 'site-wide-text-change/site-wide-text-change.php',
            'favicons.php' => 'favicons.php',
            'custom-admin-css.php' => 'custom-admin-css.php',
            'custom-login-css.php' => 'custom-login-css.php',
            'custom-dashboard-welcome.php' => 'custom-dashboard-welcome.php',
            'ultimate-color-schemes.php' => 'ultimate-color-schemes.php'
        );
        var $plugin_msg = array();
        // Holder for the help class
        var $help;

        function __construct() {

            add_action('plugins_loaded', array(&$this, 'load_modules'));

            add_action('plugins_loaded', array(&$this, 'setup_translation'));

            add_action('init', array(&$this, 'initialise_ub'));

            add_action('admin_menu', array(&$this, 'admin_enqueues'));

            add_action('network_admin_menu', array(&$this, 'admin_enqueues'));
        }

        function admin_enqueues() {
            global $wp_version;

            if ($wp_version >= 3.8) {
                wp_register_style('ub-38', ub_files_url('css/admin-icon.css'));
                wp_enqueue_style('ub-38');
            }
        }

        function UltimateBrandingAdmin() {
            $this->__construct();
        }

        function transfer_old_settings() {
            if (is_multisite() && function_exists('is_plugin_active_for_network') && is_plugin_active_for_network('ultimate-branding/ultimate-branding.php')) {
                // Check for the original settings and if there are none, but there are some in the old location then move them across
                $modules = ub_get_option('ultimatebranding_activated_modules', array());
                if (empty($modules)) {
                    // none in our settings
                    $othermodules = get_option('ultimatebranding_activated_modules', array());
                    if (!empty($othermodules)) {
                        // We shall do a transfer across - first modules
                        ub_update_option('ultimatebranding_activated_modules', $othermodules);
                        // Next each set of settings for the activated modules
                        foreach ($othermodules as $key => $title) {
                            switch ($key) {
                                case 'favicons.php': ub_update_option('ub_favicon_dir', get_option('ub_favicon_dir'));
                                    ub_update_option('ub_favicon_url', get_option('ub_favicon_url'));
                                    break;

                                case 'login-image.php': ub_update_option('ub_login_image_dir', get_option('ub_login_image_dir'));
                                    ub_update_option('ub_login_image_url', get_option('ub_login_image_url'));
                                    break;

                                case 'custom-admin-bar.php': ub_update_option('wdcab', get_option('wdcab'));
                                    break;

                                case 'admin-help-content.php': ub_update_option('admin_help_content', get_option('admin_help_content'));
                                    break;

                                case 'global-footer-content.php': ub_update_option('global_footer_content', get_option('global_footer_content'));
                                    break;

                                case 'global-header-content.php': ub_update_option('global_header_content', get_option('global_header_content'));
                                    break;

                                case 'admin-menu.php': ub_update_option('admin_menu', get_option('admin_menu'));
                                    break;

                                case 'admin-footer-text.php': ub_update_option('admin_footer_text', get_option('admin_footer_text'));
                                    break;

                                case 'custom-dashboard-welcome.php':
                                    break;

                                case 'remove-wp-dashboard-widgets.php': ub_update_option('rwp_active_dashboard_widgets', get_option('rwp_active_dashboard_widgets'));
                                    break;

                                case 'rebranded-meta-widget.php':
                                    break;

                                case 'remove-permalinks-menu-item.php': break;

                                case 'site-generator-replacement.php': ub_update_option("site_generator_replacement", get_option('site_generator_replacement'));
                                    ub_update_option("site_generator_replacement_link", get_option('site_generator_replacement_link'));
                                    break;

                                case 'site-wide-text-change.php': ub_update_option('translation_ops', get_option('translation_ops'));
                                    ub_update_option('translation_table', get_option('translation_table'));
                                    break;

                                case 'custom-login-css.php': ub_update_option('global_login_css', get_option('global_login_css'));
                                    break;

                                case 'custom-admin-css.php': ub_update_option('global_admin_css', get_option('global_admin_css'));
                                    break;
                            }
                        }
                    }
                }
            }
        }

        function initialise_ub() {

            global $blog_id;

            // For this version only really - to bring settings across from the old storage locations
            $this->transfer_old_settings();

            if (!is_multisite()) {
                if (UB_HIDE_ADMIN_MENU != true) {
                    add_action('admin_menu', array(&$this, 'network_admin_page'));
                }
            } else {

                if (is_plugin_active_for_network('ultimate-branding/ultimate-branding.php')) {
                    add_action('network_admin_menu', array(&$this, 'network_admin_page'));
                } else {
                    // Added to allow single site activation across a network
                    if (UB_HIDE_ADMIN_MENU != true && !defined('UB_HIDE_ADMIN_MENU_' . $blog_id)) {
                        add_action('admin_menu', array(&$this, 'network_admin_page'));
                    }
                }
            }

            // Header actions
            add_action('load-toplevel_page_branding', array(&$this, 'add_admin_header_branding'));
        }

        function setup_translation() {
            // Load up the localization file if we're using WordPress in a different language
            // Place it in this plugin's "languages" folder and name it "mp-[value in wp-config].mo"

            load_plugin_textdomain('ub', false, '/ultimate-branding/ultimate-branding-files/languages/');
        }

        function add_admin_header_core() {

            // Add in help pages
            $screen = get_current_screen();

            $this->help = new UB_Help($screen);
            $this->help->attach();

            // Add in the core CSS file
            wp_enqueue_style('defaultadmincss', ub_files_url('css/defaultadmin.css'), array(), $this->build);
            wp_enqueue_script('ub_admin', ub_files_url('js/admin.js'), array(), $this->build);
            wp_localize_script('ub_admin', 'ub_admin', array(
                'current_menu_sub_item' => (isset($_GET['tab']) ? $_GET['tab'] : '')
            ));
        }

        function add_admin_header_branding() {

            $this->add_admin_header_core();

            do_action('ultimatebranding_admin_header_global');

            $tab = (isset($_GET['tab'])) ? $_GET['tab'] : '';
            if (empty($tab)) {
                $tab = 'dashboard';
            }

            do_action('ultimatebranding_admin_header_' . $tab);

            $this->update_branding_page();
        }

        /**
         * 	Check plugins those will be used if they are active or not
         */
        function load_modules() {

            // Load our remaining modules here
            foreach ($this->modules as $module => $plugin) {
                if (ub_is_active_module($module)) {
                    ub_load_single_module($module);
                }
            }
        }

        function check_active_plugins() {
            // We may be calling this function before admin files loaded, therefore let's be sure required file is loaded
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

            $plugins = get_plugins(); // All installed plugins

            foreach ($plugins as $plugin_file => $plugin_data) {
                if (is_plugin_active($plugin_file) && in_array($plugin_file, $this->modules)) {
                    // Add the title to the message
                    $this->plugin_msg[$plugin_file] = $plugin_data['Title'];
                }
            }
        }

        /**
         * 	Warn admin if this is not multisite
         */
        function not_multisite_msg() {
            echo '<div class="error"><p>' .
            __('<b>[Ultimate Branding]</b> Plugin only works in Multisite.', 'ub') .
            '</p></div>';
        }

        /**
         * 	Warn admin to deactivate the duplicate plugins
         */
        function deactivate_plugin_msg() {
            echo '<div class="error"><p>' .
            sprintf(__('<b>[Ultimate Branding]</b> Please deactivate the following plugin(s) to make Ultimate Branding to work: %s', 'ub'), implode(', ', $this->plugin_msg)) .
            '</p></div>';
        }

        /**
         * Add pages
         */
        function network_admin_page() {

            if (function_exists('is_plugin_active_for_network') && is_plugin_active_for_network('ultimate-branding/ultimate-branding.php')) {
                $capability = 'manage_network_options';
            } else {
                $capability = 'manage_options';
            }

            // Add in our menu page
            add_menu_page(__('Branding', 'ub'), __('Branding', 'ub'), $capability, 'branding', array(&$this, 'handle_main_page'));

            // Get the activated modules
            $modules = get_ub_activated_modules();

            // Add in the extensions
            foreach ($modules as $key => $title) {
                switch ($key) {
                    case 'favicons.php':
                    case 'login-image.php': if (!ub_has_menu('branding&amp;tab=images'))
                            add_submenu_page('branding', __('Images', 'ub'), __('Images', 'ub'), $capability, "branding&amp;tab=images", array(&$this, 'handle_images_panel'));
                        break;

                    case 'custom-admin-bar.php': if (!ub_has_menu('branding&amp;tab=adminbar'))
                            add_submenu_page('branding', __('Admin Bar', 'ub'), __('Admin Bar', 'ub'), $capability, "branding&amp;tab=adminbar", array(&$this, 'handle_adminbar_panel'));
                        break;

                    case 'admin-help-content.php': if (!ub_has_menu('branding&amp;tab=help'))
                            add_submenu_page('branding', __('Help Content', 'ub'), __('Help Content', 'ub'), $capability, "branding&amp;tab=help", array(&$this, 'handle_help_panel'));
                        break;

                    case 'global-footer-content.php':
                    case 'admin-footer-text.php': if (!ub_has_menu('branding&amp;tab=footer'))
                            add_submenu_page('branding', __('Footer Content', 'ub'), __('Footer Content', 'ub'), $capability, "branding&amp;tab=footer", array(&$this, 'handle_footer_panel'));
                        break;
                    case 'global-header-content.php': if (!ub_has_menu('branding&amp;tab=header'))
                            add_submenu_page('branding', __('Header Content', 'ub'), __('Header Content', 'ub'), $capability, "branding&amp;tab=header", array(&$this, 'handle_header_panel'));
                        break;
                    case 'admin-menu.php': if (!ub_has_menu('branding&amp;tab=admin_menu'))
                        //add_submenu_page('branding', __('Admin Menu', 'ub'), __('Admin Menu', 'ub'), $capability, "branding&amp;tab=admin_menu", array(&$this, 'handle_admin_menu_panel'));
                            break;
                    case 'custom-dashboard-welcome.php':
                    case 'remove-wp-dashboard-widgets.php':
                    case 'rebranded-meta-widget.php': if (!ub_has_menu('branding&amp;tab=widgets'))
                            add_submenu_page('branding', __('Widgets', 'ub'), __('Widgets', 'ub'), $capability, "branding&amp;tab=widgets", array(&$this, 'handle_widgets_panel'));
                        break;

                    case 'remove-permalinks-menu-item.php': if (!ub_has_menu('branding&amp;tab=permalinks'))
                            add_submenu_page('branding', __('Permalinks Menu', 'ub'), __('Permalinks Menu', 'ub'), $capability, "branding&amp;tab=permalinks", array(&$this, 'handle_permalinks_panel'));
                        break;

                    case 'site-generator-replacement.php': if (!ub_has_menu('branding&amp;tab=sitegenerator'))
                            add_submenu_page('branding', __('Site Generator', 'ub'), __('Site Generator', 'ub'), $capability, "branding&amp;tab=sitegenerator", array(&$this, 'handle_sitegenerator_panel'));
                        break;

                    case 'site-wide-text-change.php': if (!ub_has_menu('branding&amp;tab=textchange'))
                            add_submenu_page('branding', __('Text Change', 'ub'), __('Text Change', 'ub'), $capability, "branding&amp;tab=textchange", array(&$this, 'handle_textchange_panel'));
                        break;

                    case 'custom-login-css.php':
                    case 'custom-admin-css.php': if (!ub_has_menu('branding&amp;tab=css'))
                            add_submenu_page('branding', __('CSS', 'ub'), __('CSS', 'ub'), $capability, "branding&amp;tab=css", array(&$this, 'handle_css_panel'));
                        break;

                    case 'custom-email-from.php': if (!ub_has_menu('branding&amp;tab=from_email'))
                            add_submenu_page('branding', __('E-mail From', 'ub'), __('E-mail From', 'ub'), $capability, "branding&amp;tab=from_email", array(&$this, 'handle_email_from_panel'));
                        break;


                    case 'ultimate-color-schemes.php': if (!ub_has_menu('branding&amp;tab=ultimate-color-schemes'))
                            add_submenu_page('branding', __('Color Schemes', 'ub'), __('Color Schemes', 'ub'), $capability, "branding&amp;tab=ultimate-color-schemes", array(&$this, 'handle_ultimate_color_schemes_panel'));
                        break;
                }
            }

            do_action('ultimate_branding_add_menu_pages');
        }

        function activate_module($module) {

            $modules = get_ub_activated_modules();

            if (!isset($modules[$module])) {
                $modules[$module] = 'yes';
                update_ub_activated_modules($modules);
            } else {
                return false;
            }
        }

        function deactivate_module($module) {

            $modules = get_ub_activated_modules();

            if (isset($modules[$module])) {
                unset($modules[$module]);
                update_ub_activated_modules($modules);
            } else {
                return false;
            }
        }

        function update_branding_page() {

            global $action, $page;

            wp_reset_vars(array('action', 'page'));

            if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
                $tab = (isset($_GET['tab'])) ? $_GET['tab'] : '';
                if (empty($tab)) {
                    $tab = 'dashboard';
                }

                switch ($tab) {

                    case 'dashboard': if (isset($_GET['action']) && isset($_GET['module'])) {
                            switch ($_GET['action']) {
                                case 'enable': check_admin_referer('enable-module-' . $_GET['module']);
                                    if ($this->activate_module($_GET['module'])) {
                                        wp_safe_redirect(remove_query_arg(array('module', '_wpnonce', 'action'), wp_get_referer()));
                                    } else {
                                        wp_safe_redirect(remove_query_arg(array('module', '_wpnonce', 'action'), wp_get_referer()));
                                    }
                                    break;
                                case 'disable': check_admin_referer('disable-module-' . $_GET['module']);
                                    if ($this->deactivate_module($_GET['module'])) {
                                        wp_safe_redirect(remove_query_arg(array('module', '_wpnonce', 'action'), wp_get_referer()));
                                    } else {
                                        wp_safe_redirect(remove_query_arg(array('module', '_wpnonce', 'action'), wp_get_referer()));
                                    }
                                    break;
                            }
                        } elseif (isset($_GET['action']) && $_GET['action'] == 'enableallmodules') {
                            check_admin_referer('enable-all-modules');
                            foreach ($this->modules as $module => $value) {

                                $this->activate_module($module);
                            }
                            wp_safe_redirect(remove_query_arg(array('module', '_wpnonce', 'action'), wp_get_referer()));
                        } elseif (isset($_GET['action']) && $_GET['action'] == 'disableallmodules') {
                            check_admin_referer('disable-all-modules');
                            foreach ($this->modules as $module => $value) {

                                $this->deactivate_module($module);
                            }
                            wp_safe_redirect(remove_query_arg(array('module', '_wpnonce', 'action'), wp_get_referer()));
                        }
                        break;

                    case 'images': check_admin_referer('ultimatebranding_settings_menu_images');
                        if (apply_filters('ultimatebranding_settings_menu_images_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'adminbar': check_admin_referer('ultimatebranding_settings_menu_adminbar');
                        if (apply_filters('ultimatebranding_settings_menu_adminbar_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'help': check_admin_referer('ultimatebranding_settings_menu_help');
                        if (apply_filters('ultimatebranding_settings_menu_help_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'footer': check_admin_referer('ultimatebranding_settings_menu_footer');
                        if (apply_filters('ultimatebranding_settings_menu_footer_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'header': check_admin_referer('ultimatebranding_settings_menu_header');
                        if (apply_filters('ultimatebranding_settings_menu_header_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'widgets': check_admin_referer('ultimatebranding_settings_menu_widgets');
                        if (apply_filters('ultimatebranding_settings_menu_widgets_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'permalinks': check_admin_referer('ultimatebranding_settings_menu_permalinks');
                        if (apply_filters('ultimatebranding_settings_menu_permalinks_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'sitegenerator': check_admin_referer('ultimatebranding_settings_menu_sitegenerator');
                        if (apply_filters('ultimatebranding_settings_menu_sitegenerator_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'textchange': check_admin_referer('ultimatebranding_settings_menu_textchange');
                        if (apply_filters('ultimatebranding_settings_menu_textchange_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'css': check_admin_referer('ultimatebranding_settings_menu_css');
                        if (apply_filters('ultimatebranding_settings_menu_css_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'from_email': check_admin_referer('ultimatebranding_settings_menu_from_email');
                        if (apply_filters('ultimatebranding_settings_menu_from_email_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;

                    case 'admin_menu': check_admin_referer('ultimatebranding_settings_admin_menu');
                        if (apply_filters('ultimatebranding_settings_admin_menu_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;


                    case 'ultimate-color-schemes': check_admin_referer('ultimatebranding_settings_ultimate_color_schemes');
                        if (apply_filters('ultimatebranding_settings_menu_ultimate_color_schemes_process', true)) {
                            wp_safe_redirect(add_query_arg('msg', 1, wp_get_referer()));
                        } else {
                            wp_safe_redirect(add_query_arg('msg', 2, wp_get_referer()));
                        }
                        break;


                    default: do_action('ultimatebranding_settings_update_' . $tab);
                        break;
                }
            }
        }

        function handle_main_page() {

            global $action, $page;

            wp_reset_vars(array('action', 'page'));

            $tab = (isset($_GET['tab'])) ? $_GET['tab'] : '';
            if (empty($tab)) {
                $tab = 'dashboard';
            }

            // Get the activated modules
            $modules = get_ub_activated_modules();
            ?>
            <div class='wrap nosubsub'>
                <?php
                $menus = array();
                $menus['dashboard'] = __('Dashboard', 'ub');

                foreach ($modules as $key => $title) {

                    switch ($key) {
                        case 'favicons.php':
                        case 'login-image.php': $menus['images'] = __('Images', 'ub');
                            break;
                        case 'custom-admin-bar.php': $menus['adminbar'] = __('Admin Bar', 'ub');
                            break;
                        case 'admin-help-content.php': $menus['help'] = __('Help Content', 'ub');
                            break;
                        case 'global-footer-content.php':
                        case 'admin-footer-text.php': $menus['footer'] = __('Footer Content', 'ub');
                            break;
                        case 'global-header-content.php': $menus['header'] = __('Header Content', 'ub');
                            break;
                            //case 'admin-menu.php': $menus['admin_menu'] = __('Admin Menu', 'ub');
                            break;
                        case 'custom-dashboard-welcome.php':
                        case 'remove-wp-dashboard-widgets.php':
                        case 'rebranded-meta-widget.php': $menus['widgets'] = __('Widgets', 'ub');
                            break;
                        case 'remove-permalinks-menu-item.php': $menus['permalinks'] = __('Permalinks Menu', 'ub');
                            break;
                        case 'site-generator-replacement.php': $menus['sitegenerator'] = __('Site Generator', 'ub');
                            break;
                        case 'site-wide-text-change.php': $menus['textchange'] = __('Text Change', 'ub');
                            break;
                        case 'custom-login-css.php':
                        case 'custom-admin-css.php': $menus['css'] = __('CSS', 'ub');
                        case 'custom-email-from.php': $menus['from_email'] = __('E-mail From', 'ub');
                            break;
                        case 'ultimate-color-schemes.php': $menus['ultimate-color-schemes'] = __('Ultimate Color Schemes', 'ub');
                            break;
                    }
                }

                $menus = apply_filters('ultimatebranding_settings_menus', $menus);
                ?>

                <h3 class="nav-tab-wrapper">
                    <?php
                    foreach ($menus as $key => $menu) {
                        ?>
                        <a class="nav-tab<?php if ($tab == $key) echo ' nav-tab-active'; ?>" href="admin.php?page=<?php echo $page; ?>&amp;tab=<?php echo $key; ?>"><?php echo $menu; ?></a>
                        <?php
                    }
                    ?>
                </h3>

                <?php
                switch ($tab) {

                    case 'dashboard': $this->show_dashboard_page();
                        break;

                    case 'images': $this->handle_images_panel();
                        break;

                    case 'adminbar': $this->handle_adminbar_panel();
                        break;

                    case 'help': $this->handle_help_panel();
                        break;

                    case 'footer': $this->handle_footer_panel();
                        break;

                    case 'header': $this->handle_header_panel();
                        break;

                    case 'widgets': $this->handle_widgets_panel();
                        break;

                    case 'permalinks': $this->handle_permalinks_panel();
                        break;

                    case 'sitegenerator': $this->handle_sitegenerator_panel();
                        break;

                    case 'textchange': $this->handle_textchange_panel();
                        break;

                    case 'css': $this->handle_css_panel();
                        break;

                    case 'from_email': $this->handle_email_from_panel();
                        break;

                    case 'admin_menu': $this->handle_admin_menu_panel();
                        break;

                    case 'ultimate-color-schemes': $this->handle_ultimate_color_schemes_panel();
                        break;

                    default: do_action('ultimatebranding_settings_menu_' . $tab);
                        break;
                }
                ?>

            </div> <!-- wrap -->
            <?php
        }

        function show_dashboard_page() {

            global $action, $page;
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Branding', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>

            <div id="dashboard-widgets-wrap">

                <div class="metabox-holder" id="dashboard-widgets">
                    <div style="width: 49%;" class="postbox-container">
                        <div class="meta-box-sortables ui-sortable" id="normal-sortables">

                            <?php
                            // See what plugins are active
                            $this->check_active_plugins();

                            if (!empty($this->plugin_msg)) {
                                ?>
                                <div class="postbox " id="">
                                    <h3 class="hndle"><span><?php _e('Notifications', 'ub'); ?></span></h3>
                                    <div class="inside">
                                        <?php
                                        _e('Please deactivate the following plugin(s) to make Ultimate Branding to work:', 'ub');
                                        echo "<ul><li><strong>" . implode('</li><li>', $this->plugin_msg);
                                        echo "</strong></li></ul>";
                                        ?>
                                        <br class="clear">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="postbox " id="">
                                <h3 class="hndle"><span><?php _e('Branding', 'ub'); ?></span></h3>
                                <div class="inside">
                                    <?php
                                    include_once( ub_files_dir('help/dashboard.help.php') );
                                    ?>
                                    <br class="clear">
                                </div>
                            </div>

                            <?php
                            do_action('ultimatebranding_dashboard_page_left');
                            ?>
                        </div>
                    </div>

                    <div style="width: 49%;" class="postbox-container">
                        <div class="meta-box-sortables ui-sortable" id="side-sortables">

                            <?php
                            do_action('ultimatebranding_dashboard_page_right_top');
                            ?>

                            <div class="postbox " id="dashboard_quick_press">
                                <h3 class="hndle"><span><?php _e('Module Status', 'ub'); ?></span></h3>
                                <div class="inside">
                                    <?php $this->show_module_status(); ?>
                                    <br class="clear">
                                </div>
                            </div>

                            <?php
                            do_action('ultimatebranding_dashboard_page_right');
                            ?>

                        </div>
                    </div>

                    <div style="display: none; width: 49%;" class="postbox-container">
                        <div class="meta-box-sortables ui-sortable" id="column3-sortables" style="">
                        </div>
                    </div>

                    <div style="display: none; width: 49%;" class="postbox-container">
                        <div class="meta-box-sortables ui-sortable" id="column4-sortables" style="">
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>

            <?php
        }

        function show_module_status() {

            global $action, $page;
            ?>
            <table class='widefat'>
                <thead>
                <th><?php _e('Available Modules', 'ub'); ?></th>
                <th><a href='<?php echo wp_nonce_url("?page=" . $page . "&amp;action=enableallmodules", 'enable-all-modules'); ?>'><?php _e('Enable', 'ub'); ?></a> / <a href='<?php echo wp_nonce_url("?page=" . $page . "&amp;action=disableallmodules", 'disable-all-modules'); ?>'><?php _e('Disable All', 'ub'); ?></a></th>
            </thead>
            <tfoot>
            <th><?php _e('Available Modules', 'ub'); ?></th>
            <th><a href='<?php echo wp_nonce_url("?page=" . $page . "&amp;action=enableallmodules", 'enable-all-modules'); ?>'><?php _e('Enable', 'ub'); ?></a> / <a href='<?php echo wp_nonce_url("?page=" . $page . "&amp;action=disableallmodules", 'disable-all-modules'); ?>'><?php _e('Disable All', 'ub'); ?></a></th>
            </tfoot>
            <tbody>
                <?php
                if (!empty($this->modules)) {

                    $default_headers = array(
                        'Name' => 'Plugin Name',
                        'Author' => 'Author',
                        'Description' => 'Description',
                        'AuthorURI' => 'Author URI'
                    );

                    foreach ($this->modules as $module => $plugin) {

                        $module_data = get_file_data(ub_files_dir('modules/' . $module), $default_headers, 'plugin');

                        // deactivate any conflisting plugins
                        if (in_array($module, array_keys($this->plugin_msg))) {
                            $this->deactivate_module($module);
                        }

                        if (ub_is_active_module($module)) {
                            ?>
                            <tr class='activemodule'>
                                <td>
                                    <?php
                                    echo $module_data['Name'];
                                    ?>
                                </td>
                                <td>
                                    <a href='<?php echo wp_nonce_url("?page=" . $page . "&amp;action=disable&amp;module=" . $module . "", 'disable-module-' . $module) ?>' class='disblelink'><?php _e('Disable', 'ub'); ?></a>
                                </td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr class='inactivemodule'>
                                <td>
                                    <?php
                                    echo $module_data['Name'];
                                    ?>
                                </td>
                                <td>
                                    <?php if (!in_array($module, array_keys($this->plugin_msg))) { ?>
                                        <a href='<?php echo wp_nonce_url("?page=" . $page . "&amp;action=enable&amp;module=" . $module . "", 'enable-module-' . $module) ?>' class='enablelink'><?php _e('Enable', 'ub'); ?></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan='2'><?php _e('No modules avaiable.', 'ub'); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            </table>

            <?php
        }

        function handle_images_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('There was an error uploading the file, please try again.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_images_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Custom Images', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_images');

                    do_action('ultimatebranding_settings_menu_images');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_images_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_adminbar_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('There was an error uploading the file, please try again.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_adminbar_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Custom Admin Bar', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_adminbar');

                    do_action('ultimatebranding_settings_menu_adminbar');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_adminbar_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_help_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('Changes could not be saved.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_help_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Custom Help Content', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_help');

                    do_action('ultimatebranding_settings_menu_help');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_help_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_footer_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('Changes could not be saved.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_footer_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Custom Footer Content', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_footer');

                    do_action('ultimatebranding_settings_menu_footer');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_footer_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_header_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('Changes could not be saved.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_header_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Custom Header Content', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_header');

                    do_action('ultimatebranding_settings_menu_header');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_header_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_admin_menu_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('Changes could not be saved.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_admin_menu_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Admin Menu Manager', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_admin_menu');

                    do_action('ultimatebranding_settings_admin_menu');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_admin_menu_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_widgets_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('There was an error uploading the file, please try again.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_widgets_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Custom Widgets', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_widgets');

                    do_action('ultimatebranding_settings_menu_widgets');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_widgets_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_permalinks_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('There was an error uploading the file, please try again.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_permalinks_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Remove Permalinks Menu', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_permalinks');

                    do_action('ultimatebranding_settings_menu_permalinks');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_permalinks_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_sitegenerator_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('Changes could not be saved.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_sitegenerator_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Custom Site Generator Content', 'ub'); ?></h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_sitegenerator');

                    do_action('ultimatebranding_settings_menu_sitegenerator');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_sitegenerator_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_textchange_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('There was an error, please try again.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_textchange_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Network Wide Text Change', 'ub'); ?>
                <a class="add-new-h2" href="#addnew" id='addnewtextchange'><?php _e('Add New', 'ub'); ?></a>
            </h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_textchange');

                    do_action('ultimatebranding_settings_menu_textchange');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_textchange_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
                <div style='clear:both;'></div>
            </div>
            <?php
        }

        function handle_css_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('There was an error, please try again.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_css_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Custom CSS', 'ub'); ?>
            </h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_css');

                    do_action('ultimatebranding_settings_menu_css');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_css_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_email_from_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('There was an error, please try again.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_email_from_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('E-mail From Headers', 'ub'); ?>
            </h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_from_email');

                    do_action('ultimatebranding_settings_menu_from_email');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_from_email_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

        function handle_ultimate_color_schemes_panel() {

            global $action, $page;

            $messages = array();
            $messages[1] = __('Changes saved.', 'ub');
            $messages[2] = __('There was an error, please try again.', 'ub');

            $messages = apply_filters('ultimatebranding_settings_menu_css_messages', $messages);
            ?>
            <div class="icon32" id="icon-index"><br></div>
            <h2><?php _e('Ultimate Color Schemes', 'ub'); ?>
            </h2>

            <?php
            if (isset($_GET['msg'])) {
                echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
                $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
            }
            ?>
            <div id="poststuff" class="metabox-holder m-settings">
                <form action='' method="post" enctype="multipart/form-data">

                    <input type='hidden' name='page' value='<?php echo $page; ?>' />
                    <input type='hidden' name='action' value='process' />
                    <?php
                    wp_nonce_field('ultimatebranding_settings_menu_ultimate_color_schemes');

                    do_action('ultimatebranding_settings_menu_ultimate_color_schemes');
                    ?>

                    <?php
                    if (has_filter('ultimatebranding_settings_menu_ultimate_color_schemes_process')) {
                        ?>
                        <p class="submit">
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'ub'); ?>" />
                        </p>
                        <?php
                    }
                    ?>

                </form>
            </div>
            <?php
        }

    }

}
?>