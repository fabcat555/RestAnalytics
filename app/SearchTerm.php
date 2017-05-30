<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchTerm extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'search_terms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('search_term', 'hits');

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
