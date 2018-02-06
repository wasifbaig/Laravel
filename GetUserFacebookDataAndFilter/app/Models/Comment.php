<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\elementType;

class Comment extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_comments';


    protected $fillable  = array('post_id','channel_user_id', 'name','message','created_time');




}
