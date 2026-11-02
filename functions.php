<?php

/**
 * A user's uploaded Author photo, as an attachment ID. 0 when they have
 * none. Gravatar is never used here.
 *
 * @since 1.0
 */

function md_author_photo_id( $user_id ) {
	$photo_id = (int) md_user_meta( array( 'author', 'photo', 'id' ), $user_id, 0 );

	return $photo_id && wp_attachment_is_image( $photo_id ) ? $photo_id : 0;
}

/**
 * The post author's uploaded photo as a title image, when the post type
 * shows one and the post doesn't hide it. Authors without an uploaded
 * photo get no title image. 'author' marks the image as the author's.
 *
 * @since 1.0
 */

function md_get_title_author_media() {
	$settings = md_post_type_field( 'author_photo', array() );

	if ( empty( $settings['display']['show'] ) || md_post_meta( array( 'layout', 'content', 'hide_title_image' ) ) )
		return array();

	$author_id = (int) get_post_field( 'post_author' );
	$photo_id = md_author_photo_id( $author_id );

	if ( ! $photo_id )
		return array();

	return array(
		'media_type' => 'image',
		'image' => array( 'id' => $photo_id ),
		'author' => $author_id,
		'position' => ! empty( $settings['position'] ) ? $settings['position'] : 'title_left',
		'mobile' => $settings['mobile'] ?? '',
		'image_width' => $settings['image_width'] ?? ''
	);
}
