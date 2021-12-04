<?php
session_start();

require 'Vendor/App/SplLoader.php';
SplLoader::register();

$router = new \Vendor\App\Router();
$router->getController();
