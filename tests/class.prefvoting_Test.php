<?php

/**
 * unit test
 * use:  cd /pluginpath
 *       phpunit tests
 */
declare(strict_types=1);
include_once './tests/mock.php';
include_once './controllers/class.prefvoting.php';

use PHPUnit\Framework\TestCase;

// test Cases
class controllerPrefvotingTest extends TestCase {
	public $c;    
    
    function __construct() {
        parent::__construct();
        $this->c = new PrefVotingController();
    }
    public function test_pluginActivate() {
		$this->c->model->createTablesIfNotExists();
		$w = $this->c->model->getRooterPage();
		if (!$w)  {
			$this->c->model->createRooterPage();
		}    
        $this->assertEquals(1,1); // csak szintaktikai test
    }
    public function test_getFromGithub() {
    	$remote = $this->c->getFromGithub();
        $this->assertEquals(1,1); // csak szintaktikai test
    }
    public function test_loadTemplate_notfound() {
    	$remote = $this->c->loadTemplate('123');
        $this->expectOutputRegex('/not exists/');
    }
    public function test_loadTemplate_found() {
    	$remote = $this->c->loadTemplate('options_form',["p1" => 1]);
        $this->expectOutputRegex('/\<h1\>/');
    }
    public function test_optionsForm() {
    	$remote = $this->c->optionsForm();
        $this->expectOutputRegex('/\<h1\>/');
    }
    
    
}


