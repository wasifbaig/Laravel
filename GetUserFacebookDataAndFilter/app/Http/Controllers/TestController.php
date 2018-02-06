<?php
/**
 * Created by PhpStorm.
 * User: wasif baig
 * Date: 21/12/2017
 * Time: 17:53
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FacebookController;
use App\Models\User;
use App\Models\UserAccount;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Userlike;
use App\Models\Cronrun;
use Faker\Provider\DateTime;
use Carbon\Carbon;



class TestController extends Controller
{


    protected $fbController;
    protected $userModel;
    protected $userAccountModel;

    function __construct(FacebookController $fbController) {

          if(!session_id()) {
            session_start();
        }

        $this->fbController = $fbController;
        $this->userModel = new User();
        $this->userAccountModel = new UserAccount();
        $this->postModel = new Post();

        ## 1 is constant user id
        if( !isset($_SESSION['user']) ) {
            $userObject = $this->userModel->find(1);
            $_SESSION['user'] = $userObject;
        }


    }


    /**
     * Login page
     *
     *
     */

    public function login()
    {

       $ret = $this->fbController->login();

        return view('test.login', $ret);

    }


    /**
     * Cronjob
     *
     * @return void
     */

    public function CronJob()
    {

        $userObj = isset($_SESSION['user']) ? $_SESSION['user']->toArray() : [];



        if( !isset($_SESSION['accessToken']) ) {

            $userAccount = $this->userAccountModel->where('user_id',$_SESSION['user']->id)->first()->toArray();

            if( !empty($userAccount) )
            {
                $_SESSION['accessToken'] = $userAccount['access_token'];
            }

        }


        // get last cron run time
        $cron = Cronrun::where('id',Cronrun::max('id'))->first();
        $since = ($cron == null) ? strtotime("1/1/2017") : strtotime($cron->time);
        $until = date('Y-m-d H:i:s');

        $until_timestamp = strtotime($until);
        $url = "/me?fields=posts.until($until_timestamp).since($since){likes,comments,created_time,caption,picture}";



        // do while loop
        do
        {

            $fbData = $this->fbController->getData($url);
            $facebookData = $fbData->getDecodedBody();


            if( isset($facebookData['posts']['data']) ) {

                foreach ($facebookData['posts']['data'] as $post) {

                    $postModel = new Post();
                    list($rest,$post_id) = explode("_", $post['id']);
                    $post_id = (int)$post_id;

                    $postModel = $postModel->find($post_id);

                    // object exists
                    if( $postModel != null)
                    {
                        $postModel->amount_likes += isset($post['likes']['data']) ? count($post['likes']['data']) : 0;
                        $postModel->amount_comments += isset($post['comments']['data']) ? count($post['comments']['data']) : 0;
                    }
                    else
                    {
                        $postModel = new Post();
                        $postModel->amount_likes = isset($post['likes']['data']) ? count($post['likes']['data']) : 0;
                        $postModel->amount_comments = isset($post['comments']['data']) ? count($post['comments']['data']) : 0;
                    }

                    $postModel->post_date = new Carbon($post['created_time']);
                    $postModel->id = $post_id;
                    $postModel->url_image = $post['picture'] ?? '';
                    $postModel->caption = $post['caption'] ?? '';
                    $postModel->user_id = $userObj['id'];


                    // save post data
                    $postModel->save();


                    if (isset($post['comments']['data'])) {
                        $commentsArray = array();
                        foreach ($post['comments']['data'] as $comment) {

                            $commentModel = new Comment();
                            $commentModel->channel_user_id = $comment['from']['id'];
                            $commentModel->name = $comment['from']['name'];
                            $commentModel->message = $comment['message'];
                            $commentModel->created_time = date('Y-m-d H:i:s', strtotime($comment['created_time'] ?? ''));
                            $commentModel->post_id = $post_id;

                            //array_push($commentsArray, $commentModel);
                            // save comments data
                            $commentModel->save();
                        }

                        // save comments data
                        //$commentModel->comments()->saveMany($commentsArray);
                    }


                    if (isset($post['likes']['data'])) {
                        $userLikesArray = array();
                        foreach ($post['likes']['data'] as $like) {

                            $userlikeModel = new Userlike();
                            $userlikeModel->channel_user_id = $like['id'];
                            $userlikeModel->name = $like['name'];
                            $userlikeModel->post_id = $post_id;

                            $userlikeModel->save();
                            //array_push($userLikesArray, $userlikeModel);
                        }


                        // save userlikes data
                        //$postModel->userlikes()->saveMany($userLikesArray);
                    }


                } //end foreach


                $url = str_replace('https://graph.facebook.com/v2.11','',$facebookData['posts']['paging']['next']);
            }

        }while( isset($facebookData['posts']['data']) );



        // update cron
        Cronrun::insert(['time'=>$until]);

        return view('test.cronjob',['updatedData'=>$facebookData]);


    }

    /**
     * Filterdata API CALL
     *
     * $_REQUEST expected
     * @return json
     */

    public function filterData()
    {

        $data = [];
        if( count($_REQUEST) > 0 ) {
            $userObj = isset($_SESSION['user']) ? $_SESSION['user'] : [];
            $data = $this->postModel->filter($userObj->id, $_REQUEST);

            foreach ($data as $key => $postObj) {
                $data[$key]['comments'] = $postObj->comments->toArray();
                $data[$key]['userlikes'] = $postObj->userlikes->toArray();
            }
        }

       return json_encode($data->toArray());

    }




}