<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\elementType;

class Userlike extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_like_user_list';


    protected $fillable  = array('post_id','channel_user_id', 'name');




}
