<?php
/*
Plugin Name: Post Image Grid Shortcode
Plugin URI: http://learnkraft.com
Description: This plugins allows you to add a post image grid anywhere within a post or a page. The grid is responsive created using a shortcode.
Version: 1.0
Author: Manish Sahajwani
Author URI: http://twitter.com/learnkraft
License: GPLv2+
*/
?>
<?php
class LKPostImageGrid {
    public function __construct()
    {
		add_shortcode('postimagegrid', array($this, 'lk_post_image_grid'));
		add_action( 'wp_enqueue_scripts', array( $this, 'LK_Image_Grid_Styles' ) );
    }
	public function LK_Image_Grid_Styles() {
        wp_enqueue_style( 'LK_Image_Grid_Plugin_Styles', plugin_dir_url( __FILE__ ) . '/css/lk-image-grid-style.css');
	}
    public function lk_post_image_grid($atts)
    {
		extract(shortcode_atts(array(
			'posts' => ''
		), $atts));

		$id_array = explode(',', $posts); 
	    $cutom_loop = new WP_Query( array( 
			'post_type' => 'post',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post__in' => $id_array
        ) );	
		//foreach ($id_array as $value) {
		//	echo "$value <br>";
		//}
		$content = '<div class="lk_image_grid">';
		while ( $cutom_loop->have_posts() ) : $cutom_loop->the_post();
			
			$content .= '<a href="' . get_permalink() . '" id="lk_image_' . get_the_ID() . '"><figure><img src="' . get_the_post_thumbnail_url() . '" alt="" class=""><figcaption>' . get_the_title() .'</figcaption></figure></a>';
		endwhile;
		$content .= '</div>';
		wp_reset_postdata();
		return $content;
    }	
}
 
$LKPostImageGrid = new LKPostImageGrid();
?>