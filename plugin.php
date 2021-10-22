<?php
/*
Plugin Name: Jin blog card by name
Author: webfood
Plugin URI: http://webfood.info/
Description: Jin blog card by name
Version: 0.1
Author URI: http://webfood.info/
Text Domain: Jin blog card by name
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

function to_blog_card($the_content) {
	if ( is_singular() || is_category() || is_front_page() ) {


  $res = preg_match_all("/\[card name=.*\]/" , $the_content, $m);
		foreach ($m[0] as $match) {
			$temp = '';
      $temp = preg_replace("/^\[card name=/", "" , $match);
			$temp = preg_replace("/\]$/", "" , $temp);
			$temp = str_replace('"', '', $temp);
			$url = '/'.$temp.'/';
			$id = url_to_postid( $url );
			if ( ! $id ) continue;//IDを取得できない場合はループを飛ばす
				$post = get_post($id);
				$title = $post->post_title;
				if( ! get_post_meta($post->ID, 'post_desc',true) == null ){
					$excerpt = get_post_meta($post->ID, 'post_desc',true);
				}else{
					$excerpt = cps_excerpt($post->post_content,68);
				}
				$logo = esc_url( get_site_icon_url( 32 ) ) ;
				$sitetitle = get_bloginfo('name');
				$thumbnail = get_the_post_thumbnail($id, 'cps_thumbnails', array('class' => 'blog-card-thumb-image'));
				if ( !$thumbnail ) {
					$thumbnail = '<img src="'.get_template_directory_uri().'/img/noimg320.png" />';
				}

			$tag = '<a href="'.$url.'" class="blog-card"><div class="blog-card-hl-box"><i class="jic jin-ifont-post"></i><span class="blog-card-hl"></span></div><div class="blog-card-box"><div class="blog-card-thumbnail">'.$thumbnail.'</div><div class="blog-card-content"><span class="blog-card-title">'.$title.'</span><span class="blog-card-excerpt">'.$excerpt.'...</span></div></div></a>';

      $the_content = str_replace('<p>'.$match.'</p>', $tag , $the_content);

		}
	}
	return $the_content;
}

add_filter('the_content','to_blog_card');

add_action('after_setup_theme',function(){
  remove_filter('the_content','url_to_blog_card');
});
