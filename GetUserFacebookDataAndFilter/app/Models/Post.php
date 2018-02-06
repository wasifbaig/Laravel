<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\elementType;
use Carbon\Carbon;


class Post extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';



    /**
     * 1-M relationship with posts.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }


    /**
     * 1-M relationship with posts.
     */
    public function userlikes()
    {
        return $this->hasMany('App\Models\Userlike');
    }



    public function store($user,$accessToken)
    {
        $res = $this->where('user_id',$user['id'])->first();



        if(empty($res))
        {
            $this->user_id = $user['id'];
            $this->access_token = $accessToken;
            $this->save();

        }
        else
        {
            $res->access_token = $accessToken;
            $res->save();
        }


    }


    public function filter($userId,$filter)
    {

        $query = $this->where('user_id',$userId);


        if( !empty($filter['fromDate']) and !empty($filter['toDate']) )
            $query->whereBetween('created_at', array($filter['fromDate'],$filter['toDate']));

        if( !empty($filter['sortingField']) and !empty($filter['sortingOrder']) )
            $query->orderBy($filter['sortingField'], $filter['sortingOrder']);


        return $query->get();

    }


}
