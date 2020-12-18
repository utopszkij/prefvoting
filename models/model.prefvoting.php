<?php
class PrefvotingModel {

	public function createTablesIfNotExists() {
		global $wpdb;
		if (!$wpdb->query('
		create table if not exists '.$wpdb->prefix.'prefvoting_votes (
		  	id int(11) PRIMARY KEY AUTO_INCREMENT,
			title varchar(255),
			description text,
			gropup_id int(11),
			creator_id int(11),
			created_by datetime,
			`status` varchar(32),
			status_comment varchar(128),
			voks_type varchar(32),
			deadline1 datetime,
			min_like_count int(11),
			deadline2 datetime,
			min_alt_like_count int(11),
			deadline3 datetime,
			can_view varchar(32),
			can_voks varchar(32),
			can_like varchar(32),
			can_add_alternative varchar(32),
			can_like_alternative varchar(32),
			can_get_result varchar(32),
			sub_result int(1),
			secret int(1),
			valid int(11),
			valid_type varchar(32),
			success int(11),
			success_type varchar(32),
			result text		  
		)
		')) {
			echo '<p>Fatal error '.$wpdb->last_error.'</p>'; exit();		
		}

		if (!$wpdb->query('
		create table if not exists '.$wpdb->prefix.'prefvoting_likes (
		  	id int(11) PRIMARY KEY AUTO_INCREMENT,
		  	vote_id int(11),
		  	alt_id int(11),
		  	user_id int(11),
		  	like_date datetime
		)
		')) {
			echo '<p>Fatal error '.$wpdb->last_error.'</p>'; exit();		
		}
		
		if (!$wpdb->query('
		create table if not exists '.$wpdb->prefix.'prefvoting_alternatives (
		  	id int(11) PRIMARY KEY AUTO_INCREMENT,
		  	vote_id int(11),
		  	title varchar(255),
		  	description text,
		  	`status` varchar(32),
		  	creator int(11),
		  	created_by datetime
		)
		')) {
			echo '<p>Fatal error '.$wpdb->last_error.'</p>'; exit();		
		}

		if (!$wpdb->query('
		create table if not exists '.$wpdb->prefix.'prefvoting_vokses (
		  	id int(11) PRIMARY KEY AUTO_INCREMENT,
		  	vote_id int(11),
		  	alt_id int(11),
		  	position int(11),
		  	`code` varchar(128),
		  	user_id int(11)
		)
		')) {
			echo '<p>Fatal error '.$wpdb->last_error.'</p>'; exit();		
		}

		if (!$wpdb->query('
		create table if not exists '.$wpdb->prefix.'prefvoting_voters (
		  	id int(11) PRIMARY KEY AUTO_INCREMENT,
			vote_id int(11),
			user_id int(11),
			voks_time datetime 	
		)
		')) {
			echo '<p>Fatal error '.$wpdb->last_error.'</p>'; exit();		
		}
		

		if (!$wpdb->query('
		create table if not exists '.$wpdb->prefix.'prefvoting_setup (
		  	id int(11) PRIMARY KEY AUTO_INCREMENT,
			group_type varchar(32),
			min_like_count varchar(32),
			min_alt_like_count varchar(32)		  	
		)
		')) {
			echo '<p>Fatal error '.$wpdb->last_error.'</p>'; exit();		
		}
		
		if (!$wpdb->query('
		create table if not exists '.$wpdb->prefix.'prefvoting_log (
		  	id int(11) PRIMARY KEY AUTO_INCREMENT,
			action varchar(32),
			action_by datetime,
			vote_id int(11),
			alt_id int(11),
			user_id int(11)		  	
		)
		')) {
			echo '<p>Fatal error '.$wpdb->last_error.'</p>'; exit();		
		}
		
	}
	
	/**
	* rooter page beolvasása
	* @return object vagy false
	*/
	public function getRooterPage() {
		global $wpdb;
		$w = $wpdb->get_results('select * from '.$wpdb->prefix.'posts where post_status="publish" and post_name="prefvoting"');
		if (count($w) >= 1) {
			$result = $w[0];		
		} else {
			$result = false;
		}
		return $result;
	}
	
	/**
	* rooter page létrehozása
	*/
	public function createRooterPage() {
		wp_insert_post(["post_type" => "page",
		"post_name" => "prefvoting",
		"post_status" => "publish",
		"post_title" => __("prefvoting",PREFVOTING),
		"post_content" => "<p>[prefvoting]</p>"
		]);	
	} 
}
?>