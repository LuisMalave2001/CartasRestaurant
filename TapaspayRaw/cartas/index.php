<?php

	// Controllers

use cartas\CartasController;
use homepage\HomepageController;
use menus\MenusController;
use product\ProductController;

require_once('../controllers/homepage_controller.php');
require_once('../controllers/cartas_controller.php');
require_once('../controllers/menus_controller.php');
require_once('../controllers/product_controller.php');

	$uri_with_project_name = $_SERVER['REQUEST_URI'];
	$project_name = 'cartas';
	$uri = preg_replace("/^(\/$project_name\/)/", '/', $uri_with_project_name);

	switch($uri){
		case '/':
			new HomepageController($uri);
		break;
		case '/cartas':
			new CartasController($uri);
		break;
		case '/menus':
			new MenusController($uri);
		break;
		case preg_match('/^\/(product)(((\/)?|\/[0-9]+))$/', $uri) !== false:
			new ProductController($uri);
		break;
	};

?>