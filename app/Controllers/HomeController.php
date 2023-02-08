<?php

namespace App\Controllers;

use App\Models\Ticket;

class HomeController extends BaseController
{
    public function getIndex()
    {
        return $this->view('home.twig');
    }
}
