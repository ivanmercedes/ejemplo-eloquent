<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CasePost extends Model
{
    protected $table = "caseposts";
    protected $primaryKey = "casepostid";


    public function messages()
    {
        return $this->hasOne(Message::class, 'uuid', 'casepostuuid')->orderBy('updatedat', 'desc');
    }

    public function case()
    {
        return $this->belongsTo(Ticket::class, 'caseid', 'caseid');
    }
}
