<?php
include_once __DIR__.'/../models/model.prefvoting.php';
class PrefVotingController {
	public $pluginName = 'prefvoting';
	public $pre = 'prefvoting_';
	public $model = false;
	protected $githubInfoUrl = 'https://github.com/utopszkij/prefvoting/newver_info.json';
	protected $remote = false;	
	
	function __construct() {
		$this->model = new PrefVotingModel();
	}

	/**
	* verzió infok olvasása a github -ról (lásd github.com/utopszkij/mp3_extension/newver-info.json)
	* többször hivja a wp az admin képernyő megjelenítés közben, idő nyerés céljából ez a rutin csak egyszer olvas
	* a githubról, ismételt hivásánál a memóriba tárolt adatot adja vissza.
	* @return object
	*/
	public function getFromGithub() {
		if ($this->remote) {
			return $this->remote;		
		}
		$remote = wp_remote_get( $this->githubInfoUrl, array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);
		if ( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
			set_transient($this->pre.$this->pluginName, $remote, 43200 ); // 12 hours cache
		}
		$this->remote = $remote;
		return $remote;
	}	
	
	/**
	* template beolvasása és értelmezése
	* template értelmezés:
	* {name}  -->  <?php echo $p["name"]; ?>
	* {{$name}}  -->  <?php echo $name; ?>
	* {_('token')}  -->  <?php echo __('token', PREFVOTING); ?>
	* {if (....)}  -->  <?php if (...) : ?>
	* {else}  -->  <?php else : ?>
	* {endif}  -->  <?php endif; ?>
	* {foreach ($obj as $item)}  -->  <?php foreach (......) : ?>
	* {endforeach}  -->  <?php endforeach; ?>
	* <?php ....php code.... ?>
	* @param stringtemplate neve, utvonal és ".php" nélkül
	* @param array $p ["name" => érték, ....]
	*/	
	public function loadTemplate(string $name,  array $p = []) {
		$themeName = get_current_theme();
		$templateFile = $themeName.'/prefvoting/'.$name.'.php';
		if (!file_exists($templateFile)) {
			$templateFile = __DIR__.'/../views/'.$name.'.php';
		}
		if (file_exists($templateFile)) {
			$s = file_get_contents($templateFile);
			$s = apply_filters('prefvoting_'.$name, $s);
			$s = str_replace("{_('","<?php echo __('",$s);
			$s = str_replace("')}","',PREFVOTING); ?>",$s);
			$s = str_replace('{foreach','<?php foreach',$s);
			$s = str_replace('{endforeach}','<?php endforeach; ?>',$s);
			$s = str_replace(')}',') : ?>',$s);
			$s = str_replace('{if','<?php if',$s);
			$s = str_replace('{else}','<?php else : ?>',$s);
			$s = str_replace('{endif}','<?php endif; ?>',$s);
			$s = str_replace('{{','<?php echo ',$s);
			$s = str_replace('}}','; ?>',$s);
			$s = str_replace('{','<?php echo $p["',$s);
			$s = str_replace('}','"]; ?>',$s);
			eval('?>'.$s.'<?php ');
		} else {
			echo '<p>'.$templateFile.' not exists</p>';
		}
	}
	
	public function optionsForm() {
		$this->loadTemplate('options_form',["p1" => 11]);
	}

	
}
?>