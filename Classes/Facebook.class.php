<?php

require_once __DIR__ . '/../vendor/autoload.php';


use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook as FB;
use Facebook\GraphNodes\GraphUser;

/**
 * https://github.com/facebook/php-graph-sdk
 * https://github.com/facebook/php-graph-sdk/blob/5.4/docs/examples/facebook_login.md
 * https://developers.facebook.com/docs/facebook-login/permission
 * https://developers.facebook.com/docs/graph-api/reference/user/
 * Class Facebook
 */
class Facebook
{
    /** @var FB */
    protected $facebook;

    public function __construct()
    {
        $this->facebook = new FB([
            'app_id' => $GLOBALS['FACEBOOK']['appId'],
            'app_secret' => $GLOBALS['FACEBOOK']['appSecret'],
            'default_graph_version' => $GLOBALS['FACEBOOK']['version'],
        ]);
    }

    /**
     * https://developers.facebook.com/docs/graph-api/reference/user/
     * @param AccessToken $token
     * @return GraphUser|null
     */
    public function getMyProfile($token)
    {
        $profile = null;
        try {
            $response = $this->facebook->get('/me/?fields=name,email,birthday,verified,first_name,last_name,gender', $token);
        } catch (FacebookResponseException $e) {
            exception_handler($e);
            return null;
        } catch (FacebookSDKException $e) {
            exception_handler($e);
            return null;
        }

        try {
            $profile = $response->getGraphUser();
        } catch (Exception $e) {
            exception_handler($e);
            return null;
        }
        return $profile;
    }

    /**
     * @param string $url
     * @return string
     */
    public function getLoginUrl($url)
    {
        $helper = $this->facebook->getRedirectLoginHelper();
        $permissions = explode(',', $GLOBALS['FACEBOOK']['scope']['login']);
        $loginUrl = $helper->getLoginUrl($url, $permissions);
        return $loginUrl;
    }

    /**
     * @param $url
     * @return AccessToken|null
     */
    public function getAccessToken($url)
    {
        $accessToken = null;
        $helper = $this->facebook->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken($url);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            exception_handler($e);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            exception_handler($e);
        } catch (Exception $e) {
            exception_handler($e);
        }
/*
        try{
            // The OAuth 2.0 client handler helps us manage access tokens
            $oAuth2Client = $this->facebook->getOAuth2Client();

            // Get the access token metadata from /debug_token
            $tokenMetadata = $oAuth2Client->debugToken($accessToken);
//            echo '<h3>Metadata</h3>';
//            var_dump($tokenMetadata);

            // Validation (these will throw FacebookSDKException's when they fail)
            $tokenMetadata->validateAppId($GLOBALS['FACEBOOK']['appId']);
            // If you know the user ID this access token belongs to, you can validate it here
            //$tokenMetadata->validateUserId('123');
            $tokenMetadata->validateExpiration();

            if (! $accessToken->isLongLived()) {
                // Exchanges a short-lived access token for a long-lived one
                try {
                    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                    exit;
                }

                echo '<h3>Long-lived</h3>';
                var_dump($accessToken->getValue());
            }

        }catch(Exception $e){

        }
*/
        return $accessToken;
    }
}