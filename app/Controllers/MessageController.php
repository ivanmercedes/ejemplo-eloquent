<?php

namespace App\Controllers;

use App\Helpers\Request;
use App\Models\Message;
use App\Models\Ticket;

class MessageController extends BaseController
{
    private string|null  $searchQuery;
    private int $page;
    private int $perPage;

    public function __construct()
    {
        $request = new Request();
        $this->searchQuery = $request->input('s');
        $this->page = $request->input('page', 1);
        $this->perPage = $request->input('per_page', 25);
    }
    public function getIndex($id = null)
    {
        $cases = $this->findByID($id) ?? $this->getAll();

        if ($this->searchQuery) {
            $cases = $this->findBySearchQuery();
        }

        return $this->json($cases);
    }


    private function findBySearchQuery()
    {
        // Buscar los mensajes que contengan la palabra clave
        $messages =  Message::query()
            ->where('text', 'LIKE', "%{$this->searchQuery}%")
            ->orWhere('subject', 'LIKE', "%{$this->searchQuery}%")
            ->orWhere('fullname', 'LIKE', "%{$this->searchQuery}%")
            ->orWhere('email', 'LIKE', "%{$this->searchQuery}%")
            ->orderBy('casemessageid', 'desc')
            ->with('ticket')
            ->limit($this->perPage)
            ->get();

        // extraer ids de los casos
        $ids = array_map(function ($message) {
            return $message['ticket']['caseid'];
        }, $messages->toArray());

        // buscar tickets por ids
        $cases = Ticket::findMany(array_values(array_unique($ids)));
        return $cases;
    }

    private function getAll()
    {
        // TODO: paginador
        return Message::orderBy('casemessageid', 'desc')
            ->with('ticket')
            ->limit($this->perPage)
            ->get();
    }
    private function findByID(int|null $id)
    {
        return Message::with('case_post')->find($id);
    }
}
