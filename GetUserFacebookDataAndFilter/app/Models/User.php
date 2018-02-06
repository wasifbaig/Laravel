<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';


    /**
     * 1-M relationship with posts.
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }


}