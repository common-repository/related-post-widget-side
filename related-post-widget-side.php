<?php
/*
Plugin Name: Related Post widget side
Plugin URI: http://vashikaran.biz
Version: 1.0
Description: Show Random related posts in sidebar
Author: vashikaran
Author URI: http://vashikaran.biz
License: GPLv2

*/

define("ecpt_rposts", "10");

class relatedpostsCPWidget extends WP_Widget {

	function relatedpostsCPWidget()
	{
		parent::WP_Widget( false, 'Related Posts',  array('description' => 'Related Posts') );
	}

	function widget($args, $instance)
	{
		global $NewrelatedpostsCP;
		$title = empty( $instance['title'] ) ? 'Recent Posts including Custom PostTypes' : $instance['title'];
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		echo $NewrelatedpostsCP->GetrelatedpostsCP(  empty( $instance['ShowPosts'] ) ? ecpt_rposts : $instance['ShowPosts'] );
		echo $args['after_widget'];
	}

	function update($new_instance)
	{
		return $new_instance;
	}

	function form($instance)
	{
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('ShowPosts'); ?>"><?php echo 'Number of entries:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('ShowPosts'); ?>" id="<?php echo $this->get_field_id('ShowPosts'); ?>" value="<?php if ( empty( $instance['ShowPosts'] ) ) { echo esc_attr(ecpt_rposts); } else { echo esc_attr($instance['ShowPosts']); } ?>" size="3" />
		</p>

		<?php
	}

}



class relatedpostsCP {

	function GetrelatedpostsCP($ecpt_posts)
	{
		$post_types=get_post_types();
		$args = array( 'numberposts' => $ecpt_posts , 'post_type' => $post_types, 'orderby' => 'rand');
		$recent_posts = wp_get_recent_posts( $args );
		echo '<ul>';
		foreach( $recent_posts as $recent ){
			echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="'.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
		}
			
		echo '</ul>';
	}

}



$NewrelatedpostsCP = new relatedpostsCP();

function relatedpostsCP_widgets_init()
{
	register_widget('relatedpostsCPWidget');
}

add_action('widgets_init', 'relatedpostsCP_widgets_init');


?>