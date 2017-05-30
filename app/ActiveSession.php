<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveSession extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'active_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('session_id', 'end_time', 'total_time');
}
