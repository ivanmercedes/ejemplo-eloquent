<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    public function getIndex($id = null)
    {
        $users = $id ? User::with('notes')->find($id) : User::orderBy('userid', 'desc')->limit(10)->get();

        return $this->json($users);
    }
}
