<?php
use CoderPlus\XScrollTopResponsive\Colors;
use CoderPlus\XScrollTopResponsive\CoreUpdate;

class ColorsTest extends WP_UnitTestCase {
    public function test_opaque_and_alpha_colors_are_accepted_without_rewriting() {
        foreach (array('#abc', '#ABCDEF', '#1234', '#12345600', '#12345680', 'transparent', 'rgb(1, 2, 3)', 'rgba(1,2,3,0.25)') as $color) {
            $this->assertSame($color, Colors::sanitize($color));
        }
    }
    public function test_invalid_colors_cannot_become_css() {
        foreach (array('red;display:none', '#12345', '#gggggg', 'rgba(256,0,0,0.5)', 'rgba(0,0,0,2)', 'rgb(0,0,0,0)', array(), '') as $color) {
            $this->assertNull(Colors::sanitize($color));
        }
    }
    public function test_new_controls_do_not_reset_existing_settings() {
        $settings = array('icon_color' => '#123456', 'icon_bg_color' => '#65432180', 'icon_hover_color' => '#ABCDEF', 'icon_hover_bg_color' => '#00000000', 'size' => 44, 'scroll_speed' => 9);
        update_option('xstr_option', $settings);
        CoreUpdate::run_migrations();
        CoreUpdate::run_migrations();
        $this->assertSame($settings, get_option('xstr_option'));
    }
}
