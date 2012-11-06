<?php
/*
Plugin Name: Recent Posts Feed Icon Widget
Description:
Author: Barry (Incsub)
Version: 3.0
Author URI:
*/

/*
Copyright 2012 Incsub (http://incsub.com)

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

if(!defined('RECENT_GLOBAL_POSTS_FEED_WIDGET_MAIN_BLOG_ONLY') ) define('RECENT_GLOBAL_POSTS_FEED_WIDGET_MAIN_BLOG_ONLY', true);

class widget_recent_global_posts_feed extends WP_Widget {

	function widget_recent_global_posts_feed() {

		$locale = apply_filters( 'rpgpfwidgets_locale', get_locale() );
		$mofile = dirname(__FILE__) . "/languages/rpgpfwidgets-$locale.mo";

		if ( file_exists( $mofile ) )
			load_textdomain( 'rpgpfwidgets', $mofile );

		$widget_ops = array( 'classname' => 'rgpwidget', 'description' => __('Recent Global Posts Feed', 'rpgpfwidgets') );
		$control_ops = array('width' => 400, 'height' => 350, 'id_base' => 'rpgpfwidget');
		$this->WP_Widget( 'rpgpfwidget', __('Recent Global Posts Feed', 'rpgpfwidgets'), $widget_ops, $control_ops );

	}

	function widget( $args, $instance ) {

		global $wpdb, $current_site;

		extract($args);

		$defaults = array(	'recentglobalpostsfeedtitle' => '',
							'recentglobalpostsfeedrssimage'	=>	'',
							'recentglobalpostsfeedpoststype'	=>	'post'
						);

		foreach($defaults as $key => $value) {
			if(isset($instance[$key])) {
				$defaults[$key] = $instance[$key];
			}
		}

		extract($defaults);

		$title = apply_filters('widget_title', $recentglobalpostsfeedtitle );

		?>
			<?php echo $before_widget; ?>
				<?php
				if ( $recentglobalpostsfeedrssimage == 'hide' ) {
		            echo $before_title . '<a href="http://' . $current_site->domain . $current_site->path . 'feed/globalpostsfeed?posttype=' . $recentglobalpostsfeedpoststype . '" >' . __($recentglobalpostsfeedtitle) . '</a>' . $after_title;
				} else {
		            echo $before_title . '<a href="http://' . $current_site->domain . $current_site->path . 'feed/globalpostsfeed?posttype=' . $recentglobalpostsfeedpoststype . '" ><img src="http://' . $current_site->domain . $current_site->path . 'wp-includes/images/rss.png" /> ' . __($recentglobalpostsfeedtitle) . '</a>' . $after_title;
				}
				?>
			<?php echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {

		$defaults = array(	'recentglobalpostsfeedtitle' => '',
							'recentglobalpostsfeedrssimage'	=>	'',
							'recentglobalpostsfeedpoststype'	=>	'post'
						);

		foreach ( $defaults as $key => $val ) {
			$instance[$key] = $new_instance[$key];
		}

		return $instance;

	}

	function form( $instance ) {

		$defaults = array(	'recentglobalpostsfeedtitle' => '',
							'recentglobalpostsfeedrssimage'	=>	'',
							'recentglobalpostsfeedpoststype'	=>	'post'
						);

		$instance = wp_parse_args( (array) $instance, $defaults );

		extract($instance);

		?>
			<div style="text-align:left">

			<label for="<?php echo $this->get_field_name( 'recentglobalpostsfeedtitle' ); ?>" style="line-height:35px;display:block;"><?php _e('Title', 'rpgpfwidgets'); ?>:<br />
            <input class="widefat" id="<?php echo $this->get_field_id( 'recentglobalpostsfeedtitle' ); ?>" name="<?php echo $this->get_field_name( 'recentglobalpostsfeedtitle' ); ?>" value="<?php echo esc_attr(stripslashes($instance['recentglobalpostsfeedtitle'])); ?>" type="text" style="width:95%;" />
            </label>

			<label for="<?php echo $this->get_field_name( 'recentglobalpostsfeedrssimage' ); ?>" style="line-height:35px;display:block;"><?php _e('RSS Image', 'rpgpfwidgets'); ?>:<br />
            <select name="<?php echo $this->get_field_name( 'recentglobalpostsfeedrssimage' ); ?>" id="<?php echo $this->get_field_id( 'recentglobalpostsfeedrssimage' ); ?>" style="width:95%;">
            <option value="show" <?php selected( $instance['recentglobalpostsfeedrssimage'], 'show'); ?> ><?php _e('Show', 'rpgpfwidgets'); ?></option>
            <option value="hide" <?php selected( $instance['recentglobalpostsfeedrssimage'], 'hide'); ?> ><?php _e('Hide', 'rpgpfwidgets'); ?></option>
            </select>

			<label for="<?php echo $this->get_field_name( 'recentglobalpostsfeedpoststype' ); ?>" style="line-height:35px;display:block;"><?php _e('Post type', 'rpgpfwidgets'); ?>:<br />
	        <input class="widefat" id="<?php echo $this->get_field_id( 'recentglobalpostsfeedpoststype' ); ?>" name="<?php echo $this->get_field_name( 'recentglobalpostsfeedpoststype' ); ?>" value="<?php echo esc_attr(stripslashes($instance['recentglobalpostsfeedpoststype'])); ?>" type="text" style="width:95%;" />
	        </label>

            </label>
			<input type="hidden" name="<?php echo $this->get_field_name( 'recentglobalpostsfeedsubmit' ); ?>" id="<?php echo $this->get_field_id( 'recentglobalpostsfeedsubmit' ); ?>" value="1" />
			</div>

		<?php
	}

}

function widget_recent_global_posts_feed_register() {
	global $wpdb;

	if ( RECENT_GLOBAL_POSTS_FEED_WIDGET_MAIN_BLOG_ONLY ) {
		if ( $wpdb->blogid == 1 ) {
			register_widget( 'widget_recent_global_posts_feed' );
		}
	} else {
		register_widget( 'widget_recent_global_posts_feed' );
	}
}

add_action( 'widgets_init', 'widget_recent_global_posts_feed_register' );

?>