<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "cases";
    protected $primaryKey = "caseid";

    public function notes()
    {
        return $this->hasMany(Note::class, 'parentid');
    }

    public function messages()
    {
        return $this->hasMany(CasePost::class, 'caseid')->where('casepost', '=', 'case.message')->with('messages');
    }
}
