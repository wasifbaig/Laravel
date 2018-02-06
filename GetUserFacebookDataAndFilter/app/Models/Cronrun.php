<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\elementType;

class Cronrun extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cron_run';


    protected $fillable  = array('time');




}
