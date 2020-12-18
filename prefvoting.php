<?php
/**
 * @package PrefVoitinhg
*/
/*
Plugin Name: Preferential Voting
Plugin URI: https://github.com/utopszkij/prefvoting/
Description: Preferential voiting system by Condorce - Shilcze processing
Version: 1.0.0
Author: Fogler Tibor
Author URI: https://gtihub.com/utopszkij
License: GPLv2 or later
Text Domain: prefvoting
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
* SEO frind URL kezelés   kezelt url: site_url/prefv/task-p1-p2
* FIGYELEM az admin felületen is be kell állítani !!!!!! közvetlen hivatkozások: kategóra : prefv
*/
function prefvoting_rewrite_rule() {
	    add_rewrite_rule(
	        '^prefv/([^/]*)/?',
	        'index.php?pagename=prefvoting&state=$matches[1]',
	        'top'
	    );
}
add_action( 'init', 'prefvoting_rewrite_rule' );    


define ('PREFVOTING','prefvoting');
global $prefVoting;
include_once __DIR__.'/controllers/class.prefvoting.php';
$prefVoting = new PrefVotingController();


function activate_prefvoting() {
	global $wpdb, $prefVoting;
    $prefvoting = new PrefvotingController();
	$prefVoting->model->createTablesIfNotExists();
	$w = $prefVoting->model->getRooterPage();
	if (!$w)  {
		$prefVoting->model->createRooterPage();
	}
}
register_activation_hook( __FILE__, 'activate_prefvoting' );


function deactivate_prefvoting() {
}
register_deactivation_hook( __FILE__, 'deactivate_prefvoting' );


/**
 * init plugin
 */ 
function prefvoting_init() {
    global $prefvoting;
    $prefvoting = new PrefvotingController();

	/*
	 * verzió infók lekérése a github -ról	
	 * $res empty at this step
	 * $action 'plugin_information'
	 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
	 */
	function prefvoting_plugin_info( $res, $action, $args ){
		global $prefvoting;
		// do nothing if this is not about getting plugin information
		if( 'plugin_information' !== $action ) {
			return false;
		}
		$plugin_slug = $prefvoting->pluginName; 
		if( $plugin_slug !== $args->slug ) {
			return false;
		}
		$remote = $prefvoting->getFromGithub();
		
		if( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
			$remote = json_decode( $remote['body'] );
			$res = new stdClass();
			$res->name = $remote->info->name;
			$res->slug = $plugin_slug;
			$res->version = $remote->new_version;
			$res->tested = $remote->info->tested;
			$res->requires = $remote->info->requires;
			$res->author = $remote->info->author;
			$res->author_profile = $remote->info->author_profile;
			$res->download_link = $remote->package;
			$res->trunk = $remote->package;
			$res->requires_php = '5.3';
			$res->last_updated = $remote->info->last_updated;
			$res->sections = array(
				'description' => $remote->info->sections->description,
				'installation' => $remote->info->sections->installation,
				'changelog' => $remote->info->sections->changelog
			);
			if( !empty( $remote->info->sections->screenshots ) ) {
				$res->sections['screenshots'] = $remote->info->sections->screenshots;
			}
			return $res;
		}
		return false;
	}
	add_filter('plugins_api', 'prefvoting_plugin_info', 20, 3);

	/**
	* plugin auto updater hook
	*/	
	function prefvoting_push_update( $transient ){
		global $prefvoting;
		if ( empty($transient->checked ) ) {
	            return $transient;
        }
		$remote = $prefvoting->getFromGithub();
		if( $remote ) {
			$remote = json_decode( $remote['body'] );
			if (isset($remote->new_version)) {
				$pluginData = get_plugin_data( __FILE__ );
				$actVersion = $pluginData['Version'];			
				if( $remote && version_compare( $actVersion, $remote->new_version, '<' ) && 
					version_compare($remote->info->requires, get_bloginfo('version'), '<' ) ) {
					$res = new stdClass();
					$res->slug = $prefvoting->pluginName;
					$res->plugin = $prefvoting->pluginName.'/'.$prefvoting->pluginName.'.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
					$res->new_version = $remote->new_version;
					$res->tested = $remote->info->tested;
					$res->package = $remote->package;
		           	$transient->response[$res->plugin] = $res;
		        }
	    	}
		}
        return $transient;
	}
	add_filter('site_transient_update_plugins', 'prefvoting_push_update' );
	
	// set plugin setup form
	function prefvoting_options_page() {
		global $prefVoting;
		$prefVoting->optionsForm();
	}
	function prefvoting_register_options_page() {
	  add_options_page('Pref.voting', __('prefvoting',PREFVOTING), 'manage_options', 'prefvoting', 'prefvoting_options_page');
	}
	add_action('admin_menu', 'prefvoting_register_options_page');

	// admin menü
	function prefvoting_adminMenu() {
		echo prefvoting_list(["group_id" => "all"]);
	}
	function prefvoting_plugin_create_menu() {
		add_menu_page('prefvoting' , __('prefvoting', PREFVOTING),'manage_options',
	   	         'prefvoting-admin','prefvoting_adminMenu','', 71 );
	}
	add_action('admin_menu', 'prefvoting_plugin_create_menu');


	// short kodok
	add_shortcode('prefvoting', 'prefvoting_rooter');
	add_shortcode('prefvoting_list', 'prefvoting_list');
	add_shortcode('prefvoting_create_vote','prefvoting_create_vote');
	add_shortcode('prefvoting_edit_vote','prefvoting_edit_vote');
	add_shortcode('prefvoting_vote_form','prefvoting_vote_form');
	add_shortcode('prefvotingí_result', 'prefvoting_result');
	
	// multlanguage , css, js
    load_plugin_textdomain( 'prefvoting', false, basename( dirname( __FILE__ ) ) . '/langs' );
    wp_enqueue_style( 'style', plugins_url().'/assets/css/prefvoting.css');
    wp_enqueue_script( 'prefvoting_js', plugins_url( '/assets/js/prefvoting.js', __FILE__ ));
    
}
add_action('init','prefvoting_init');

