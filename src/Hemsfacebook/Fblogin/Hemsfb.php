<?php

namespace Hemsfacebook\Fblogin;

class Hemsfb {

    public function __construct() {
        if (!session_id()) {
            session_start();
        }
    }

    public function loginUrl() {
        require_once __DIR__ . '\third_party\facebook\src\Facebook\autoload.php';
        $loginUrl = "#";
        try {
            $fb = new \Facebook\Facebook([
                'app_id' => \Config::get('hemsfb::appId'),
                'app_secret' => \Config::get('hemsfb::secret'),
                'default_graph_version' => 'v2.5',
            ]);

            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['email', "public_profile"]; // optional
            $loginUrl = $helper->getLoginUrl(\Config::get('hemsfb::redirect'), $permissions);
            return $loginUrl;
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error:  hemsfb package: loginUrl ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: hemsfb package: loginUrl ' . $e->getMessage();
            exit;
        }
        return $loginUrl;
    }

    public function api($param) {
        require_once __DIR__ . '\third_party\facebook\src\Facebook\autoload.php';
        $loginUrl = "#";
        try {
            $fb = new \Facebook\Facebook([
                'app_id' => \Config::get('hemsfb::appId'),
                'app_secret' => \Config::get('hemsfb::secret'),
                'default_graph_version' => 'v2.5',
            ]);

            $helper = $fb->getRedirectLoginHelper();
            try {
                $accessToken = $helper->getAccessToken();
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: hemsfb package: api 1 ' . $e->getMessage();
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: hemsfb package: api 1 ' . $e->getMessage();
                exit;
            }

            if (isset($accessToken)) {
                // Logged in!
                $_SESSION['facebook_access_token'] = (string) $accessToken;
                // Now you can redirect to another page and use the
                // access token from $_SESSION['facebook_access_token']
            }

            // Sets the default fallback access token so we don't have to pass it to each request
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            try {
                // $response = $fb->get('/me?fields=id,name,email,gender,first_name,last_name,picture');
                $response = $fb->get($param);
                $userNode = $response->getGraphUser();
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: hemsfb package: api 2 ' . $e->getMessage();
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: hemsfb package: api 2 ' . $e->getMessage();
                exit;
            }
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error:  hemsfb package: api ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: hemsfb package: api ' . $e->getMessage();
            exit;
        }
        $data["name"] = $userNode->getName();
        $data["id"] = $userNode->getId();
        $data["email"] = $userNode->getEmail();
        $data["gender"] = $userNode->getGender();
        return $data;
    }

}
