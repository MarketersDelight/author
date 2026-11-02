<?php

/**
 * Checks if author box is active on page.
 *
 * @since 1.0
 */

function md_has_author_box() {
	if ( ! md_is_queried_post() )
		return false;

	$enable = md_post_type_field( array( 'layout', 'content', 'add_author_box' ) );
	$add = md_post_meta( array( 'layout', 'content', 'add_author_box' ) );
	$remove = md_post_meta( array( 'layout', 'content', 'author_box' ) );

	return ( $enable && ! $remove ) || $add;
}

/**
 * The author box after a single post's content, built from the author's
 * profile: photo, name, bio and links. Runs on md_hook_content_item.
 *
 * @since 1.0
 */

function md_author_box() {
	if ( ! md_has_author_box() )
		return;

	$author_id = get_post_field( 'post_author', get_queried_object_id() );
	$author = get_userdata( $author_id );

	if ( ! $author )
		return;

	$twitter = get_user_meta( $author_id, 'twitter', true );
	$website_url = $author->user_url;
	$author_name = $author->display_name;
	$description = $author->description;
	$author_url = get_author_posts_url( $author_id );
	$has_avatar = get_option( 'show_avatars' );

	include md_template( 'dropins', 'author/author-box', true );
}

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
