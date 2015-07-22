<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    
    /**
     * Set table name of model
     * 
     * @var string 
     */
    public $table = 'author';
    
    /**
     * Set table as not timestamped
     *
     * @var bool
     */
    public $timestamps = false;
    
}
