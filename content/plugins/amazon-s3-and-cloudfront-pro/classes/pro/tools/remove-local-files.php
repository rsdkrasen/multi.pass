<?php

namespace DeliciousBrains\WP_Offload_S3\Pro\Tools;

use DeliciousBrains\WP_Offload_S3\Pro\Background_Processes\Background_Tool_Process;
use DeliciousBrains\WP_Offload_S3\Pro\Background_Processes\Remove_Local_Files_Process;
use DeliciousBrains\WP_Offload_S3\Pro\Background_Tool;

class Remove_Local_Files extends Background_Tool {

	/**
	 * @var string
	 */
	protected $tool_key = 'remove_local_files';

	/**
	 * @var string
	 */
	protected $tab = 'media';

	/**
	 * Initialize the tool.
	 */
	public function init() {
		parent::init();

		add_action( 'as3cfpro_load_assets', array( $this, 'load_assets' ) );
		add_action( 'as3cf_form_hidden_fields', array( $this, 'render_hidden_field' ) );
		add_action( 'as3cf_after_settings', array( $this, 'render_modal' ) );
		add_action( 'as3cf_pre_save_settings', array( $this, 'maybe_start_tool_on_settings_save' ) );
	}

	/**
	 * Load assets.
	 */
	public function load_assets() {
		if ( ! $this->should_display_prompt() ) {
			return;
		}

		$version = $this->as3cf->get_asset_version();
		$suffix  = $this->as3cf->get_asset_suffix();

		$src = plugins_url( 'assets/js/pro/tools/remove-local-files' . $suffix . '.js', $this->as3cf->get_plugin_file_path() );
		wp_enqueue_script( 'as3cf-pro-remove-local-files', $src, array( 'jquery', 'wp-util' ), $version, true );
	}

	/**
	 * Render hidden form field on settings screen.
	 */
	public function render_hidden_field() {
		if ( ! $this->should_display_prompt() ) {
			return;
		}

		echo '<input type="hidden" name="remove-local-files-prompt" value="0" />';
	}

	/**
	 * Render modal in footer.
	 */
	public function render_modal() {
		if ( ! $this->should_display_prompt() ) {
			return;
		}

		$this->as3cf->render_view( 'modals/remove-local-files' );
	}

	/**
	 * Should we display the prompt to the user?
	 *
	 * @return bool
	 */
	protected function should_display_prompt() {
		if ( $this->count_media_files() > 0 ) {
			return true;
		}

		return false;
	}

	/**
	 * Maybe start removal if user selected 'Yes' to prompt.
	 */
	public function maybe_start_tool_on_settings_save() {
		if ( ! isset( $_POST['remove-local-files-prompt'] ) || 0 === (int) $_POST['remove-local-files-prompt'] ) {
			return;
		}

		if ( $this->is_queued() ) {
			return;
		}

		$session = $this->create_session();

		$this->background_process->push_to_queue( $session )->save()->dispatch();
	}

	/**
	 * Should render.
	 *
	 * @return bool
	 */
	public function should_render() {
		return $this->count_media_files() && (bool) $this->as3cf->get_setting( 'remove-local-file', false );
	}

	/**
	 * Count media files on S3.
	 *
	 * @return int
	 */
	protected function count_media_files() {
		static $count;

		if ( is_null( $count ) ) {
			$count = $this->as3cf->get_media_library_s3_total( true );
		}

		return $count;
	}

	/**
	 * Get title text.
	 *
	 * @return string
	 */
	public function get_title_text() {
		return __( 'Remove all files from server', 'amazon-s3-and-cloudfront' );
	}

	/**
	 * Get more info text.
	 *
	 * @return string
	 */
	public function get_more_info_text() {
		return __( 'You can use this tool to delete all Media Library files from your local server that have already been uploaded to S3.', 'amazon-s3-and-cloudfront' );
	}

	/**
	 * Get button text.
	 *
	 * @return string
	 */
	public function get_button_text() {
		return __( 'Begin Removal', 'amazon-s3-and-cloudfront' );
	}

	/**
	 * Get status description.
	 *
	 * @return string
	 */
	public function get_status_description() {
		if ( $this->is_processing() && ( $this->is_cancelled() || $this->is_paused() ) ) {
			return __( 'Completing current batch.', 'amazon-s3-and-cloudfront' );
		}

		if ( $this->is_paused() ) {
			return __( 'Paused', 'amazon-s3-and-cloudfront' );
		}

		if ( $this->is_queued() ) {
			return __( 'Removing Media Library files from your local server.', 'amazon-s3-and-cloudfront' );
		}

		return '';
	}

	/**
	 * Get background process class.
	 *
	 * @return Background_Tool_Process|null
	 */
	protected function get_background_process_class() {
		return new Remove_Local_Files_Process( $this->as3cf );
	}
}