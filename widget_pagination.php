<?php
/*
Plugin Name: Widget Paginator
Plugin URI: http://wgpag.jana-sieber.de/
Description: This plugin lets you add a styleable pagination for the widgets Links, Categories, Archives, Recent Posts, Recent Comments, and Meta.
Version: 0.51
Author: Jana Sieber [jasie] and Lars Uebernickel [larsu]
Author URI: http://wordpress.org/support/profile/jasie
License: GPL2
Text Domain: widget_pagination
Domain Path: /lang
*/

/*  Copyright 2011  Jana Sieber <jana@jana-sieber.de>
                    Lars Uebernickel <lars@uebernic.de>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php
define("WGPAG_VERSION", "0.51");

if (!class_exists('WidgetPagination')) {

    class WidgetPagination {

        private $widgets = array(
            'links'           => 'Links',
            'categories'      => 'Categories',
            'archive'         => 'Archive',
            'recent_entries'  => 'Recent Posts',
            'recent_comments' => 'Recent Comments',
            'meta'            => 'Meta');

        private $styles = array(
            'color'            => 'Text Colour',
            'border-color'     => 'Border Colour',
            'background-color' => 'Background Colour',
            'font-size'        => 'Font Size');

        function __construct() {

            // In dashboard
            if ( is_admin() ) {
                add_action('admin_init', array($this, 'wgpag_admin_init')); //register_setting
                add_action('admin_init', array($this, 'wgpag_load_plugin_textdomain'));
                add_action('admin_menu', array($this, 'wgpag_admin_menu'));
                register_activation_hook(__FILE__, array(&$this, 'initialize_defaults'));

                // Widget Pagination update options
                if ( isset($_POST['wgpag']) && $_POST['wgpag']=='true' ) {

                    // print '<pre>' . print_r ($_POST, true) . '</pre>';

                    foreach ($_POST as $name => $value) {
                        if (preg_match('/^wgpag-items_per_page_(.*)/', $name, $matches) &&
                            isset($this->widgets[$matches[1]]))
                            update_option($name, $value);
                        else if (preg_match('/^wgpag-item_style_(.*)/', $name, $matches) &&
                            isset($this->styles[$matches[1]]))
                            update_option($name, $value);
                        else if (preg_match('/^wgpag-cur_item_style_(.*)/', $name, $matches) &&
                            isset($this->styles[$matches[1]]))
                            update_option($name, $value);
                        else if (preg_match('/^wgpag-hover_item_style_(.*)/', $name, $matches) &&
                            isset($this->styles[$matches[1]]))
                            update_option($name, $value);
                    }

                    if (!empty($_POST['wgpag-pag_option_ptsh']))
                        update_option('wgpag-pag_option_ptsh', $_POST['wgpag-pag_option_ptsh']);
                    if (!empty($_POST['wgpag-pag_option_prev']))
                        update_option('wgpag-pag_option_prev', $_POST['wgpag-pag_option_prev']);
                    if (!empty($_POST['wgpag-pag_option_next']))
                        update_option('wgpag-pag_option_next', $_POST['wgpag-pag_option_next']);
                }
            }

            // Not in dashboard
            if ( !is_admin() ) {
                add_action('init', array($this, 'wgpag_page_init') );
            }
        }

        /**
         * Initialize defaults
         * @author Jana Sieber
         */
        function initialize_defaults() {
            foreach ($this->widgets as $w => $name)
                add_option('wgpag-items_per_page_' . $w,'','','no');

            foreach ($this->styles as $s => $name)
                add_option('wgpag-item_style_' . $s,'','','no');

            foreach ($this->styles as $s => $name)
                add_option('wgpag-cur_item_style_' . $s,'','','no');

            foreach ($this->styles as $s => $name)
                add_option('wgpag-hover_item_style_' . $s,'','','no');

            add_option('wgpag-pag_option_ptsh','7','','no');
            add_option('wgpag-pag_option_prev','<','','no');
            add_option('wgpag-pag_option_next','>','','no');
        }

        /**
         * Initialize WgPag
         * @author Jana Sieber
         */
        function wgpag_page_init() {
            wp_register_script('wgpag', plugins_url('/js/wgpag.js',__FILE__),
                               array('jquery'), WGPAG_VERSION );
            wp_register_style('wgpag', plugins_url('/css/wgpag.css',__FILE__),
                              '', WGPAG_VERSION );

            wp_register_style('wgpag-options', plugins_url('/css/wgpag-options.css',__FILE__),
                              'wgpag' );

            add_filter('style_loader_tag', array($this, 'wgpag_replace_option_style'), 10, 2);
            wp_enqueue_style('wgpag');
            wp_enqueue_style('wgpag-options');
            wp_enqueue_script('wgpag');
            wp_enqueue_script('jquery');

            // send to js
            $widgets = array();
            foreach ($this->widgets as $w => $name) {
                $widgets[] = array(
                    'selector' => '.widget_' . $w,
                    'count' => (int)get_option('wgpag-items_per_page_' . $w)
                );
            }

            $options = array(
                'widgets'       => $widgets,
                'pages_to_show' => get_option('wgpag-pag_option_ptsh'),
                'prev_label'    => get_option('wgpag-pag_option_prev'),
                'next_label'    => get_option('wgpag-pag_option_next'));

            wp_localize_script('wgpag', 'wgpag_options',
                array('l10n_print_after' => 'wgpag_options = ' . json_encode($options) . ';'));

            // send to css TODO
        }

        /**
         * Initialize WgPag admin (register settings)
         * @author Jana Sieber
         */
        function wgpag_admin_init() {
            wp_register_style('colorpicker',
                    plugins_url('/css/jquery.colorpicker.css',__FILE__));
            wp_register_style('wgpag-style',
                    plugins_url('/css/admin.css',__FILE__),
                              '', WGPAG_VERSION );
            wp_deregister_script('colorpicker');
            wp_register_script('colorpicker',
                    plugins_url('/js/jquery.colorpicker.js',__FILE__),
                    array('jquery'));
            wp_register_script('wgpag-script',
                    plugins_url('/js/admin.js', __FILE__),
                    array('jquery','colorpicker'), WGPAG_VERSION );
            //register_setting( 'widget_pagination', 'new_option_name' );
        }

        /**
         * Initialize WgPag admin panel
         * @author Jana Sieber
         */
        function wgpag_admin_menu() {
            $page = add_submenu_page('themes.php',
                                     'Widget Paginator',
                                     'Widget Paginator',
                                     'manage_options',
                                     __FILE__,
                                     array($this, 'wgpag_options_page'));
            add_action('admin_print_styles-'.$page,  array($this, 'wgpag_admin_styles'));
            add_action('admin_print_scripts-'.$page, array($this, 'wgpag_admin_scripts'));
        }

        /**
         * Initialize internationalisation
         * @author Jana Sieber
         */
        function wgpag_load_plugin_textdomain() {
            load_plugin_textdomain( 'wgpag', false, 'languages' );
        }

        /**
         * Load WgPag admin styles
         * @author Jana Sieber
         */
        function wgpag_admin_styles() {
            wp_enqueue_style('wgpag-style');
            wp_enqueue_style('colorpicker');
        }

        /**
         * Load WgPag admin scripts
         * @author Jana Sieber
         */
        function wgpag_admin_scripts() {
            wp_enqueue_script('wgpag-script');
        }

        /**
         * Provide markup for WgPag settings page
         * @author Jana Sieber
         */
        function wgpag_options_page() {
            require_once ('inc/wgpag-options.php');
        }

        private function item_css () {
            $selectors = array(
                'item_style' => 'a',
                'hover_item_style' => 'a:hover',
                'cur_item_style' => '.br-current'
            );
            $str = '';
            foreach($selectors as $name => $selector) {
                $str .= ".br-pagination $selector { ";
                foreach ($this->styles as $s => $title) {
                    $optval = get_option("wgpag-${name}_$s");
                    if (!empty($optval))
                        $str .= "$s: $optval; ";
                }
                $str .= "}";
            }
            return $str;
        }

        /**
         * Replace wgpag-options css with an inline style which pulls
         * the style from the options database.
         * @author Lars Uebernickel
         */
        function wgpag_replace_option_style ($tag, $handle) {
            if ($handle == 'wgpag-options') {
                return '<style type="text/css">' . $this->item_css() . '</style>';
            }
            else
                return $tag;
        }
    }
}

// Init Widget Pagination
$wgpag = new WidgetPagination();
?>