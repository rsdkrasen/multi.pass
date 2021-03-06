<?php

	/***
	***	@Add button in cover
	***/
	add_action('um_cover_area_content', 'um_friends_add_button');
	function um_friends_add_button( $user_id ) {
		global $um_friends;
		echo '<div class="um-friends-coverbtn">' . $um_friends->api->friend_button( $user_id, get_current_user_id() ) . '</div>';
	}
	
	/***
	***	@Add button in case that cover is disabled
	***/
	add_action('um_after_profile_header_name_args', 'um_friends_add_button_nocover', 90, 1 );
	function um_friends_add_button_nocover( $args ) {
		global $um_friends;
		$user_id = um_profile_id();
		if ( $args['cover_enabled'] != 1 ) {
			echo '<div class="um-friends-nocoverbtn" style="display: block">' . $um_friends->api->friend_button( $user_id, get_current_user_id() ) . '</div>';
		} else {
			echo '<div class="um-friends-nocoverbtn" style="display: none">' . $um_friends->api->friend_button( $user_id, get_current_user_id() ) . '</div>';
		}
	}
	
	/***
	***	@Add friendship state
	***/
	add_action('um_after_profile_name_inline', 'um_friends_add_state', 200 );
	function um_friends_add_state( $args ) {
		global $um_friends;

		if ( !is_user_logged_in() || !um_profile_id() )
			return;

		if ( get_current_user_id() == um_profile_id() )
			return;

		if ( $um_friends->api->is_friend( get_current_user_id(), um_profile_id() ) ) {
			echo '<span class="um-friend-you"></span>';
		}

	}

	/***
	***	@friends List
	***/
	add_action('um_profile_content_friends_default', 'um_profile_content_friends_default');
	add_action('um_profile_content_friends_myfriends', 'um_profile_content_friends_default');
	function um_profile_content_friends_default( $args ) {
		echo do_shortcode('[ultimatemember_friends user_id='.um_profile_id().']');
	}
	
	/***
	***	@friend requests List
	***/
	add_action('um_profile_content_friends_friendreqs', 'um_profile_content_friends_friendreqs');
	function um_profile_content_friends_friendreqs( $args ) {
		echo do_shortcode('[ultimatemember_friend_reqs user_id='.um_profile_id().']');
	}
	
	/***
	***	@friend requests sent List
	***/
	add_action('um_profile_content_friends_sentreqs', 'um_profile_content_friends_sentreqs');
	function um_profile_content_friends_sentreqs( $args ) {
		echo do_shortcode('[ultimatemember_friend_reqs_sent user_id='.um_profile_id().']');
	}

	/***
	***	@customize the nav bar
	***/
	//add_action('um_profile_navbar', 'um_friends_add_profile_bar', 4 );
	function um_friends_add_profile_bar( $args ) {
		echo do_shortcode('[ultimatemember_friends_bar user_id='.um_profile_id().']');
	}