// =================
// globális funkciók
// =================

/**
* plugin rooter a hivás URL alapján hiv be egy másik globális funkciót, vagy menüt jelenit meg.
* a $_SERVER['REQUEST_URI'] -ból emelhetők ki a paraméterek
* @param array $atts []
* @return string html string
*/
function prefvoting_rooter($atts=[]): string {
	$w = explode('/', $_SERVER['REQUEST_URI']);
	if (count($w) < 2) {
		return '';	
	}
	$params = explode('-', $w[count($w) - 2]);
	$params[] = '';
	$params[] = '';
	$result = 'prefvotin error invalid url param';
	switch ($params[0]) {
   		case 'list':
   			$result = prefvoting_list(["group_id" => $params[1], "status"=> $params[2]]);
	        break;
   		case 'create':
   			$result = prefvoting_create_vote(["group_id" => $params[1]]);
	        break;
   		case 'edit':
   			$result = prefvoting_edit_vote(["vote_id" => $params[1]]);
	        break;
   		case 'form':
   			$result = prefvoting_vote_form(["vote_id" => $params[1]]);
	        break;
   		case 'result':
   			$result = prefvoting_result(["vote_id" => $params[1]]);
	        break;
	}
	return $result;
} 

/**
* szavazások listája
* @param array $atts ["group_id" => #, "state" => "xxx"]
* @return string html string
*/
function prefvoting_list($atts = []): string {
	return '<p>szavazások listája</p>';
} 

/**
* szavazás létrehozása képernyő
* @param array $atts ["group_id" => #]
* @return string html string
*/
function prefvoting_create_vote($atts=[]): string {
	return '<p>szavazás felvitel form</p>';
} 

/**
* szavazás modosítása
* @param array $atts ["vote_id" => #]
* @return string html string
*/
function prefvoting_edit_vote($atts=[]): string {
	return '<p>szavazás edit form</p>';
} 

/**
* szavazö képernyő
* @param array $atts ["vote_id" => #]
* @return string html string
*/
function prefvoting_vote_form($atts=[]): string {
	return '<p>szavazó form</p>';
} 

/**
* szavazás eredmény képernyő
* @param array $atts ["vote_id" => #]
* @return string html string
*/
function prefvoting_result($atts=[]): string {
	return '<p>szavazás eredménye</p>';
} 

?>
