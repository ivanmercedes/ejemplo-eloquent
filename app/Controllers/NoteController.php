<?php

namespace App\Controllers;

use App\Models\Note;

class NoteController extends BaseController
{
    public function getIndex()
    {
        $notes = Note::orderBy('noteid', 'desc')->limit(10)->get();

        return $this->json($notes);
    }
}
