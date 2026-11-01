<?php
/** Gutenberg color picker bridge for the Customizer.
 *
 * @package XScroll
 */

// phpcs:disable WordPress.Files.FileName -- PSR-4 filenames match this plugin's Composer class map.
namespace CoderPlus\XScrollTopResponsive;

/** Customizer control backed by the shared WordPress ColorPicker. */
class ColorControl extends \WP_Customize_Control {
	/**
	 * Customizer control type.
	 *
	 * @var string
	 */
	public $type = 'xscroll-color';

	/** Render the control without changing the existing setting. */
	public function render_content() {
		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="xscroll-color-control">
			<button type="button" class="xscroll-color-toggle" aria-expanded="false" aria-haspopup="dialog" aria-label="<?php echo esc_attr( $this->label ); ?>">
				<span class="xscroll-color-swatch" aria-hidden="true"></span>
				<span class="xscroll-color-value"><?php esc_html_e( 'Select Color', 'x-scroll-to-top-responsive' ); ?></span>
			</button>
			<div class="xscroll-color-picker" data-default="<?php echo esc_attr( $this->setting->default ); ?>" data-reset="<?php esc_attr_e( 'Reset', 'x-scroll-to-top-responsive' ); ?>"></div>
		</div>
		<?php
	}
}
