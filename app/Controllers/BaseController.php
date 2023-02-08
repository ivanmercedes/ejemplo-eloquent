<?php

namespace App\Controllers;


class BaseController
{
    protected $templateEngine;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ .'/../../views');
        $this->templateEngine = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false
        ]);
    }

    public function json($data = [], $status = 200)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        http_response_code($status);
        return json_encode($data);
    }

    public function view($fileName, $data = [])
    {
        return $this->templateEngine->render($fileName, $data);
    }
}
