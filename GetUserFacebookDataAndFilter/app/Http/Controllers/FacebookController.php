<?php
/**
 * Created by PhpStorm.
 * User: wasif baig
 * Date: 21/12/2017
 * Time: 17:53
 */

namespace App\Http\Controllers;

use App\Models\UserAccount;


class FacebookController
{

    protected $fb;
    protected $userAccountModel;


    function __construct() {


        if(!session_id()) {
            session_start();
        }
        $this->fb = new \Facebook\Facebook([
            'app_id' =>  env('FB_API_ID'),
            'app_secret' => env('FB_APP_SECRET'),
            'default_graph_version' => 'v2.11',
            'persistent_data_handler'=>'session'
        ]);

        $this->userAccountModel = new UserAccount();


    }

    /**
     * Create facebook Login link
     *
     */

    public function login()
    {

        $data = array('loginUrl'=>'');

        if( !isset($_SESSION['accessToken']) || empty($_SESSION['accessToken'])  )
        {
            $helper = $this->fb->getRedirectLoginHelper();

            $permissions = ['user_posts']; // Optional permissions
            $loginUrl = $helper->getLoginUrl('http://localhost:8000/logincallback',$permissions);

            $data['loginUrl'] = htmlspecialchars($loginUrl);

        }

        return $data;

    }


    /**
     * facebook login callback
     *
     *
     */

    public function loginCallback()
    {


        if( !isset($_SESSION['accessToken']) ) {



            $helper = $this->fb->getRedirectLoginHelper();
            $_SESSION['FBRLH_state'] = $_GET['state'];


            try {
                $accessToken = $helper->getAccessToken();
                $_SESSION['accessToken'] = $accessToken;

            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            if (!isset($accessToken)) {
                if ($helper->getError()) {
                    header('HTTP/1.0 401 Unauthorized');
                    echo "Error: " . $helper->getError() . "\n";
                    echo "Error Code: " . $helper->getErrorCode() . "\n";
                    echo "Error Reason: " . $helper->getErrorReason() . "\n";
                    echo "Error Description: " . $helper->getErrorDescription() . "\n";
                } else {
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Bad request';
                }
                exit;
            }
            else
            {
                $this->userAccountModel->store($_SESSION['user'],$accessToken);

            }



        }


        return redirect('login');


    }



    /**
     * Fetch data from facebook
     *
     * @param string $url
     * @return object
     */


    public function getData($url)
    {


        if( isset($_SESSION['accessToken']) && !empty($_SESSION['accessToken'])  )
        {

            $accessToken = $_SESSION['accessToken'];

            try {


                // Returns a `Facebook\FacebookResponse` object
                 $response = $this->fb->get($url, $accessToken);


            } catch(Facebook\Exceptions\FacebookResponseException $e) {

                unset($_SESSION['accessToken']);
                return redirect('login');

            } catch(Facebook\Exceptions\FacebookSDKException $e) {

                unset($_SESSION['accessToken']);
                return redirect('login');

            }


            return $response;


        }


    }

}