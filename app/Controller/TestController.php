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

	public function test() {
		$defaultController = new \Controller\DefaultController();
		$defaultManager    = new \Manager\DefaultManager();

		// $this->jsonShow($_POST);
		die(print_r($_POST));

		// // Gets $keyword from $_POST
		// $keyword = $_POST['keyword'];

		// // Gets $method from $_POST
		// $method = $_POST['method'];

		// // Gets $apikey from $_POST
		// $apikey = $_POST['api_key'];
    }
}