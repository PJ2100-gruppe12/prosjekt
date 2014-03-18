<?php

/*
  Plugin Name: Custom Admin Bar
  Plugin URI: http://premium.wpmudev.org/project/custom-admin-bar
  Description: Adds a custom drop-down entry to your admin bar.
  Version: 1.4
  Author: Barry (Incsub), Ve Bailovity (Incsub), Marko Miljus (Incsub)
  Author URI: http://premium.wpmudev.org
  WDP ID: 238

  Copyright 2009-2013 Incsub (http://incsub.com)

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

function ub_wdcab_add_to_admin_bar() {

    global $wp_admin_bar;

    $opts = ub_get_option('wdcab');

    if (!@$opts['enabled'])
        return false;
    if (!@$opts['title'])
        return false;

    $title = preg_match('/^https?:/', trim($opts['title'])) ? '<img src="' . trim($opts['title']) . '" />' : trim($opts['title']);

    $link = @$opts['title_link'];
    $allowed = array(
        'network_site_url', 'site_url', 'admin_url'
    );

    if (in_array($link, $allowed))
        $link = $link();
    else
        $link = esc_url($link);

    if (isset($opts['title_link_target']) && !empty($opts['title_link_target'])) {

        $wp_admin_bar->add_menu(array(
            'id' => 'wdcab_root',
            'title' => stripslashes($title),
            'href' => $link,
            'meta' => array('target' => $opts['title_link_target']),
        ));
    } else {
        $wp_admin_bar->add_menu(array(
            'id' => 'wdcab_root',
            'title' => stripslashes($title),
            'href' => $link,
        ));
    }

    foreach ($opts['links'] as $link) {

        $href = false;
        switch ($link['url_type']) {
            case "admin": $href = admin_url($link['url']);
                break;

            case "site": $href = site_url($link['url']);
                break;

            case "external": $href = $link['url'];
                break;
        }
        if (!$href)
            continue;

        if (isset($link['target']) && !empty($link['target'])) {
            $wp_admin_bar->add_menu(array(
                'parent' => 'wdcab_root',
                'id' => AsciiToInt('wdcab_' . strtolower($link['title'])),
                'title' => stripslashes($link['title']),
                'href' => $href,
                'meta' => array('target' => $link['target']),
            ));
        } else {
            $wp_admin_bar->add_menu(array(
                'parent' => 'wdcab_root',
                'id' => AsciiToInt('wdcab_' . strtolower($link['title'])),
                'title' => stripslashes($link['title']),
                'href' => $href,
            ));
        }
    }
}

function AsciiToInt($char) {
    $success = "";
    if (strlen($char) == 1)
        return "char(" . ord($char) . ")";
    else {
        for ($i = 0; $i < strlen($char); $i++) {
            if ($i == strlen($char) - 1)
                $success = $success + ord($char[$i]);
            else
                $success = $success + ord($char[$i]) . ",";
        }
        return "char(" . $success . ")";
    }
}

function ub_wdcab_remove_from_admin_bar() {
    global $wp_version;
    $version = preg_replace('/-.*$/', '', $wp_version);
    if (version_compare($version, '3.3', '>=')) {
        global $wp_admin_bar;
        $opts = ub_get_option('wdcab');
        $disabled = is_array(@$opts['disabled_menus']) ? $opts['disabled_menus'] : array();
        foreach ($disabled as $id) {
            $wp_admin_bar->remove_node($id);
        }
    }
}

require_once( ub_files_dir('modules/custom-admin-bar-files/lib/class_wdcab_admin_form_renderer.php') );
require_once( ub_files_dir('modules/custom-admin-bar-files/lib/class_wdcab_admin_pages.php') );

$ub_wdcab_adminpages = new ub_Wdcab_AdminPages();

add_action('admin_bar_menu', 'ub_wdcab_add_to_admin_bar', 1);
add_action('admin_bar_menu', 'ub_wdcab_remove_from_admin_bar', 999);