<?php
/**
 * The author's job title, social profiles and own links on the user profile,
 * shown in the theme's author box. Social profiles save to their own user
 * meta keys, so the theme and SEO plugins read the same values.
 *
 * @since 1.1
 */

class md_author_social extends md_api {

	/**
	 * Hooks.
	 *
	 * @since 1.1
	 */

	public function actions() {
		add_filter( 'md_author_box_links', array( $this, 'links' ), 10, 2 );
		add_filter( 'md_author_box_subtitle', array( $this, 'job_title' ), 10, 2 );
	}

	/**
	 * Register the profile group. Users can fill in their own profiles.
	 *
	 * @since 1.1
	 */

	public function register() {
		return array(
			'user_meta' => array(
				'name' => __( 'Author Extras', 'md-author' ),
				'edit_user' => true,
				'fields' => $this->fields()
			)
		);
	}

	/**
	 * One field per network, leaving out any another plugin already adds to
	 * the profile (both save to the same meta key), then the author's own
	 * links.
	 *
	 * @since 1.1
	 */

	private function fields() {
		$fields = array(
			'job_title' => array(
				'type' => 'text',
				'label' => __( 'Job title', 'md-author' ),
				'maxlength' => 60
			)
		);
		$taken = wp_get_user_contact_methods();

		foreach ( $this->networks() as $key => $network )
			if ( ! isset( $taken[$key] ) )
				$fields[$key] = array(
					'type' => $key === 'twitter' ? 'text' : 'url',
					'label' => $network['label'],
					'standalone' => true
				);

		$fields['links'] = array(
			'type' => 'group',
			'max' => 3,
			'fields' => array(
				'label' => array( 'type' => 'text', 'maxlength' => 30 ),
				'url' => array( 'type' => 'url' )
			)
		);

		return $fields;
	}

	/**
	 * The networks, in the order the author box lists them. Keys match the
	 * user meta keys SEO plugins use where they have the same network.
	 *
	 * @since 1.1
	 */

	private function networks() {
		return array(
			'twitter' => array( 'label' => 'X', 'icon' => 'x' ),
			'youtube' => array( 'label' => 'YouTube', 'icon' => 'youtube' ),
			'instagram' => array( 'label' => 'Instagram', 'icon' => 'instagram' ),
			'linkedin' => array( 'label' => 'LinkedIn', 'icon' => 'linkedin' ),
			'facebook' => array( 'label' => 'Facebook', 'icon' => 'facebook' ),
			'pinterest' => array( 'label' => 'Pinterest', 'icon' => 'pinterest' ),
			'tiktok' => array( 'label' => 'TikTok', 'icon' => 'tiktok' ),
			'bluesky' => array( 'label' => 'Bluesky', 'icon' => 'bluesky' ),
			'substack' => array( 'label' => 'Substack', 'icon' => 'substack' ),
			'telegram' => array( 'label' => 'Telegram', 'icon' => 'telegram' ),
			'github' => array( 'label' => 'GitHub', 'icon' => 'github' )
		);
	}

	/**
	 * Add the author's filled profiles to the author box's links, in network
	 * order, and up to 3 of their own links, which sit beside the website.
	 * The theme already turns an X username into a link.
	 *
	 * @since 1.1
	 */

	public function links( $links, $author_id ) {
		$profiles = array();
		$own = (array) md_user_meta( array( $this->_clean_id, 'links' ), $author_id, array() );

		foreach ( $this->networks() as $key => $network ) {
			$url = isset( $links[$key] ) ? $links[$key]['url'] : get_user_meta( $author_id, $key, true );

			if ( $url )
				$profiles[$key] = array(
					'label' => $network['label'],
					'url' => $url,
					'icon' => $network['icon']
				);
		}

		foreach ( array_slice( $own, 0, 3, true ) as $key => $link )
			if ( ! empty( $link['label'] ) && ! empty( $link['url'] ) )
				$profiles["link-$key"] = array(
					'label' => $link['label'],
					'url' => $link['url'],
					'icon' => 'external',
					'custom' => true
				);

		return array_merge( $profiles, $links );
	}

	/**
	 * One of the author's own links in the profile panel: its label and URL.
	 *
	 * @since 1.1
	 */

	public function link_fields( $path, $group ) {
		echo '<div class="grid columns-33-67 columns-half">';

		$this->fields->field( array_merge( (array) $path, array( $group, 'label' ) ), array(
			'type' => 'text',
			'placeholder' => __( 'Label', 'md-author' ),
			'attributes' => array( 'maxlength' => 30 )
		) );

		$this->fields->field( array_merge( (array) $path, array( $group, 'url' ) ), array( 'type' => 'url' ) );

		echo '</div>';
	}

	/**
	 * The author's job title, shown under their name in the author box.
	 *
	 * @since 1.1
	 */

	public function job_title( $subtitle, $author_id ) {
		$result = $subtitle;
		$job_title = (string) md_user_meta( array( $this->_clean_id, 'job_title' ), $author_id, '' );

		if ( $job_title !== '' )
			$result = $job_title;

		return $result;
	}

	/**
	 * Render the Author Extras panel.
	 *
	 * @since 1.1
	 */

	public function user_meta( $user_meta ) {
		include __DIR__ . '/templates/admin/author-extras.php';
	}

}

new md_author_social( 'md_author_social' );
