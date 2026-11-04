<?php
/**
 * The Author Photo tab of a post type's Page Title settings: show the
 * post author's photo beside single post titles.
 *
 * @since 1.0
 */

class md_author_photo extends md_api {

	/**
	 * Hooks.
	 *
	 * @since 1.0
	 */

	public function actions() {
		add_filter( 'md_admin_page_hero_fields', array( $this, 'tabs' ), 11 );
	}

	/**
	 * Only singles show the photo, so skip the tab on taxonomy and
	 * author archive settings.
	 *
	 * @since 1.0
	 */

	public function tabs( $fields ) {
		if ( ! empty( $this->_get_screen['is_taxonomy'] ) || ( $this->_get_screen['page'] ?? '' ) === 'md_author' )
			unset( $fields[$this->_clean_id] );

		return $fields;
	}

	/**
	 * Register the tab on post type settings screens.
	 *
	 * @since 1.0
	 */

	public function register() {
		$this->name = __( 'Author Photo', 'md-author' );

		return array(
			'admin_page' => array(
				'name' => $this->name,
				'child_of' => array( 'hero', 'page_settings' ),
				'fields' => $this->fields()
			)
		);
	}

	/**
	 * Set options for save.
	 *
	 * @since 1.0
	 */

	public function fields() {
		return array(
			'display' => array(
				'type' => 'checkbox',
				'options' => array(
					'show' => __( 'Show the author&rsquo;s photo beside single post titles', 'md-author' )
				)
			),
			'position' => array(
				'type' => 'select',
				'label' => __( 'Position', 'md-author' ),
				'options' => array( 'title_right', 'title_center' )
			),
			'mobile' => array(
				'type' => 'select',
				'label' => __( 'Position on mobile', 'md-author' ),
				'options' => array(
					'beside' => __( 'Keep beside', 'md-author' ),
					'hide' => __( 'Hide', 'md-author' )
				)
			),
			'image_width' => array(
				'type' => 'number',
				'label' => __( 'Max width', 'md-author' ),
				'max' => 550
			)
		);
	}

	/**
	 * Render the tab.
	 *
	 * @since 1.0
	 */

	public function admin_fields() {
		$show = $this->fields->saved( array( 'display', 'show' ) );
		$positions = $this->fields->data->values['featured_image'];

		include md_template( 'dropins', 'author/admin/author-photo', true );
	}

}

new md_author_photo( 'md_author_photo' );
