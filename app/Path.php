<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('session_id', 'url', 'loading_time');
}
