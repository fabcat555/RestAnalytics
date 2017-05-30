<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('session_id', 'ip', 'language', 'browser', 'os', 'nation', 'screen_resolution');
}
