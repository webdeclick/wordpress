			<?php			 
			    // Retrieves the stored value from the database
			    $meta_text = get_post_meta( get_the_ID(), 'meta-text', true );
			 	$meta_checkbox = get_post_meta( get_the_ID(), 'meta-checkbox', true );
			 	$meta_checkbox_two = get_post_meta( get_the_ID(), 'meta-checkbox-two', true );
			 	$meta_image = get_post_meta( get_the_ID(), 'meta-image', true );
			 	$custom_wysiwyg = get_post_meta( get_the_ID(), 'custom_wysiwyg', true );
			 	
			    // Checks and displays the retrieved value
			    if( !empty( $meta_text ) ) {
			        echo $meta_text;
			    }
			    if( !empty( $meta_checkbox ) ) {
			        echo $meta_checkbox;
			    }
			    if( !empty( $meta_checkbox_two ) ) {
			        echo $meta_checkbox_two;
			    }
			    if( !empty( $meta_image ) ) {
			        echo '<img src="'.$meta_image.'" alt="Texte Alternatif">';
			    }
			    if( !empty( $custom_wysiwyg ) ) {
			        echo $custom_wysiwyg;
			    }		


			    		 
			?>