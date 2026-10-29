<?php

class CleanupPermissionsTest extends WP_Ajax_UnitTestCase {

	public function test_subscriber_cannot_delete_settings_even_with_a_valid_nonce() {
		$user_id = self::factory()->user->create( array( 'role' => 'subscriber' ) );
		wp_set_current_user( $user_id );
		update_option( 'x_scroll_color', '#123456' );
		$_POST['nonce']    = wp_create_nonce( 'delete_old_settings_nonce' );
		$_REQUEST['nonce'] = $_POST['nonce'];
		try {
			$this->_handleAjax( 'delete_old_xscroll_settings' );
		} catch ( WPAjaxDieContinueException $exception ) {
			// wp_send_json_error terminates the simulated request.
		}
		$this->assertSame( '#123456', get_option( 'x_scroll_color' ) );
		$response = json_decode( $this->_last_response, true );
		$this->assertFalse( $response['success'] );
	}
}
