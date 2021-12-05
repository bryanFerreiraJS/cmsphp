<?php
namespace Core;

use App\Router;

class Core {

    public function run(){
        $route = Router::get($_SERVER["REQUEST_URI"]);
        if ($route !== null) {
            $controller = "src\Controller\\" . ucfirst($route["controller"])
             . "Controller";
            $method = $route["action"] . "Action";
            $obj = new $controller();
            $obj->$method();
        }
        else {
            require("src/View/Error/404.php");
        }
    }
}
