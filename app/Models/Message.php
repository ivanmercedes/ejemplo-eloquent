<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "casemessages";
    protected $primaryKey = "casemessageid";

    public function case_post()
    {
        return $this->hasOne(CasePost::class, 'casepostuuid', 'uuid')->with('messages', 'case');
    }

    public function ticket()
    {
        return $this->hasOne(CasePost::class, 'casepostuuid', 'uuid')->with('case');
    }
}
