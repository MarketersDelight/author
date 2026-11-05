<div class="md-<?php echo esc_attr( $this->_clean_id ); ?> md-tab-content md-conditional">

	<?php $this->fields->field( 'display', array(
		'classes' => 'md-conditional-option',
		'wrap_classes' => 'mb-third',
		'description' => sprintf( __( 'Uses the Author photo on each author&rsquo;s <a href="%s">profile</a>. A featured image placed beside the title keeps its place, and authors without a photo show none.', 'md-author' ), esc_url( admin_url( 'profile.php' ) ) )
	) ); ?>

	<div class="md-conditional-item md-conditional-1" style="display: <?php echo $show ? 'block' : 'none'; ?>">

	<div class="columns-3 columns-single md-full-select">

		<div class="col">
			<?php $this->fields->field( 'position', array(
				'empty_label' => $positions['title_left'],
				'options' => array(
					'title_right' => $positions['title_right'],
					'title_center' => $positions['title_center']
				)
			) ); ?>
		</div>

		<div class="col">
			<?php $this->fields->field( 'mobile', array(
				'empty_label' => __( 'Stack (default)', 'md-author' )
			) ); ?>
		</div>

		<div class="col">
			<?php $this->fields->field( 'image_width', array(
				'type' => 'range',
				'unit' => 'px'
			) ); ?>
		</div>

	</div>

	</div>

</div>
