<?php
/*
Plugin Name: Optimize editor
Author: webfood
Plugin URI: http://webfood.info/
Description: Optimize editor
Version: 0.1
Author URI: http://webfood.info/
Text Domain: Optimize editor
Domain Path: /languages

License:
 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html

  Copyright 2021 (email : webfood.info@gmail.com)

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
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
return $html;
}

// メディア追加時のwidth/height自動追加を削除
function my_remove_width_attribute( $options ) {
    if ( $options['tinymce'] ) {
        wp_enqueue_script( 'remove_width_attribute', get_stylesheet_directory_uri() . '/js/remove_width_attribute.js', array( 'jquery' ), '1.0.0', true);
    }
}
add_action( 'wp_enqueue_editor', 'my_remove_width_attribute', 10, 1 );

function disable_correct_url() {
	echo <<< EOM
<script>
	window.wpLink.correctURL= function () {};
</script>
EOM;
}
add_action('admin_print_footer_scripts', 'disable_correct_url');
