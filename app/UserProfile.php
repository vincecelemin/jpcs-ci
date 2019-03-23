<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function getFullName($withSalutation = false)
    {
        return ($withSalutation ? $this->salutation . ' ' : '') . $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }
}
