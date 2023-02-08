<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "userid";

    protected $hidden  = ['password'];

    public function notes()
    {
        return $this->hasMany(Note::class, 'userid');
    }
}
