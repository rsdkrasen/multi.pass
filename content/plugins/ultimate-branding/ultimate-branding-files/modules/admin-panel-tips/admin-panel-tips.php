<?php
/*
Plugin Name: Admin Panel Tips
Description: Provide your users with helpful random tips (or promotions/news) in their admin panels.

Copyright 2007-2017 Incsub (http://incsub.com)
Author - S H Mohanjith
Contributors - Ivan Shaovchev, Andrew Billits, Aaron Edwards, Marcin Pietrzak

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if ( ! class_exists( 'ub_admin_panel_tips' ) ) {
	class ub_admin_panel_tips {

		private $admin_url = '';
		private $post_type = 'admin_panel_tip';
		private $meta_field_name = '_ub_page';

		public function __construct() {
			$this->admin_url = add_query_arg(
				array(
					'page' => 'branding',
					'tab' => 'admin-panel-tips',
				),
				is_network_admin()? network_admin_url( 'admin.php' ): admin_url( 'admin.php' )
			);
			add_action( 'save_post', array( $this, 'save_post' ), 10, 3 );
			add_action( 'admin_notices', array( $this, 'output' ) );
			add_action( 'profile_personal_options', array( $this, 'profile_option_output' ) );
			add_action( 'personal_options_update', array( $this, 'profile_option_update' ) );
			add_action( 'wp_ajax_ub_admin_panel_tips', array( $this, 'ajax' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'ultimatebranding_settings_admin_panel_tips', array( $this, 'manage_output' ) );
			add_filter( 'ultimatebranding_settings_admin_panel_tips_process', array( $this, 'process' ) );
			add_action( 'init', array( $this, 'custom_post_type' ), 0 );
		}

		public function custom_post_type() {
			if ( ! is_admin() ) {
				return;
			}
			$labels = array(
				'name'                  => _x( 'Tips', 'Tip General Name', 'ub' ),
				'singular_name'         => _x( 'Tip', 'Tip Singular Name', 'ub' ),
				'menu_name'             => __( 'Tips', 'ub' ),
				'name_admin_bar'        => __( 'Tip', 'ub' ),
				'archives'              => __( 'Tip Archives', 'ub' ),
				'attributes'            => __( 'Tip Attributes', 'ub' ),
				'parent_item_colon'     => __( 'Parent Tip:', 'ub' ),
				'all_items'             => __( 'Tips', 'ub' ),
				'add_new_item'          => __( 'Add New Tip', 'ub' ),
				'add_new'               => __( 'Add New', 'ub' ),
				'new_item'              => __( 'New Tip', 'ub' ),
				'edit_item'             => __( 'Edit Tip', 'ub' ),
				'update_item'           => __( 'Update Tip', 'ub' ),
				'view_item'             => __( 'View Tip', 'ub' ),
				'view_items'            => __( 'View Tips', 'ub' ),
				'search_items'          => __( 'Search Tip', 'ub' ),
				'not_found'             => __( 'Not found', 'ub' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'ub' ),
				'featured_image'        => __( 'Featured Image', 'ub' ),
				'set_featured_image'    => __( 'Set featured image', 'ub' ),
				'remove_featured_image' => __( 'Remove featured image', 'ub' ),
				'use_featured_image'    => __( 'Use as featured image', 'ub' ),
				'insert_into_item'      => __( 'Insert into item', 'ub' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'ub' ),
				'items_list'            => __( 'Tips list', 'ub' ),
				'items_list_navigation' => __( 'Tips list navigation', 'ub' ),
				'filter_items_list'     => __( 'Filter items list', 'ub' ),
			);
			$args = array(
				'label'                 => __( 'Admin Panel Tips', 'ub' ),
				'description'           => __( 'Tip Description', 'ub' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor' ),
				'hierarchical'          => false,
				'public'                => false,
				'show_ui'               => true,
				'show_in_menu'          => 'branding',
				'show_in_admin_bar'     => false,
				'can_export'            => true,
				'has_archive'           => false,
				'exclude_from_search'   => false,
				'publicly_queryable'    => false,
			);
			register_post_type( $this->post_type, $args );
		}

		public function ajax() {
			$keys = array( 'what', 'nonce', 'id', 'user_id' );
			foreach ( $keys as $key ) {
				if ( ! isset( $_POST[ $key ] ) ) {
					wp_send_json_error();
				}
			}
			$nonce_action = $this->get_nonce_action( $_POST['what'], $_POST['id'], $_POST['user_id'] );
			if ( wp_verify_nonce( $_POST['nonce'], $nonce_action ) ) {
				switch ( $_POST['what'] ) {
					case 'hide':
						update_user_meta( $_POST['user_id'], 'show_tips', 'no' );
						wp_send_json_success();
					case 'dismiss':
						$dismissed_tips = get_user_meta( $_POST['user_id'], 'tips_dismissed', true, array() );
						$dismissed_tips[] = $_POST['id'];
						l( $dismissed_tips );
						update_user_meta( $_POST['user_id'], 'tips_dismissed', $dismissed_tips );
						wp_send_json_success();
				}
			}
			wp_send_json_error();
		}

		public function enqueue_scripts() {
			global $ub_version;
			wp_enqueue_style( __CLASS__, plugins_url( 'admin-panel-tips.css', __FILE__ ), array(), $ub_version );
			wp_enqueue_script( __CLASS__, plugins_url( 'admin-panel-tips.js', __FILE__ ), array( 'jquery' ), $ub_version, true );
			$data = array(
				'saving' => __( 'Saving...', 'ub' ),
			);
			wp_localize_script( __CLASS__, __CLASS__, $data );
		}

		public function profile_option_update() {
			global $user_id;
			if ( $_POST['show_tips'] != '' ) {
				update_user_meta( $user_id, 'show_tips', $_POST['show_tips'] );
			}
		}

		public function output() {
			/**
			 * avoid activate/deactivate actions
			 */
			if ( isset( $_GET['updated'] ) || isset( $_GET['activated'] ) ) {
				return;
			}
			/**
			 * do not show tips on Ultimate Branding pages.
			 */
			$screen = get_current_screen();
			if ( 'branding' == $screen->parent_base ) {
				return;
			}

			global $wpdb, $current_site, $current_user;

			//hide if turned off
			$show_tips = get_user_meta( $current_user->ID,'show_tips', true );
			if ( 'no' == $show_tips ) {
				return;
			}
			$args = array(
				'orderby' => 'rand',
				'posts_per_page' => 1,
				'post_type' => $this->post_type,
				'post_status' => 'publish',
				'post__not_in' => get_user_meta( get_current_user_id(), 'tips_dismissed', true ),
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				echo '<ul>';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					printf( '<div class="updated admin-panel-tips" data-id="%d" data-user-id="%d">', esc_attr( get_the_ID() ), esc_attr( get_current_user_id() ) );
					printf(
						'<p class="apt-action" data-what="dismiss" data-nonce="%s">[ <a href="#" >%s</a> ]</p>',
						esc_attr( wp_create_nonce( $this->get_nonce_action( 'dismiss', get_the_ID() ) ) ),
						esc_html__( 'Dismiss', 'ub' )
					);
					printf(
						'<p class="apt-action" data-what="hide" data-nonce="%s">[ <a href="#" >%s</a> ]</p>',
						esc_attr( wp_create_nonce( $this->get_nonce_action( 'hide', get_the_ID() ) ) ),
						esc_html__( 'Hide', 'ub' )
					);

					$title = get_the_title();
					if ( ! empty( $title ) ) {
						printf( '<h4>%s</h4>', apply_filters( 'the_title', $title ) );
					}
					$content = get_the_content();
					if ( ! empty( $content ) ) {
						printf( '<div class="apt-content">%s</div>', apply_filters( 'the_content', $content ) );
					}
					echo '</div>';
				}
				wp_reset_postdata();
			}
		}

		public function profile_option_output() {
			global $user_id;
			$show_tips = get_user_meta( $user_id,'show_tips', true );
?>
    <h3><?php _e( 'Tips', 'ub' ) ?></h3>
    <table class="form-table">
    <tr>
        <th><label for="show_tips"><?php _e( 'Show Tips', 'ub' ) ?></label></th>
        <td>
            <select name="show_tips" id="show_tips">
                <option value="yes" <?php if ( $show_tips == '' || $show_tips == 'yes' ) { echo 'selected="selected"'; } ?> ><?php _e( 'Yes', 'ub' ); ?></option>
                <option value="no" <?php if ( $show_tips == 'no' ) { echo 'selected="selected"'; } ?> ><?php _e( 'No', 'ub' ); ?></option>
            </select>
        </td>
    </tr>
    </table>
<?php
		}

		public function manage_output() {
			echo wpautop( __( 'Please go to site admin and add some tips.', 'ub' ) );
		}

		private function get_nonce_action( $what, $id, $user_id = false ) {
			if ( false == $user_id ) {
				$user_id = get_current_user_id();
			}
			$action = sprintf( '%s_%s_%d_%d', __CLASS__, $what, $id, $user_id );
			return $action;
		}

		/**
		 * save meta field
		 *
		 * @since 1.8.6
		 */
		public function save_post( $post_id, $post, $update ) {
			$post_type = get_post_type( $post_id );
			if ( $this->post_type != $post_type ) {
				return;
			}
			/**
			 * get from edit form
			 */
			$values = array();
			if ( isset( $_POST[ $this->meta_field_name ] ) ) {
				$values = $_POST[ $this->meta_field_name ];
			}
			/**
			 * sanitize defaults
			 */
			if ( empty( $values ) ) {
				$values = array( 'everywhere' );
			}
			/**
			 * get current
			 */
			$current = get_post_meta( $post_id, $this->meta_field_name );
			/**
			 * remove not saved
			 */
			foreach ( $current as $v ) {
				if ( in_array( $v, $values ) ) {
					continue;
				}
				delete_post_meta( $post_id, $this->meta_field_name, $v );
			}
			/**
			 * save new
			 */
			foreach ( $values as $v ) {
				if ( in_array( $v, $current ) ) {
					continue;
				}
				add_post_meta( $post_id, $this->meta_field_name, $v );
			}
		}
	}

}

new ub_admin_panel_tips();