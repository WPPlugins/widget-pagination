<?php
/**
 * Uninstalls the Widget Paginator options when an uninstall has been
 * requested from the WordPress admin plugin dashboard
 */

function deleteOptions()
{
	$args    = func_get_args();
        $success = true;

        foreach ($args as $option) {
                if ( ! delete_option($option))
                        $success = FALSE;
        }
        return $success;
}

if (deleteOptions(
        'wgpag-items_per_page_links',
        'wgpag-items_per_page_categories',
        'wgpag-items_per_page_archive',
        'wgpag-items_per_page_recent_entries',
        'wgpag-items_per_page_recent_comments',
        'wgpag-items_per_page_meta',
        'wgpag-pag_option_ptsh',
        'wgpag-pag_option_prev',
        'wgpag-pag_option_next',
        'wgpag-cur_item_style_color',
        'wgpag-cur_item_style_border-color',
        'wgpag-cur_item_style_background-color',
        'wgpag-cur_item_style_font-size',
        'wgpag-item_style_color',
        'wgpag-item_style_border-color',
        'wgpag-item_style_background-color',
        'wgpag-item_style_font-size',
        'wgpag-hover_item_style_color',
        'wgpag-hover_item_style_border-color',
        'wgpag-hover_item_style_background-color',
        'wgpag-hover_item_style_font-size'))
   echo 'Options have been deleted!';
else
   echo 'An error has occurred while trying to delete the options from database!';
?>