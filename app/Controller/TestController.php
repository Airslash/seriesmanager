<?php

namespace Controller;

use \W\Controller\Controller;

class TestController extends Controller {

	public function test($string) {
		$defaultManager = new \Manager\DefaultManager();
		$test = $defaultManager->countRows($string);
		// print_r($test);
		echo $test;
    }
}