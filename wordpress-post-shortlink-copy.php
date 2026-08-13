<?php
/**
 * Plugin Name:       WordPress Post Shortlink Copy
 * Plugin URI:        https://github.com/amirrezashf/WordPress-Post-Shortlink-Copy
 * Description:       Display a minimal shortlink field with a copy button at the end of single WordPress posts.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Amirreza Shayesteh Far
 * Author URI:        https://github.com/amirrezashf
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wp-post-shortlink-copy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class WP_Post_Shortlink_Copy {

	const VERSION       = '1.0.0';
	const STYLE_HANDLE  = 'wp-post-shortlink-copy';
	const SCRIPT_HANDLE = 'wp-post-shortlink-copy';

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_filter( 'the_content', array( $this, 'append_shortlink_box' ), 50 );
	}

	private function should_load() {
		return ! is_admin() && is_singular( 'post' );
	}

	public function enqueue_assets() {
		if ( ! $this->should_load() ) {
			return;
		}

		wp_register_style( self::STYLE_HANDLE, false, array(), self::VERSION );
		wp_enqueue_style( self::STYLE_HANDLE );
		wp_add_inline_style( self::STYLE_HANDLE, $this->get_css() );

		wp_register_script( self::SCRIPT_HANDLE, '', array(), self::VERSION, true );
		wp_enqueue_script( self::SCRIPT_HANDLE );
		wp_add_inline_script( self::SCRIPT_HANDLE, $this->get_js() );
	}

	public function append_shortlink_box( $content ) {
		if (
			! $this->should_load() ||
			! in_the_loop() ||
			! is_main_query()
		) {
			return $content;
		}

		$post_id = get_the_ID();

		if ( ! $post_id ) {
			return $content;
		}

		$shortlink = wp_get_shortlink( $post_id, 'post' );

		if ( ! $shortlink ) {
			$shortlink = get_permalink( $post_id );
		}

		if ( ! $shortlink ) {
			return $content;
		}

		$input_id = 'wppsc-shortlink-' . absint( $post_id );

		ob_start();
		?>
		<div class="wppsc" dir="rtl" aria-label="<?php echo esc_attr__( 'Short link for this post', 'wp-post-shortlink-copy' ); ?>">
			<div class="wppsc__row">
				<label class="wppsc__label" for="<?php echo esc_attr( $input_id ); ?>">
					<?php echo esc_html__( 'لینک کوتاه نوشته', 'wp-post-shortlink-copy' ); ?>
				</label>

				<div class="wppsc__field">
					<input
						id="<?php echo esc_attr( $input_id ); ?>"
						class="wppsc__input"
						type="text"
						readonly
						value="<?php echo esc_attr( $shortlink ); ?>"
						inputmode="url"
						aria-label="<?php echo esc_attr__( 'Short link address', 'wp-post-shortlink-copy' ); ?>"
					/>

					<button
						type="button"
						class="wppsc__copy"
						data-copy-target="<?php echo esc_attr( $input_id ); ?>"
						aria-label="<?php echo esc_attr__( 'Copy short link', 'wp-post-shortlink-copy' ); ?>"
					>
						<?php echo esc_html__( 'کپی لینک', 'wp-post-shortlink-copy' ); ?>
					</button>
				</div>

				<span class="wppsc__hint" aria-live="polite"></span>
			</div>
		</div>
		<?php

		return $content . ob_get_clean();
	}

	private function get_css() {
		return <<<'CSS'
.wppsc{
	--wppsc-accent:#5f27cd;
	--wppsc-text:rgba(15,23,42,.92);
	--wppsc-muted:rgba(15,23,42,.55);
	--wppsc-border:rgba(15,23,42,.12);
	--wppsc-background:#fff;
	--wppsc-soft:rgba(95,39,205,.08);
	--wppsc-radius:12px;
	margin-top:16px;
	padding:12px;
	border:1px solid var(--wppsc-border);
	border-radius:var(--wppsc-radius);
	background:var(--wppsc-background);
}
.wppsc__row{display:flex;flex-direction:column;gap:8px}
.wppsc__label{font-size:13px;font-weight:700;color:var(--wppsc-text);line-height:1.4}
.wppsc__field{display:flex;align-items:stretch;gap:8px}
.wppsc__input{
	flex:1 1 auto;
	width:100%;
	min-width:0;
	border:1px solid var(--wppsc-border);
	border-radius:var(--wppsc-radius);
	background:#fff;
	padding:10px 12px;
	font-size:13px;
	font-weight:600;
	color:rgba(15,23,42,.86);
	outline:none;
	box-shadow:none;
	direction:ltr;
	text-align:left;
}
.wppsc__input:focus{border-color:rgba(95,39,205,.35)}
.wppsc__copy{
	flex:0 0 auto;
	border:1px solid rgba(95,39,205,.22);
	background:var(--wppsc-soft);
	color:var(--wppsc-accent);
	border-radius:var(--wppsc-radius);
	padding:0 14px;
	font-size:13px;
	font-weight:700;
	cursor:pointer;
	box-shadow:none;
	line-height:1;
	white-space:nowrap;
	transition:background-color .18s ease,color .18s ease,border-color .18s ease,transform .18s ease;
}
.wppsc__copy:hover{background:rgba(95,39,205,.12)}
.wppsc__copy:active{transform:scale(.99)}
.wppsc__hint{min-height:16px;font-size:12px;font-weight:600;color:var(--wppsc-muted)}
.wppsc.is-copied .wppsc__copy{
	background:rgba(16,185,129,.10);
	border-color:rgba(16,185,129,.28);
	color:rgb(16,185,129);
}
.wppsc.is-error .wppsc__copy{
	background:rgba(220,38,38,.08);
	border-color:rgba(220,38,38,.24);
	color:rgb(185,28,28);
}
@media (max-width:520px){
	.wppsc__field{flex-direction:column}
	.wppsc__copy{width:100%;min-height:40px}
}
CSS;
	}

	private function get_js() {
		$copied = wp_json_encode( __( 'کپی شد', 'wp-post-shortlink-copy' ) );
		$failed = wp_json_encode( __( 'کپی انجام نشد', 'wp-post-shortlink-copy' ) );

		return <<<JS
(function () {
	'use strict';

	if (window.__wppscInitialized) {
		return;
	}
	window.__wppscInitialized = true;

	var copiedMessage = {$copied};
	var failedMessage = {$failed};

	function fallbackCopy(text) {
		var textarea = document.createElement('textarea');
		textarea.value = text;
		textarea.setAttribute('readonly', '');
		textarea.style.position = 'fixed';
		textarea.style.top = '-9999px';
		textarea.style.left = '-9999px';
		document.body.appendChild(textarea);
		textarea.focus();
		textarea.select();
		textarea.setSelectionRange(0, textarea.value.length);

		var succeeded = false;
		try {
			succeeded = document.execCommand('copy');
		} catch (error) {
			succeeded = false;
		}

		document.body.removeChild(textarea);
		return succeeded;
	}

	async function copyText(text) {
		if (navigator.clipboard && window.isSecureContext) {
			try {
				await navigator.clipboard.writeText(text);
				return true;
			} catch (error) {}
		}

		return fallbackCopy(text);
	}

	function showStatus(box, success) {
		var hint = box.querySelector('.wppsc__hint');
		if (!hint) {
			return;
		}

		hint.textContent = success ? copiedMessage : failedMessage;
		box.classList.toggle('is-copied', success);
		box.classList.toggle('is-error', !success);

		if (box.__wppscTimer) {
			window.clearTimeout(box.__wppscTimer);
		}

		box.__wppscTimer = window.setTimeout(function () {
			box.classList.remove('is-copied', 'is-error');
			hint.textContent = '';
		}, 1600);
	}

	document.addEventListener('click', async function (event) {
		var button = event.target.closest ? event.target.closest('.wppsc__copy') : null;
		if (!button) {
			return;
		}

		var box = button.closest('.wppsc');
		var targetId = button.getAttribute('data-copy-target');

		if (!box || !targetId) {
			return;
		}

		var input = document.getElementById(targetId);
		if (!input) {
			showStatus(box, false);
			return;
		}

		var text = (input.value || '').trim();
		if (!text) {
			showStatus(box, false);
			return;
		}

		showStatus(box, await copyText(text));
	});

	document.addEventListener('focusin', function (event) {
		if (!event.target.classList || !event.target.classList.contains('wppsc__input')) {
			return;
		}

		try {
			event.target.select();
		} catch (error) {}
	});
}());
JS;
	}
}

WP_Post_Shortlink_Copy::instance();
