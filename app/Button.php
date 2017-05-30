<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('button_id', 'clicks');

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
