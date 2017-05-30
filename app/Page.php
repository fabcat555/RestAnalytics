<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('url', 'visits');

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
