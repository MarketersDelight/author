<?php
/**
 * Tests Social profiles: the author box links they add, in network order,
 * and leaving out networks another plugin already adds.
 *
 * @since 1.1
 */

if ( ! function_exists( 'wp_get_user_contact_methods' ) ) {
	function wp_get_user_contact_methods() {
		return $GLOBALS['__test_contact_methods'] ?? array();
	}
}

require_once dirname( __DIR__ ) . '/social.php';

class SocialProfilesTest extends MD_InheritanceTestCase {

	private $social;

	protected function setUp(): void {
		parent::setUp();
		$GLOBALS['__test_contact_methods'] = array();
		$this->social = ( new ReflectionClass( 'md_author_social' ) )->newInstanceWithoutConstructor();
	}

	private function method( $method ) {
		$reflection = new ReflectionMethod( $this->social, $method );

		return $reflection->invoke( $this->social );
	}

	public function test_profiles_are_listed_in_network_order() {
		$GLOBALS['__test_user_keys'][3] = array( 'instagram' => 'https://instagram.com/a', 'youtube' => 'https://youtube.com/@a' );

		$result = $this->social->links( array(), 3 );

		$this->assertSame( array( 'youtube', 'instagram' ), array_keys( $result ) );
		$this->assertSame( 'YouTube', $result['youtube']['label'] );
	}

	public function test_x_keeps_the_link_the_theme_built() {
		$GLOBALS['__test_user_keys'][3] = array( 'twitter' => 'someone' );
		$links = array( 'twitter' => array( 'label' => 'X', 'url' => 'https://x.com/someone', 'icon' => 'x' ) );

		$this->assertSame( 'https://x.com/someone', $this->social->links( $links, 3 )['twitter']['url'] );
	}

	public function test_other_links_stay_after_the_profiles() {
		$GLOBALS['__test_user_keys'][3] = array( 'github' => 'https://github.com/a' );
		$links = array( 'shop' => array( 'label' => 'Shop', 'url' => 'https://shop.example', 'icon' => 'cart' ) );

		$this->assertSame( array( 'github', 'shop' ), array_keys( $this->social->links( $links, 3 ) ) );
	}

	public function test_fields_save_to_their_own_keys() {
		$fields = $this->method( 'fields' );

		$this->assertCount( 13, $fields, 'Job title, 11 networks and the own links group' );
		$this->assertSame( 60, $fields['job_title']['maxlength'] );
		$this->assertSame( 30, $fields['links']['fields']['label']['maxlength'] );
		$this->assertSame( 3, $fields['links']['max'] );
		$this->assertTrue( $fields['youtube']['standalone'] );
		$this->assertSame( 'text', $fields['twitter']['type'], 'X takes a username or a URL' );
		$this->assertSame( 'url', $fields['youtube']['type'] );
	}

	public function test_networks_another_plugin_adds_are_left_out() {
		$GLOBALS['__test_contact_methods'] = array( 'twitter' => 'X', 'facebook' => 'Facebook' );

		$fields = $this->method( 'fields' );

		$this->assertArrayNotHasKey( 'twitter', $fields );
		$this->assertArrayNotHasKey( 'facebook', $fields );
		$this->assertCount( 11, $fields );
	}

	public function test_own_links_are_custom_capped_at_three_and_need_a_label_and_url() {
		md_test_set_user_meta( 3, array( 'author_social' => array( 'links' => array(
			'a' => array( 'label' => 'Book', 'url' => 'https://book.example' ),
			'b' => array( 'label' => '', 'url' => 'https://nolabel.example' ),
			'c' => array( 'label' => 'Podcast', 'url' => 'https://podcast.example' ),
			'd' => array( 'label' => 'Fourth', 'url' => 'https://fourth.example' )
		) ) ) );
		$this->social->_clean_id = 'author_social';
		$GLOBALS['__test_user_keys'][3] = array();

		$result = $this->social->links( array(), 3 );

		$this->assertSame( array( 'link-a', 'link-c' ), array_keys( $result ), 'The first 3 rows, minus the one without a label' );
		$this->assertTrue( $result['link-a']['custom'] );
		$this->assertSame( 'Book', $result['link-a']['label'] );
	}

	public function test_job_title_fills_the_author_box_subtitle() {
		md_test_set_user_meta( 3, array( 'author_social' => array( 'job_title' => 'Founder, Calm & Collected' ) ) );
		$this->social->_clean_id = 'author_social';

		$this->assertSame( 'Founder, Calm & Collected', $this->social->job_title( '', 3 ) );
	}

	public function test_no_job_title_keeps_the_subtitle() {
		md_test_set_user_meta( 3, array() );
		$this->social->_clean_id = 'author_social';

		$this->assertSame( 'From another filter', $this->social->job_title( 'From another filter', 3 ) );
	}

}
