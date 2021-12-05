<?php


namespace Controller;


class ErrorController extends Controller
{
    public function executeNoRoute()
    {
        $this->HTTPResponse->addHeader('HTTP/1.0 404 Not Found');
        return $this->render("Error 404", [], "Error/404");
    }

    public function executeNoRouteJSON()
    {
        $this->HTTPResponse->addHeader('HTTP/1.0 404 Not Found');
        return $this->renderJSON([
            'status' => 0,
            'error' => 'Nothing found at this address'
        ]);
    }
}