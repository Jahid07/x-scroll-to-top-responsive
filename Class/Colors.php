<?php
/** Validate the existing HEX colors and new alpha-enabled colors.
 *
 * @package XScroll
 */

// phpcs:disable WordPress.Files.FileName -- PSR-4 filenames match this plugin's Composer class map.
namespace CoderPlus\XScrollTopResponsive;

/** Validation for opaque and transparent CSS colors. */
class Colors {
	/**
	 * Validate colors accepted by the Customizer.
	 *
	 * @param mixed $value Submitted color.
	 * @return string|null Valid color, or null to reject the update.
	 */
	public static function sanitize( $value ) {
		if ( ! is_string( $value ) ) {
			return null;
		}
		$value = trim( $value );
		if ( preg_match( '/^#(?:[a-f0-9]{3}|[a-f0-9]{4}|[a-f0-9]{6}|[a-f0-9]{8})$/i', $value ) || 'transparent' === $value ) {
			return $value;
		}
		// Retain valid RGB(A) values previously saved by integrations.
		if ( preg_match( '/^(rgb|rgba)\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})(?:\s*,\s*(0|1|0?\.\d+))?\s*\)$/i', $value, $parts ) ) {
			$alpha = isset( $parts[5] );
			if ( ( strtolower( $parts[1] ) === 'rgba' ) === $alpha && max( (int) $parts[2], (int) $parts[3], (int) $parts[4] ) <= 255 && ( ! $alpha || (float) $parts[5] <= 1 ) ) {
				return $value;
			}
		}
		return null;
	}
}
