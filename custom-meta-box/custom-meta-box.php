<?php
/*
Plugin Name: Custom Meta Box
Plugin URI: 
Description: Custom Meta Box in services post
Author: DE MOOR Vincent
Author URI: 
Version: 1.0
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages/
Text Domain: custom-meta-box
*/
//* If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}


/**
 * Loads the image management javascript
 */
function prfx_image_enqueue() {
    global $typenow;
    if( $typenow == 'services' ) {
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', '/wp-content/themes/themeXXXX/includes/meta-box-image.js', array( 'jquery' ) );
        wp_localize_script( 'meta-box-image', 'meta_image',
            array(
                'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
                'button' => __( 'Use this image', 'prfx-textdomain' ),
            )
        );
        wp_enqueue_script( 'meta-box-image' );
    }
}
add_action( 'admin_enqueue_scripts', 'prfx_image_enqueue' );




/**
 * Adds a meta box to the post editing screen
 */
function prfx_custom_meta() {
    add_meta_box( 'prfx_meta', __( 'Meta Box Title', 'prfx-textdomain' ), 'prfx_meta_callback', 'services','normal', 'high' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function prfx_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>
 
    <p>
        <label for="meta-text" class="prfx-row-title"><?php _e( 'Example Text Input', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-text" id="meta-text" value="<?php if ( isset ( $prfx_stored_meta['meta-text'] ) ) echo $prfx_stored_meta['meta-text'][0]; ?>" />
    </p>

    <p>
	    <span class="prfx-row-title"><?php _e( 'Example Checkbox Input', 'prfx-textdomain' )?></span>
	    <div class="prfx-row-content">
	        <label for="meta-checkbox">
	            <input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="rouge" <?php if ( isset ( $prfx_stored_meta['meta-checkbox'] ) ) checked( $prfx_stored_meta['meta-checkbox'][0], 'rouge' ); ?> />
	            <?php _e( 'Checkbox label', 'prfx-textdomain' )?>
	        </label>
	        <label for="meta-checkbox-two">
	            <input type="checkbox" name="meta-checkbox-two" id="meta-checkbox-two" value="vert" <?php if ( isset ( $prfx_stored_meta['meta-checkbox-two'] ) ) checked( $prfx_stored_meta['meta-checkbox-two'][0], 'vert' ); ?> />
	            <?php _e( 'Another checkbox', 'prfx-textdomain' )?>
	        </label>
	    </div>
	</p>
	<p>
	    <span class="prfx-row-title"><?php _e( 'Example Radio Buttons', 'prfx-textdomain' )?></span>
	    <div class="prfx-row-content">
	        <label for="meta-radio-one">
	            <input type="radio" name="meta-radio" id="meta-radio-one" value="radio-one" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'radio-one' ); ?>>
	            <?php _e( 'Radio Option #1', 'prfx-textdomain' )?>
	        </label>
	        <label for="meta-radio-two">
	            <input type="radio" name="meta-radio" id="meta-radio-two" value="radio-two" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'radio-two' ); ?>>
	            <?php _e( 'Radio Option #2', 'prfx-textdomain' )?>
	        </label>
	    </div>
	</p>

	<p>
	    <label for="meta-select" class="prfx-row-title"><?php _e( 'Example Select Input', 'prfx-textdomain' )?></label>
	    <select name="meta-select" id="meta-select">
	        <option value="select-one" <?php if ( isset ( $prfx_stored_meta['meta-select'] ) ) selected( $prfx_stored_meta['meta-select'][0], 'select-one' ); ?>><?php _e( 'One', 'prfx-textdomain' )?></option>';
	        <option value="select-two" <?php if ( isset ( $prfx_stored_meta['meta-select'] ) ) selected( $prfx_stored_meta['meta-select'][0], 'select-two' ); ?>><?php _e( 'Two', 'prfx-textdomain' )?></option>';
	    </select>
	</p>	
	<p>
	    <label for="meta-textarea" class="prfx-row-title"><?php _e( 'Example Textarea Input', 'prfx-textdomain' )?></label>
	    <textarea name="meta-textarea" id="meta-textarea"><?php if ( isset ( $prfx_stored_meta['meta-textarea'] ) ) echo $prfx_stored_meta['meta-textarea'][0]; ?></textarea>
	</p>
	<p>
	    <label for="meta-image" class="prfx-row-title"><?php _e( 'Example File Upload', 'prfx-textdomain' )?></label>
	    <input type="text" name="meta-image" id="meta-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo $prfx_stored_meta['meta-image'][0]; ?>" />
	    <input type="button" id="meta-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'prfx-textdomain' )?>" />
	</p>
 
    <?php
}

/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'meta-text' ] ) ) {
        update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
    }

    // Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox' ] ) ) {
	    update_post_meta( $post_id, 'meta-checkbox', 'rouge' );
	} else {
	    update_post_meta( $post_id, 'meta-checkbox', '' );
	}
	 
	// Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox-two' ] ) ) {
	    update_post_meta( $post_id, 'meta-checkbox-two', 'vert' );
	} else {
	    update_post_meta( $post_id, 'meta-checkbox-two', '' );
	}
	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-radio' ] ) ) {
	    update_post_meta( $post_id, 'meta-radio', $_POST[ 'meta-radio' ] );
	}
	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-select' ] ) ) {
	    update_post_meta( $post_id, 'meta-select', $_POST[ 'meta-select' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-textarea' ] ) ) {
	    update_post_meta( $post_id, 'meta-textarea', $_POST[ 'meta-textarea' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-image' ] ) ) {
	    update_post_meta( $post_id, 'meta-image', $_POST[ 'meta-image' ] );
	}
 
}
add_action( 'save_post', 'prfx_meta_save' );


add_action('admin_init', 'wysiwyg_register_custom_meta_box');
 
function wysiwyg_register_custom_meta_box()
 {
 add_meta_box(WYSIWYG_META_BOX_ID, __('Custom WYSIWYG Meta Box', 'wysiwyg') , 'custom_wysiwyg', 'services');
 }
 
function custom_wysiwyg($post)
 {
 echo "<h3>Add Here Your Content:</h3>";
 $content = get_post_meta($post->ID, 'custom_wysiwyg', true);
 wp_editor(htmlspecialchars_decode($content) , 'custom_wysiwyg', array(
 "media_buttons" => true
 ));
 }
 
function custom_wysiwyg_save_postdata($post_id)
 {
 if (!empty($_POST['custom_wysiwyg']))
 {
 $data = htmlspecialchars($_POST['custom_wysiwyg']);
 update_post_meta($post_id, 'custom_wysiwyg', $data);
 }
 }
 
add_action('save_post', 'custom_wysiwyg_save_postdata');
