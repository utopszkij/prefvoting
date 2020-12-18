<?php

/**
 * unit test
 * use:  cd /pluginpath
 *       phpunit tests
 */
declare(strict_types=1);
include_once './tests/mock.php';
include_once './prefvoting.php';

use PHPUnit\Framework\TestCase;

// test Cases
class prefvotingTest extends TestCase {
    
    function __construct() {
        parent::__construct();
    }
    public function test_prefvoting() {
    	prefvoting_init();
        $this->assertEquals('',''); // csak szintaktikai test
    }
    public function test_activate_prefvoting() {
    	activate_prefvoting();
        $this->assertEquals('',''); // csak szintaktikai test
    }
    public function test_deactivate_prefvoting() {
    	deactivate_prefvoting();
        $this->assertEquals('',''); // csak szintaktikai test
    }
	public function test_prefvoting_rooter() {
		prefvoting_rooter([]);
        $this->assertEquals('',''); // csak szintaktikai test
	} 
	public function test_prefvoting_list() {
		prefvoting_list([]);
        $this->assertEquals('',''); // csak szintaktikai test
	} 
	public function test_prefvoting_create_vote() {
		prefvoting_create_vote([]);
        $this->assertEquals('',''); // csak szintaktikai test
	} 
	public function test_prefvoting_edit_vote() {
		prefvoting_edit_vote([]);
        $this->assertEquals('',''); // csak szintaktikai test
	} 
	public function test_prefvoting_vote_form() {
		prefvoting_vote_form([]);
        $this->assertEquals('',''); // csak szintaktikai test
	} 
	public function test_prefvoting_result() {
		prefvoting_result([]);
        $this->assertEquals('',''); // csak szintaktikai test
	} 
    
}


