<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\elementType;

class UserAccount extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_account';


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

}
