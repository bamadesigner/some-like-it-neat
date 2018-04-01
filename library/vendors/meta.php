<?php
/**
 * Carbon Fields Meta
 */
use Carbon_Fields\Field;
use Carbon_Fields\Container;

add_action( 'carbon_fields_register_fields', 'crb_attach_post_meta' );
function crb_attach_post_meta() {

 	Container::make( 'post_meta', __( 'Post Options', 'crb' ) )
	    ->where( 'post_type', 'CUSTOM', function( $post_type ) {
		    $args = array( 'public' => true );
		    $post_types = get_post_types( $args );
		    return in_array( $post_type, $post_types );
	    } )
		->set_context( 'side' )
		->set_priority( 'low' )
		->add_fields( array(
			Field::make( 'checkbox', 'some_like_it_neat_hide_title', 'Hide Page Title' )
				->set_help_text( 'Useful for Landing Pages' )
				->set_option_value( 'yes' ),
			Field::make( 'checkbox', 'some_like_it_neat_hide_featured_image', 'Hide Featured Image' )
				->set_help_text( 'Hide featured image on singular post, while still using it throughout the rest of your site' )
				->set_option_value( 'yes' ),
		) );

}

/**
 * Enable/Disable Post Title on per-page basis
 */
add_action( 'wp_head', 'some_like_it_neat_remove_title'  );
function some_like_it_neat_remove_title() {
	$title_option = carbon_get_the_post_meta( 'some_like_it_neat_hide_title' );

	if ( 'yes' == $title_option ) { ?>
        <style type="text/css">
            .entry-header {
                display: none;
            }
        </style>

	<?php }
}

/**
 * Enable/Disable Featured Image on per-page basis
 */
add_action( 'wp_head', 'some_like_it_neat_remove_featured_image'  );
function some_like_it_neat_remove_featured_image() {
	$image_option = carbon_get_the_post_meta( 'some_like_it_neat_hide_featured_image' );

	if ( $image_option === 'yes') { ?>
        <style type="text/css">
            .wp-post-image {
                display: none;
            }
        </style>

	<?php }
}