<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * TestController
 * 
 * @version    1.0
 * @deprecated 1.0
 */
class TestController extends Controller {

	public function test($string) {
		$defaultManager = new \Manager\DefaultManager();
		$test = $defaultManager->countRows($string);
		// print_r($test);
		echo $test;
    }
}