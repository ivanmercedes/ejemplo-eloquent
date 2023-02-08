<?php

namespace App\Controllers;

use App\Models\Ticket;

class CaseController extends BaseController
{
    public function getIndex($id = null)
    {
        $cases = $id ? Ticket::with([
            'messages' => function ($query) {

                return $query->orderBy('createdat', 'ASC');
            }
        ])
            ->with('notes')
            ->find($id) : Ticket::orderBy('caseid', 'desc')
            ->limit(10)
            ->get();

        return $this->json($cases);
    }
}
