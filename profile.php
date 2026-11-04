<?php
/**
 * The Author photo upload on user profiles. It keeps the theme's
 * md_author ID, so photos saved before the move stay where they are
 * (the user meta's author → photo).
 *
 * @since 1.0
 */

class md_author_profile extends md_api {

	/**
	 * Register the profile field.
	 *
	 * @since 1.0
	 */

	public function register() {
		return array(
			'user_meta' => array(
				'name' => __( 'Author', 'md-author' ),
				'fields' => array(
					'photo' => array(
						'type' => 'upload',
						'upload_type' => 'media',
						'label' => __( 'Author photo', 'md-author' )
					)
				)
			)
		);
	}

	/**
	 * Render the Author photo field.
	 *
	 * @since 1.0
	 */

	public function user_meta( $user_meta ) {
		$this->fields->field( 'photo', array(
			'description' => __( 'Shown in post titles and on your author page, and as your avatar in bylines, the author box and comments.', 'md-author' ),
			'user_meta' => $user_meta
		) );
	}

}

new md_author_profile( 'md_author' );
