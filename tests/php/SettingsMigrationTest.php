<?php

use CoderPlus\XScrollTopResponsive\CoreUpdate;

class SettingsMigrationTest extends WP_UnitTestCase {

	public function test_existing_settings_are_retained_and_migration_is_idempotent() {
		delete_option( 'xstr_option' );
		update_option( 'x_scroll_color', '#123456' );
		update_option( 'x_scroll_size', '18px' );
		update_option( 'x_field_bg', '#abcdef' );
		CoreUpdate::run_migrations();
		$settings = get_option( 'xstr_option' );
		$this->assertSame( '#123456', $settings['icon_color'] );
		$this->assertSame( '#abcdef', $settings['icon_bg_color'] );
		$this->assertEquals( 36, $settings['size'] );
		$settings['icon_color'] = '#999999';
		update_option( 'xstr_option', $settings );
		CoreUpdate::run_migrations();
		$this->assertSame( $settings, get_option( 'xstr_option' ) );
	}

	public function test_saved_icon_cannot_inject_html_attributes() {
		update_option( 'xstr_option', array( 'icon_picker' => 'icon-up" onmouseover="alert(1)' ) );
		ob_start();
		( new CoderPlus\XScrollTopResponsive\Core() )->scroll_icon();
		$html = ob_get_clean();
		$this->assertStringNotContainsString( 'class="icon-up" onmouseover=', $html );
		$this->assertStringContainsString( '&quot;', $html );
	}
}
