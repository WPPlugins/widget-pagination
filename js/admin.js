/*
Plugin Name: Widget Paginator
Plugin URI: http://wgpag.jana-sieber.de/
Description: Pagination for Wordpress Widgets
Author: Jana Sieber and Lars Uebernickel
Author URI: http://wordpress.org/support/profile/janasieber
License: GPL2
*/

jQuery(document).ready(function($) {

	$('.color-picker').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val('#' + hex);
			$(el).ColorPickerHide();
		},
                onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	}).bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});

});