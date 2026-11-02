<?php
/**
 * Drop-in Name: Author Extras
 * Description: Author photos, the author box, and the author's photo beside post titles.
 * Author: Alex, Kolakube
 * Author URI: https://marketersdelight.com/
 * Drop-in URI: https://marketersdelight.com/dropins/author/
 * Drop-in Slug: author
 * Text Domain: md-author
 * Version: 1.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Requires MD: 6.1.1
 */

class md_author_extras extends md_api {

	/**
	 * Load the author photo profile field, the Author Photo settings tab and
	 * the author functions.
	 *
	 * @since 1.0
	 */

	public function includes() {
		require_once __DIR__ . '/functions.php';
		require_once __DIR__ . '/profile.php';

		if ( is_admin() )
			require_once __DIR__ . '/admin.php';
	}

	/**
	 * Hooks.
	 *
	 * @since 1.0
	 */

	public function actions() {
		add_action( 'md_hook_content_item', 'md_author_box', 19 );
		add_filter( 'md_media', array( $this, 'author_page_media' ), 10, 2 );
		add_filter( 'md_title_media', array( $this, 'title_media' ), 10, 2 );
		add_filter( 'pre_get_avatar_data', array( $this, 'avatar_data' ), 10, 2 );
		add_filter( 'md_filter_save_layout_fields', array( $this, 'layout_fields' ) );
		add_action( 'md_hook_layout_content_fields', array( $this, 'layout_field' ), 10, 2 );
	}

	/**
	 * An author page shows the author's photo as its image, or the sitewide
	 * image when they have none.
	 *
	 * @since 1.0
	 */

	public function author_page_media( $media, $context ) {
		if ( $context !== 'page' || ! is_author() )
			return $media;

		$author_id = get_queried_object_id();
		$photo_id = md_author_photo_id( $author_id );

		if ( $photo_id ) {
			$media['image'] = array( 'id' => $photo_id );
			$media['author'] = $author_id;
		}

		return $media;
	}

	/**
	 * The author's photo takes a single post's title image unless the post's
	 * own image sits there.
	 *
	 * @since 1.0
	 */

	public function title_media( $media, $context ) {
		if ( $context === 'page' || ! md_is_queried_post() )
			return $media;

		if ( $media && in_array( $media['position'], array( 'title_left', 'title_right', 'title_center' ), true ) )
			return $media;

		$author_media = md_get_title_author_media();

		return $author_media ? $author_media : $media;
	}

	/**
	 * Swap an author's avatar for their uploaded photo, so it shows without
	 * a request to Gravatar. Authors without a photo keep their avatar.
	 *
	 * @since 1.0
	 */

	public function avatar_data( $args, $id_or_email ) {
		if ( $id_or_email instanceof WP_User )
			$user_id = $id_or_email->ID;
		elseif ( $id_or_email instanceof WP_Post )
			$user_id = (int) $id_or_email->post_author;
		elseif ( $id_or_email instanceof WP_Comment )
			$user_id = (int) $id_or_email->user_id;
		elseif ( is_numeric( $id_or_email ) )
			$user_id = (int) $id_or_email;
		else {
			$user = is_string( $id_or_email ) ? get_user_by( 'email', $id_or_email ) : false;
			$user_id = $user ? $user->ID : 0;
		}

		$photo_id = $user_id ? md_author_photo_id( $user_id ) : 0;
		$url = $photo_id ? wp_get_attachment_image_url( $photo_id, array( $args['size'], $args['size'] ) ) : '';

		if ( $url ) {
			$args['url'] = $url;
			$args['found_avatar'] = true;
		}

		return $args;
	}

	/**
	 * The author switches save into Layout's Content options, where they've
	 * always been, so existing settings carry over.
	 *
	 * @since 1.0
	 */

	public function layout_fields( $fields ) {
		if ( isset( $fields['content']['options'] ) )
			$fields['content']['options'] = array_merge( $fields['content']['options'], array( 'author_box', 'add_author_box', 'hide_title_image' ) );

		return $fields;
	}

	/**
	 * Draw the author switches in Layout's Content options: the post type's
	 * Add Author Box, and on a post, Add or Remove Author Box against the
	 * post type's setting and Remove Author photo when the post type shows
	 * one.
	 *
	 * @since 1.0
	 */

	public function layout_field( $fields, $context ) {
		$post_type = $context['post_type'];

		if ( $context['is_taxonomy'] || $context['is_term'] )
			return;

		if ( $context['is_admin'] ) {
			if ( $context['settings_post_type'] === 'author' )
				return;

			$fields->field( 'content', array(
				'type' => 'checkbox',
				'options' => array(
					'add_author_box' => __( 'Add <b>Author Box</b>', 'md-author' )
				)
			) );

			return;
		}

		if ( ! $context['is_post'] )
			return;

		if ( md_post_type_field( array( 'author_photo', 'display', 'show' ), null, $post_type ) )
			$fields->field( 'content', array(
				'type' => 'checkbox',
				'options' => array(
					'hide_title_image' => __( 'Remove <b>Author photo</b>', 'md-author' )
				)
			) );

		if ( $post_type === 'page' )
			return;

		$box = md_post_type_field( array( 'layout', 'content', 'add_author_box' ), null, $post_type )
			? array( 'author_box' => __( 'Remove <b>Author Box</b>', 'md-author' ) )
			: array( 'add_author_box' => __( 'Add <b>Author Box</b>', 'md-author' ) );

		$fields->field( 'content', array(
			'type' => 'checkbox',
			'options' => $box
		) );
	}

	/**
	 * Add the author box styles to MD's compiled stylesheet.
	 *
	 * @since 1.0
	 */

	public function css( $templates ) {
		$templates['author'] = md_css( 'dropins', 'author/css', true );

		return $templates;
	}

}

new md_author_extras;
