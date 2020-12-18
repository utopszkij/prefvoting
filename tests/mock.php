<?php

define('MYSQLHOST','localhost');
define('MYSQLUSER','root');
define('MYSQLPSW','13Marika');
define('MYSQLDB','wordpress3');
define('MYSQLLOG',false);
define ('WPINC','');
$_SERVER['REQUEST_URI'] = '';

include_once __DIR__.'/database.php';
global $wpdb;

class Wpdb {
    public $last_error = '';
    public $insert_id = 0;
    public $prefix='wp_';
    public $db;
    function __construct() {
    	$this->db = new DB();
    }
    public function escape_by_ref($id) {
        return $this->db->quote($id);
    }
    public function prepare(string $s, $p1=0, $p2=0, $p3=0, $p4=0, $p5=0, $p6=0, $p7=0, $p8=0, $p9=0, $p10=0) {
    	$p1 = $this->db->quote($p1);
    	$p2 = $this->db->quote($p2);
    	$p3 = $this->db->quote($p3);
    	$p4 = $this->db->quote($p4);
    	$p5 = $this->db->quote($p5);
    	$p6 = $this->db->quote($p6);
    	$p7 = $this->db->quote($p7);
    	$p8 = $this->db->quote($p8);
    	$p9 = $this->db->quote($p9);
    	$p10 = $this->db->quote($p10);
    	return sprintf($s,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10);
    }
    public function get_results($sqlStr):array {
    	$this->db->setQuery($sqlStr);
    	$result = $this->db->loadObjectList();
    	$this->last_error = $this->db->getErrorMsg();
    	return $result;
    }
    public function query($sqlStr):bool {
    	global $mysqli;
    	$this->db->setQuery($sqlStr);
    	$result = $this->db->query();
    	$this->last_error = $this->db->getErrorMsg();
    	$this->insert_id = $mysqli->insert_id;
    	return $result;
    }
}
$wpdb = new Wpdb();

//wp functions
function get_site_url() {  return 'http://localhost/wordpress3'; }
function plugins_url() {  return 'http://localhost/wordpress3/plugins/prefvoting'; }
function get_template_directory(): string {return '';}
function get_plugin_directory(): string {return '';}
function get_current_theme() { return ''; }

function __(string $token, string $txtdomain='') { return $token; }

function load_plugin_textdomain(string $domain, bool $par, string $path) {}
function wp_enqueue_style(string $type, string $url) {}
function wp_enqueue_script($type, $url) {}


function add_action(string $hook, string $funName, int $prior=1, int $parnum=0) {}
function add_filter(string $token, string $funName, int $prior=1, int $parnum=0) {}
function apply_filters($token, $param) { return $param; }
function do_action(string $hook, $p1=0, $p2=0, $p3=0, $p4=0, $p5=0) {}
function add_shortcode(string $hook, string $funName, int $prior=1, int $parnum=0) {}

function add_rewrite_rule($preg, $redirect, $after) {}

function wp_insert_post($params): int {
	global $wpdb;
	$result = 0;
	$fields = [];
	$values = [];
	foreach ($params as $fn => $fv) {
		$fields[] = $fn;
		$values[] = $wpdb->db->quote($fv);	
	}
	$sql = 'insert into '.$wpdb->prefix.'posts ('.implode(',',$fields).')
	values ('.implode(',',$values).')';
	$wpdb->query($sql);	
	return $wpdb->inser_id;
};

function get_field(string $name, int $post_id) {
	global $wpdb;
	$result = false;
	$sql = 'select * from '.$wpdb->prefix.'postmeta 
	where post_id = '.$post_id.' and meta_key="'.$name.'"';
	$res = $wpdb->get_results($sql);
	return $res->meta_value;
}
function set_field(string $name, $value, int $post_id) {
	global $wpdb;
	$result = 0;
	$fields = ["post_id", "meta_key", "meta_value"];
	$values = [$post_id, $name, $wpdb->db->quote($value)];
	$sql = 'insert into '.$wpdb->prefix.'postmeta ('.implode(',',$fields).')
	values ('.implode(',',$values).')';
	$wpdb->query($sql);	
	return $wpdb->inser_id;
}
function maybe_serialize($objektum): string {return json_encode($objektum); }
function maybe_unserialize($str) { return json_decode($str); }

function get_option(string $name, $param=null): string {
	return 'option_'.$name;
}
function update_option(string $name, string $value) {
	return true;
}

function wp_get_current_user() { return new stdClass(); }

function add_options_page($token, $label, $token2, $name, $funName) {}
function add_menu_page($token, $label,$token2,$token3,$funName,$token4, $prior) {}

function register_activation_hook( $path, $funName) {};
function register_deactivation_hook( $path, $funName) {};

function wp_remote_get($path) { return false; }
function is_wp_error( $remote ) { return true; }


?>
