<?php

/* Public methods in this class will be run at least once during plugin activation script. */
/* Updater methods fired are stored in transient to prevent repeat processing */

if ( !class_exists('CTA_Activation_Update_Routines') ) {

	class CTA_Activation_Update_Routines {

		/**
		* @introduced: 2.0.8
		* @migration-type: Meta pair migragtion
		* @mirgration: convert meta key cta_ab_variations to wp-cta-variations & delete cta_ab_variations
		* @mirgration: convert meta key wp-cta-variation-notes to a sub key of wp-cta-variations object
		* @migration: convert all meta keys that do not have an -{{vid}} suffix to a -0 suffix
		*/
		public static function create_variation_objects() {
			$ctas = get_posts( array(
				'post_type' => 'wp-call-to-action',
				'posts_per_page' => -1
			));

			/* loop through ctas and migrate data */
			foreach ($ctas as $cta) {
				$variations = array();

				/* If CTA already has our upgraded meta key then continue to next cta*/
				if ( get_post_meta( $cta->ID, 'wp-cta-variations', true ) ) {
					continue;
				}

				$legacy_value = get_post_meta( $cta->ID, 'cta_ab_variations', true );
				$variation_ids_array = explode(',', $legacy_value );
				$variation_ids_array = ($variation_ids_array) ? $variation_ids_array : array(0=>0);

				foreach ( $variation_ids_array as $vid ) {

					/* get variation status */
					$status = get_post_meta( $cta->ID, 'wp_cta_ab_variation_status', true);

					/* Get variation notes & alter key for variations with vid=0 */
					if (!$vid) {

						/* for each meta without an variation id add one */
						$meta = get_post_meta( $cta->ID );
						$notes = get_post_meta( $cta->ID, 'wp-cta-variation-notes', true );

						foreach ( $meta as $key => $value ) {
							if ( !is_numeric( substr( $key, -1) ) ) {
								add_post_meta( $cta->ID, $key . '-0', $value[0], true );
								//echo $cta->ID . ' ' .  $key . '-0 ' . $value[0] . '<br>';
							}
						}

					} else {
						$notes =  get_post_meta( $cta->ID, 'wp-cta-variation-notes-' . $vid, true);
					}

					if ( $status == 2 ) {
						$status = 'paused';
					} else {
						$status = 'active';
					}

					$variations[ $vid ][ 'status' ] = $status;
					$variations[ $vid ][ 'notes' ] = $notes;
				}

				CTA_Variations::update_variations ( $cta->ID, $variations );

			}
		}

		/**
		*  Creates an example call to action
		* @introduced: 2.0.0
		*
		*
		*/
		public static function default_content() {

			$results = new WP_Query( array(
				's' => __( 'A/B Testing Call To Action Example', 'inbound-pro' )
			));

			/* Make sure post does not exist before continuing */
			if ( $results->have_posts() ) {
				return;
			}

			$current_user = wp_get_current_user();

			$default_lander = wp_insert_post(
				array(
					'post_title'     => __( 'A/B Testing Call To Action Example', 'inbound-pro' ),
					'post_content'   => '',
					'post_status'    => 'publish',
					'post_author'    => $current_user->ID,
					'post_type'      => 'wp-call-to-action',
					'comment_status' => 'closed'
				)
			);

			/* Variation A */
			add_post_meta($default_lander, 'wp-cta-selected-template-0', 'flat-cta');
			add_post_meta($default_lander, 'wp_cta_width-0', '310');
			add_post_meta($default_lander, 'wp_cta_height-0', '300');
			add_post_meta($default_lander, 'flat-cta-header-text-0', __( 'Snappy Headline', 'cta'));
			add_post_meta($default_lander, 'flat-cta-sub-header-text-0', __('Awesome Subheadline Text Goes here', 'cta'));
			add_post_meta($default_lander, 'flat-cta-text-color-0', '000000');
			add_post_meta($default_lander, 'flat-cta-content-color-0', '60BCF0');
			add_post_meta($default_lander, 'flat-cta-content-text-color-0', 'ffffff');
			add_post_meta($default_lander, 'flat-cta-submit-button-color-0', 'ffffff');
			add_post_meta($default_lander, 'flat-cta-submit-button-text-0', __( 'Download Now', 'cta'));
			add_post_meta($default_lander, 'flat-cta-link_url-0', 'http://www.inboundnow.com');

			/* Variation B */
			add_post_meta($default_lander, 'wp-cta-selected-template-1', 'flat-cta');
			add_post_meta($default_lander, 'wp_cta_width-1', '310');
			add_post_meta($default_lander, 'wp_cta_height-1', '300');
			add_post_meta($default_lander, 'flat-cta-header-text-1', __( 'Great Offer', 'cta'));
			add_post_meta($default_lander, 'flat-cta-sub-header-text-1', __( 'Amazing Deals Await!<br> Click below to find<br> amazing deals', 'cta'));
			add_post_meta($default_lander, 'flat-cta-text-color-1', '000000');
			add_post_meta($default_lander, 'flat-cta-content-color-1', 'f22424');
			add_post_meta($default_lander, 'flat-cta-content-text-color-1', 'ffffff');
			add_post_meta($default_lander, 'flat-cta-submit-button-color-1', 'ffffff');
			add_post_meta($default_lander, 'flat-cta-submit-button-text-1', __( 'Learn More', 'cta'));
			add_post_meta($default_lander, 'flat-cta-link_url-1', 'http://www.inboundnow.com');

			/* Add A/B Testing meta */
			add_post_meta($default_lander, 'wp-cta-variations', '{ "0":{"status":"active"}, "1":{"status":"active"} }');
			add_post_meta($default_lander, 'wp-cta-ab-variation-impressions-0', 115);
			add_post_meta($default_lander, 'wp-cta-ab-variation-impressions-1', 113);
			add_post_meta($default_lander, 'wp-cta-ab-variation-conversions-0', 15);
			add_post_meta($default_lander, 'wp-cta-ab-variation-conversions-1', 27);

			add_post_meta($default_lander, 'link_open_option', 'this_window');


		}

		/**
		* @introduced: 1.5.1
		* @migration-type: db modification
		* @mirgration: creates wp_inbound_link_tracking table
		*/
		public static function create_link_tracking_table() {
			global $wpdb;
			$table_name = $wpdb->prefix . "inbound_tracked_links";
			$charset_collate = '';
			if ( ! empty( $wpdb->charset ) ) {
			  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
			}
			if ( ! empty( $wpdb->collate ) ) {
			  $charset_collate .= " COLLATE {$wpdb->collate}";
			}
			$sql = "CREATE TABLE $table_name (
			  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
			  `token` tinytext NOT NULL,
			  `args` text NOT NULL,
			  UNIQUE KEY id (id)
			) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}

		/**
		 * @introduced: 2.7.8
		 * @migration-type: alter inbound_events table
		 * @mirgration: adds columns list_id funnel, and source to events table
		 */
		public static function add_list_id_to_events_table() {

			/* ignore if not applicable */
			$previous_installed_version = get_transient('cta_current_version');

			if ( version_compare($previous_installed_version , "2.7.8") === 1 )  {
				return;
			}

			global $wpdb;

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$table_name = $wpdb->prefix . "inbound_events";

			/* add columns funnel and source to legacy table */
			$row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$table_name}' AND column_name = 'source'"  );
			if(empty($row)){
				// do your stuff
				$wpdb->get_results( "ALTER TABLE {$table_name} ADD `funnel` text NOT NULL" );
				$wpdb->get_results( "ALTER TABLE {$table_name} ADD `source` text NOT NULL" );
			}

			/* add columns list_id inbound events table */
			$row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$table_name}' AND column_name = 'list_id'"  );
			if(empty($row)){
				$wpdb->get_results( "ALTER TABLE {$table_name} ADD `list_id` mediumint(20) NOT NULL" );
			}
		}

	}

}