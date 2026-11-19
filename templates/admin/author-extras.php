<div class="md-widget md-toggle">

	<h3 class="md-widget-title"><?php echo md_get_dropin_icon( 'author', 'small' ); ?><span><?php esc_html_e( 'Author Extras', 'md-author' ); ?><span class="md-widget-description"><?php esc_html_e( 'Extra details in your author box', 'md-author' ); ?></span></span></h3>

	<div class="md-widget-item md-widget-rows">

		<div class="md-field-row">
			<?php $this->fields->field( 'job_title', array(
				'description' => __( 'Shown under your name in the author box.', 'md-author' ),
				'attributes' => array( 'maxlength' => 60 ),
				'user_meta' => $user_meta
			) ); ?>
		</div>

		<div>
			<h4 class="mb-single"><?php esc_html_e( 'Social profiles', 'md-author' ); ?></h4>

			<?php foreach ( array_keys( array_diff_key( $this->register['user_meta']['fields'], array( 'job_title' => true, 'links' => true ) ) ) as $key ) : ?>

			<div class="md-field-row mb-single">
				<?php $this->fields->field( $key, array( 'user_meta' => $user_meta ) ); ?>
			</div>

			<?php endforeach; ?>
		</div>

		<?php $this->fields->field( 'links', array(
			'label' => __( 'Other links', 'md-author' ),
			'description' => __( 'Up to 3, like a book or another site. Shown beside your website.', 'md-author' ),
			'button_text' => __( 'Add link', 'md-author' ),
			'callback' => array( $this, 'link_fields' )
		) ); ?>

	</div>

</div>
