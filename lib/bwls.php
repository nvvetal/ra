<?php

require_once('lib_auth.php');

function bwls($go, $action, $params)
{

    switch ($go) {
        case "register_result":
            switch ($action) {
                case "register_user":
                    require_once($GLOBALS['CLASSES_DIR'] . "User_container.class.php");
                    //require_once("captcha/recaptchalib.php");
                    require_once("captcha/recaptchalib2.php");
                    $user_container_class = new User_container($params['Validator'], $params['User']);
                    $email = @$_REQUEST['register_email'];
                    $pass = isset($_REQUEST['register_password']) ? $_REQUEST['register_password'] : '';
                    $pass2 = isset($_REQUEST['register_password2']) ? $_REQUEST['register_password2'] : '';
                    $sex = isset($_REQUEST['p_sex']) ? $_REQUEST['p_sex'] : '';

                    $u_params = array(
                        'login' => isset($_REQUEST['register_login']) ? $_REQUEST['register_login'] : '',
                        'password' => $pass,
                        'email' => $email,
                        'p_city_id' => isset($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '',
                        'p_sex' => $sex,
                    );
                    if ($pass != $pass2) {
                        $params['smarty']->assign('errors', array('register' => array('message' => 'Please set equal passwords!')));
                        add_to_log("[error pass not equals]" . prepare_array_to_log($u_params), "error_register");
                        return $go;
                    }
                    //echo "<pre>";
                    //var_dump($_POST);

                    $resp = recaptcha_verify($GLOBALS['CAPTCHA']['private'], $_SERVER["REMOTE_ADDR"], @$_POST["g-recaptcha-response"]);
                    if (!$resp) {
                        $params['smarty']->assign('errors', array('register' => array('message' => 'Wrong captcha!')));
                        add_to_log("[error wrong captcha]" . prepare_array_to_log($u_params), "error_register");
                        return $go;
                    }

                    $res = $user_container_class->call_method("register_user", $u_params);
                    if ($user_container_class->is_valid($res)) {
                        if ($res === false) {
                            $params['smarty']->assign('errors', array('register' => array('message' => 'Account already exists!')));
                            add_to_log("[error account already exists]" . prepare_array_to_log($u_params), "error_register");
                            return $go;
                        }
                        require_once($GLOBALS['CLASSES_DIR'] . 'Registrator.class.php');
                        $registrator = new Registrator($params['modules']);
                        $reg_data = $registrator->register_user($u_params);
                        foreach ($reg_data as $r_key => $r_value) {
                            $params['User']->set_value($res, $r_key, $r_value);
                        }
                        unset($u_params['login']);
                        unset($u_params['password']);
                        unset($u_params['email']);
                        $params['User']->set_values($res, $u_params);
                        $state = $GLOBALS['NEED_ACTIVATION_TO_REGISTER'] == false ? 'active' : 'not_active';
                        $params['User']->set_value($res, 'state', $state);
                        $params['User']->set_value($res, 'p_birthday', sprintf("%04d-%02d-%02d", @$_REQUEST['birthday_Year'], @$_REQUEST['birthday_Month'], @$_REQUEST['birthday_Day']));
                        $DBFactory = Registry::get('DBFactory');
                        $Raks = new Raks($DBFactory->get_db_handle('rakscom'));
                        $Raks->addMoneyByRule($res, 'register', array());
                        add_to_log("[user_id $res]" . prepare_array_to_log($reg_data), 'register_data');
                        if (!$GLOBALS['NEED_ACTIVATION_TO_REGISTER']) {
                            //setting cookie to autologin
                            $cookie_end_time = time() + 3600 * 24 * 30;
                            $params['User']->set_cookie_autologin($res, $params['s'], $cookie_end_time);
                            $params['User']->set_value($res, 'is_autologin', 1);
                        }
                        if (!$GLOBALS['NEED_ACTIVATION_TO_REGISTER']) {
                            $params['Session']->set_value($params['s'], 'user_id', $res);
                            $params['Session']->set_value($params['s'], 'is_logged', 1);
                            add_to_log("[user_id $res][login_type register][s {$params['s']}][type " . $params['User']->get_value($res, 'type') . "]", 'login');
                        } else {
                            $key = md5(time() . microtime(true) . mt_rand(10000, 1000000) . 'huy');
                            $params['smarty']->assign('user_id', $res);
                            $params['smarty']->assign('key', $key);
                            $email_content = $params['smarty']->fetch('register_key_text.tpl');
                            $u_params = array(
                                'email' => $email,
                                'email_content' => $email_content,
                                'email_subject' => 'Account activation - RAKS.COM.UA',
                                'key' => $key,
                            );
                            $params['User']->set_value($res, 'activation_key', $key);
                            $params['User']->set_value($res, 'is_activated', 0);
                            $params['User']->send_register_key($u_params);
                            header('Location: ?go=register_key&s=' . $params['s']);
                            exit;
                        }
                    } else {
                        $params['smarty']->assign('errors', $user_container_class->get_errors($res));
                    }
                    break;
            }
            break;

        case "register_activation":
            $key = isset($_REQUEST['key']) ? $_REQUEST['key'] : '';
            $user_id = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : '';
            if (empty($key) || empty($user_id)) {
                $params['smarty']->assign('register_activate_result', 'Key is not valid!');
                return $go;
            }
            $activation_code = $params['User']->get_value($user_id, 'activation_key');
            $is_activated = $params['User']->get_value($user_id, 'is_activated');
            if ($is_activated == 1) {
                $params['smarty']->assign('register_activate_result', 'Key activated already!');
                return $go;
            }
            if ($activation_code != $key) {
                $params['smarty']->assign('register_activate_result', 'Key is not valid!');
                return $go;
            }
            $params['User']->set_value($user_id, 'is_activated', 1);
            $params['User']->set_value($user_id, 'state', 'active');
            $params['smarty']->assign('register_activate_result', 'Key was successfully activated!');
            return $go;
            break;

        case "index":
            switch ($action) {
                case "login":
                    require_once($GLOBALS['CLASSES_DIR'] . "User_container.class.php");
                    $user_container_class = new User_container($params['Validator'], $params['User']);

                    $u_params = array(
                        'login' => isset($_REQUEST['login']) ? $_REQUEST['login'] : '',
                        'password' => isset($_REQUEST['password']) ? $_REQUEST['password'] : '',
                    );
                    $user = $user_container_class->call_method("login", $u_params);
                    if ($user_container_class->is_valid($user)) {
                        $go = check_login_forum($user, $params, $u_params);
                    } else {
                        $params['smarty']->assign('errors', $user_container_class->get_errors($user));
                        $go = 'login';
                    }
                    break;


                case "facebook":
                    /** @var $facebook Facebook */
                    $facebook = Registry::get('facebook');
                    $isLogged = $params['Session']->get_value($params['s'], 'is_logged');
                    $from = isset($_REQUEST['from']) ?  $_REQUEST['from'] : '';
                    if ($isLogged) {
                        $user = $params['User']->find_user_by_id($params['Session']->get_value($params['s'], 'user_id'));
                        if($user) try_forum_login($user, $params);
                        if($from == 'forum') {
                            header('Location: ' . $GLOBALS['HTTP_PROJECT_PATH'].'/forum');
                            exit;
                        }
                        return 'index';
                    }

                    if(!empty($from)) $params['Session']->set_value($params['s'], 'facebook_auth_from', $from);

                    $isFacebookRequested = $params['Session']->get_value($params['s'], 'facebook_token_requested');
                    $url = $GLOBALS['HTTP_PROJECT_ROOT'] . '/index.php?go=index&action=facebook&after=1&s=' . $params['s'];
                    $url = str_replace('http:', 'https:', $url);
                    $url2 = $facebook->getLoginUrl($url);

                    if (!$isFacebookRequested) {
                        $params['Session']->set_value($params['s'], 'facebook_token_requested', true);
                        header('Location: ' . $url2);
                        exit;
                    }

                    //TODO: fix https to http somehow

                    $params['Session']->set_value($params['s'], 'facebook_token_requested', false);
                    //echo $url;
                    $url = $GLOBALS['HTTP_PROJECT_ROOT'] . $_SERVER['REQUEST_URI'];
                    //echo $url;
                    $url = str_replace('http:', 'https:', $url);
                    $accessToken = $facebook->getAccessToken($url);

                    if (is_null($accessToken)) {
                        $params['smarty']->assign('errors', array('login' => array('message' => 'Access Token was not sent')));
                        $go = 'login';
                        return $go;
                    }
                    $profile = $facebook->getMyProfile($accessToken);

                    if (is_null($profile)) {
                        $params['smarty']->assign('errors', array('login' => array('message' => 'Cannot fetch facebook profile')));
                        $go = 'login';
                        return $go;
                    }

                    if (!$profile->getField('verified')) {
                        $params['smarty']->assign('errors', array('login' => array('message' => 'Please confirm facebook profile')));
                        $go = 'login';
                        return $go;
                    }
                    $email = $profile->getEmail();
                    if (empty($email)) {
                        $params['smarty']->assign('errors', array('login' => array('message' => 'Please set email in facebook profile')));
                        $go = 'login';
                        return $go;
                    }

                    $user = $params['User']->find_user_by_facebook_id($profile->getId());
                    if (!is_null($user)) {
                        return check_login_forum($user, $params, $profile);
                    }

                    $user = $params['User']->find_user_by_email($email);
                    if (!is_null($user)) {
                        $isActivated = $params['User']->get_value($user['user_id'], 'is_activated');
                        if (!$isActivated) {
                            $params['smarty']->assign('errors', array('login' => array('message' => 'Please activate')));
                            $go = 'login';
                            return $go;
                        }
                        $params['User']->set_value($user['user_id'], 'facebook_id', $profile->getId());
                        return check_login_forum($user, $params, $profile);
                    }

                    $registerLogin = is_null($profile->getName()) ? 'Raks' : $profile->getName();
                    $registerLogin = $params['User']->generateLogin($registerLogin);

                    $u_params = array(
                        'login' => $registerLogin,
                        'password' => substr(md5(mt_rand(100000, 99999999) . 'babavera'), 0, 15),
                        'email' => $email,
                        'p_city_id' => 10448,
                        'p_sex' => is_null($profile->getGender()) ? 'female' : $profile->getGender(),
                    );
                    //var_dump($u_params);
                    //exit;
                    require_once($GLOBALS['CLASSES_DIR'] . "User_container.class.php");
                    $user_container_class = new User_container($params['Validator'], $params['User']);

                    $res = $user_container_class->call_method("register_user", $u_params);
                    if ($user_container_class->is_valid($res)) {
                        if ($res === false) {
                            $params['smarty']->assign('errors', array('register' => array('message' => 'Account already exists!')));
                            add_to_log("[error account already exists]" . prepare_array_to_log($u_params), "error_register");
                            return 'register';
                        }
                        require_once($GLOBALS['CLASSES_DIR'] . 'Registrator.class.php');
                        $registrator = new Registrator($params['modules']);
                        $reg_data = $registrator->register_user($u_params);
                        foreach ($reg_data as $r_key => $r_value) {
                            $params['User']->set_value($res, $r_key, $r_value);
                        }
                        unset($u_params['login']);
                        unset($u_params['password']);
                        unset($u_params['email']);
                        $params['User']->set_values($res, $u_params);
                        $params['User']->set_value($res, 'state', 'active');
                        $birthday = !is_null($profile->getBirthday()) ? $profile->getBirthday() : new \DateTime(date('Y-m-d', strtotime('-18 year')));
                        $params['User']->set_value($res, 'p_birthday', $birthday->format('Y-m-d'));
                        $DBFactory = Registry::get('DBFactory');
                        $Raks = new Raks($DBFactory->get_db_handle('rakscom'));
                        $Raks->addMoneyByRule($res, 'register', array());
                        add_to_log("[user_id $res]" . prepare_array_to_log($reg_data), 'register_data');

                        $params['Session']->set_value($params['s'], 'user_id', $res);
                        $params['Session']->set_value($params['s'], 'is_logged', 1);
                        add_to_log("[user_id $res][login_type register][s {$params['s']}][type " . $params['User']->get_value($res, 'type') . "]", 'login');

                    } else {
                        $params['smarty']->assign('errors', $user_container_class->get_errors($res));
                        return 'register';
                    }
                    $params['User']->set_value($res, 'facebook_id', $profile->getId());
                    $user = $params['User']->find_user_by_facebook_id($profile->getId());
                    return check_login_forum($user, $params, $profile);
                    break;
            }
            break;

        case "logout":
            $user_id = $params['Session']->get_value($params['s'], 'user_id');
            $params['User']->set_cookie_autologin($user_id, $params['s'], time() - 10);
            $params['User']->set_value($user_id, 'is_autologin', 0);
            header('Location: ' . $GLOBALS['HTTP_PROJECT_PATH']);
            exit;
            break;

        case "password_back":
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
            switch ($action) {
                case "password_back":
                    require_once($GLOBALS['CLASSES_DIR'] . "User_container.class.php");
                    $user_container_class = new User_container($params['Validator'], $params['User']);
                    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
                    $password_new = substr(md5(time() . 'huy'), 0, 7);
                    $params['smarty']->assign('password', $password_new);
                    $email_content = $params['smarty']->fetch('password_back_text.tpl');
                    $u_params = array(
                        'email' => $email,
                        'email_content' => $email_content,
                        'email_subject' => 'Password reminder - RAKS.COM.UA',
                        'email_password' => $password_new,
                    );
                    $res = $user_container_class->call_method("password_back", $u_params);
                    if ($user_container_class->is_valid($res)) {
                        if ($res === false) {
                            $params['smarty']->assign('errors', array('password_back' => array('message' => 'user not existing!')));
                            add_to_log("[error user not existing!][email $email]" . prepare_array_to_log($u_params), "error_password_back");
                            return $go;
                        }
                        $params['smarty']->assign('is_send', 1);
                        add_to_log("[action send data to email][email $email]" . prepare_array_to_log($u_params), "password_back");
                    } else {
                        $params['smarty']->assign('errors', $user_container_class->get_errors($res));
                    }

                    break;
            }
        case "payment":
            if (@$_REQUEST['action'] == 'payment_prepare' && @$_REQUEST['type'] == 'prepay') {
                $price = isset($_REQUEST['price']) ? $_REQUEST['price'] : 1;
                $currency = 'UAH';
                $Payment = Registry::get('Payment');
                $orderData = array(
                    'payment_type' => 'liqpay',
                    'good_id' => 0,
                    'good_type' => 'prepay',
                    'amount' => $price,
                    'currency' => $currency,
                    'user_id' => $params['Session']->get_value($params['s'], 'user_id'),
                    'created_time' => time(),
                    'is_payed' => 0,
                );
                $orderId = $Payment->createOrder($orderData);
                $paymentConfig = $Payment->getPaymentConfig('liqpay');
                require_once($GLOBALS['CLASSES_DIR'] . 'payment/payment_liqpay.class.php');
                $paymentLiqpay = new paymentLiqpay();
                $dbh = Registry::get('DBFactory')->get_db_handle("rakscom");
                $paymentLiqpay->setDbh($dbh);
                $payParams = array(
                    'version' => $paymentConfig['version'],
                    'result_url' => $paymentConfig['result_url'],
                    'server_url' => $paymentConfig['server_url'],
                    'merchant_id' => $paymentConfig['merchant_id'],
                    'merchant_signature' => $paymentConfig['merchant_signature'],
                    'order_id' => $orderId,
                    'amount' => $price,
                    'currency' => $currency,
                    'description' => 'Prepay RAKS.COM.UA',
                    'default_phone' => '',
                    'pay_way' => 'card',
                );
                $payData = $paymentLiqpay->getPaymentData($payParams);
                $params['smarty']->assign('payType', 'liqpay');
                $params['smarty']->assign('payData', $payData);
                return 'payment';
            }
            break;
    }
    return $go;
}


function page_content($go, $action, $params)
{

    switch ($go) {

        case "my_profile":
            if ($params['Session']->get_value($params['s'], 'is_logged') != 1) return 'login';
            $dbh = Registry::get('DBFactory')->get_db_handle("rakscom");
            $userStatusObj = new UserStatus($dbh);
            $userStatus = $userStatusObj->getLastActiveStatus($params['Session']->get_value($params['s'], 'user_id'));
            $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : $userStatus;
            $params['smarty']->assign('status', $status);
            switch ($action) {
                case "my_profile_save":
                    require_once($GLOBALS['CLASSES_DIR'] . "User_container.class.php");
                    $user_container_class = new User_container($params['Validator'], $params['User']);
                    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
                    $p_params = array(
                        'p_sex' => @$_REQUEST['p_sex'],
                        'p_first_name' => @$_REQUEST['p_first_name'],
                        'p_last_name' => @$_REQUEST['p_last_name'],
                        'p_city_id' => @$_REQUEST['city_id'],
                        'p_birthday' => sprintf("%04d-%02d-%02d", @$_REQUEST['p_birthday_Year'], @$_REQUEST['p_birthday_Month'], @$_REQUEST['p_birthday_Day']),
                        'p_profession' => @$_REQUEST['p_profession'],
                        'p_hobby' => @$_REQUEST['p_hobby'],
                        'p_url' => @$_REQUEST['p_url'],
                        'p_icq' => @$_REQUEST['p_icq'],
                        'p_skype' => @$_REQUEST['p_skype'],
                        'email' => $email,
                        'password' => @$_REQUEST['password'],
                    );

                    $otherUser = $params['User']->find_user_by_email($email);
                    if (!is_null($otherUser) && $otherUser['user_id'] != $params['Session']->get_value($params['s'], 'user_id')) {
                        $params['smarty']->assign('errors', array(array("message" => "Other user already have that email")));
                        return $go;
                    }

                    if (is_uploaded_file($_FILES['p_avatar_file']['tmp_name'])) {
                        $i_ret = $params['Images']->upload_image($_FILES['p_avatar_file'], $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'], 'upload');
                        if ($i_ret['res'] == true) {
                            $params['Images']->assign_image($i_ret['ID'], $params['Session']->get_value($params['s'], 'user_id'), 'user');
                            $params['User']->set_value($params['Session']->get_value($params['s'], 'user_id'), 'image_id', $i_ret['ID']);
                        } else {
                            $params['smarty']->assign('errors', array(array("message" => "Cannot upload image - not valid!")));
                            return $go;
                        }
                    }
                    $v_result = $user_container_class->validate_params("my_profile_save", $p_params);
                    if (!$user_container_class->is_valid($v_result)) {
                        $params['smarty']->assign('errors', $user_container_class->get_errors($v_result));
                        return $go;
                    }
                    if (!empty($p_params['password'])) {
                        $v_result = $user_container_class->validate_params("my_profile_save_password", $p_params);
                        if ($user_container_class->is_valid($v_result) == false) {
                            $params['smarty']->assign('errors', $user_container_class->get_errors($v_result));
                            return $go;
                        }
                        $p_params['password'] = md5($p_params['password']);
                    } else {
                        unset($p_params['password']);
                    }
                    $params['User']->set_values($params['Session']->get_value($params['s'], 'user_id'), $p_params);

                    if ($userStatus != $status && !empty($status)) {
                        $statusData = array(
                            'user_id' => $params['Session']->get_value($params['s'], 'user_id'),
                            'status' => $status,
                            'is_active' => 'Y',
                            'created_time' => time(),
                        );
                        $userStatusObj->create($statusData);
                    }
                    $Raks = new Raks($dbh);
                    $Raks->addMoneyByRule($params['Session']->get_value($params['s'], 'user_id'), 'profileEditFirst', array());
                    header('Location: ?go=profile&user_id=' . $params['Session']->get_value($params['s'], 'user_id') . '&s=' . $params['s']);
                    exit;
                    break;
            }
            break;

        case "forum_new_topic":
            $forumId = isset($_REQUEST['forum_id']) ? intval($_REQUEST['forum_id']) : 0;
            $url = isset($_REQUEST['url']) ? $_REQUEST['url'] : '';
            $dbh = Registry::get('DBFactory')->get_db_handle("rakscom");
            require_once($GLOBALS['MODULES_DIR'] . 'calendar/calendar.class.php');
            $calendar = new calendar($dbh);
            $isPortal = $calendar->checkCategoryForumId($forumId);
            if (!$isPortal) {
                header('Location: ' . $url);
                exit;
            }
            $url = $GLOBALS['HTTP_PROJECT_ROOT'] . '/calendar/index.php?go=add_calendar';
            header('Location: ' . $url);
            exit;
            break;

        case "forum_edit_post":
            $postId = isset($_REQUEST['post_id']) ? intval($_REQUEST['post_id']) : 0;
            $url = isset($_REQUEST['url']) ? $_REQUEST['url'] : '';
            $dbh = Registry::get('DBFactory')->get_db_handle("rakscom");
            require_once($GLOBALS['MODULES_DIR'] . 'calendar/calendar.class.php');
            $calendar = new calendar($dbh);
            $data = $calendar->getCategoryByPostId($postId);
            if ($data === false) {
                $url = str_replace('&amp;', '&', $url);
                if (strpos($url, 'forum/') === false) $url = str_replace('/posting', '/forum/posting', $url);
                header('Location: ' . $url);
                exit;
            }
            $url = $GLOBALS['HTTP_PROJECT_ROOT'] . '/calendar/index.php?go=edit_calendar&calendar_id=' . $data['id'];
            header('Location: ' . $url);
            exit;
            break;

        case "profile":
            require_once($GLOBALS['CLASSES_DIR'] . 'Comments.class.php');

            $DBFactory = Registry::get('DBFactory');
            $dbh = $DBFactory->get_db_handle('rakscom');
            $userId = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : 0;
            $forumUserId = isset($_REQUEST['user_forum_id']) ? intval($_REQUEST['user_forum_id']) : 0;
            $username = isset($_REQUEST['user_name']) ? $_REQUEST['user_name'] : '';
            $currentUserId = intval($params['Session']->get_value($params['s'], 'user_id'));
            if (empty($userId) && !empty($forumUserId)) {
                $foundUserId = $params['User']->findUserIdByForumId($forumUserId);
                if ($foundUserId !== false) $userId = $foundUserId;
            } elseif (empty($userId) && !empty($username)) {
                $userId = $params['User']->find_user_id_by_login($username);
            }

            $forumUserId = empty($forumUserId) ? $params['User']->get_value($userId, 'forum') : $forumUserId;
            $isUserEqual = 1;
            $profileUserId = $currentUserId;
            if ($userId != $currentUserId) {
                $isUserEqual = 0;
                $profileUserId = $userId;
            }
            $params['smarty']->assign('isUserEqual', $isUserEqual);
            $params['smarty']->assign('profile_user_id', $profileUserId);
            $userStatusesObj = new UserStatuses($dbh);
            $userStatuses = $userStatusesObj->byUserAndTime($profileUserId, 'DESC', 1, 5);
            $params['smarty']->assign('userStatuses', $userStatuses);
            //photos
            require_once($GLOBALS['MODULES_DIR'] . 'photo/Albums.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'photo/Album.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'photo/Photos.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'photo/Photo.class.php');
            $Albums = new Albums($dbh);
            $userAlbums = $Albums->byOwner('user', $userId, 'DESC', 1, 100);
            $params['smarty']->assign('userAlbums', $userAlbums);
            if ($isUserEqual) {
                $maxPeriod = Registry::get('CommentMaxNewPeriod');
                $commentsObj = new Comments($dbh);
                $userPhotoLastComments = $commentsObj->getUserNewCommentsByType($userId, 'photo', $maxPeriod);
                foreach ($userPhotoLastComments as $comment) {
                    if ($comment['comment']->sawTime == 0) $comment['comment']->sawTime = time();
                }
                $params['smarty']->assign('userPhotoLastComments', $userPhotoLastComments);
            }
            //schools
            require_once($GLOBALS['MODULES_DIR'] . 'schools/school.class.php');
            $school = new school($dbh);
            $userSchools = $school->get_user_schools($userId);
            $params['smarty']->assign('userSchools', $userSchools);
            $params['smarty']->assign('canAddAlbum', ($currentUserId == $userId) ? 1 : 0);


            //videos
            require_once($GLOBALS['MODULES_DIR'] . 'video/VideoAlbums.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'video/VideoAlbum.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'video/Videos.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'video/Video.class.php');

            $Albums = new VideoAlbums($dbh);
            $userAlbums = $Albums->byOwner('user', $userId, 'DESC', 1, 100);
            $params['smarty']->assign('userVideoAlbums', $userAlbums);
            $params['smarty']->assign('canAddVideoAlbum', ($currentUserId == $userId) ? 1 : 0);
            if ($isUserEqual) {
                $maxPeriod = Registry::get('CommentMaxNewPeriod');
                $commentsObj = new Comments($dbh);
                $userVideoLastComments = $commentsObj->getUserNewCommentsByType($userId, 'video', $maxPeriod);
                foreach ($userVideoLastComments as $comment) {
                    if ($comment['comment']->sawTime == 0) $comment['comment']->sawTime = time();
                }
                $params['smarty']->assign('userVideoLastComments', $userVideoLastComments);
            }

            //gifts
            require_once($GLOBALS['MODULES_DIR'] . 'shop/ShopUserItems.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'shop/ShopUserItem.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'shop/ShopGood.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'shop/ShopGoods.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'shop/ShopCategory.class.php');

            $canShowPrivateComment = ($userId == $currentUserId) ? 1 : 0;
            $shopUserItems = new ShopUserItems($dbh);
            $userGoods = $shopUserItems->getGoodsByUser($userId, 'action_time DESC', 1, 10);
            if (count($userGoods['items']) > 0 && $currentUserId == $userId) {
                foreach ($userGoods['items'] as $userGood) {
                    if ($userGood['giftItem']->saw_time == 0) $userGood['giftItem']->saw_time = time();
                }
            }
            $params['smarty']->assign('userGifts', $userGoods);
            $params['smarty']->assign('canShowGiftPrivateComment', $canShowPrivateComment);


            //medals
            $UserMedalsAwarded = new UserMedalsAwarded($DBFactory->get_db_handle('forum'));
            $medals = $UserMedalsAwarded->byParent('awarder_id', $forumUserId, 'time');
            $params['smarty']->assign('userMedals', $medals);

            $params['smarty']->assign('userFriends', $params['User']->getUserForumFiendsList($userId));


            break;

        case "users":
            $searchBy = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
            $searchType = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;

            $DBFactory = Registry::get('DBFactory');
            $dbh = $DBFactory->get_db_handle('rakscom');
            $User = new User($dbh);
            $findParams = array(
                'type' => $searchType,
                'search' => $searchBy,
                'perPage' => 30,
                'page' => $page,
            );
            if (!empty($searchBy)) {

                $data = $User->findUsersBy($findParams);
                //var_dump($data);
                $params['smarty']->assign('users', $data);
            }
            $findLetter = isset($_REQUEST['search_letter']) ? $_REQUEST['search_letter'] : '';
            if (!empty($findLetter) && mb_strlen($findLetter, 'UTF-8') == 1) {
                $findParams = array(
                    'type' => 'user_letter',
                    'search' => $findLetter,
                    'perPage' => 30,
                    'page' => $page,
                );
                $data = $User->findUsersBy($findParams);
                $params['smarty']->assign('userLettersSelected', $data);
            }

            if (empty($searchBy) && empty($findLetter)) {
                $findParams = array(
                    'type' => 'all',
                    'search' => '',
                    'perPage' => 10,
                    'page' => $page,
                );
                $data = $User->findUsersBy($findParams);
                $params['smarty']->assign('usersAll', $data);
            }

            $params['smarty']->assign('userLetters', $User->getUsersLetters());
            break;

        case "index":
            $DBFactory = Registry::get('DBFactory');
            $dbh = $DBFactory->get_db_handle('rakscom');

            //photos
            require_once($GLOBALS['MODULES_DIR'] . 'photo/Albums.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'photo/Album.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'photo/Photos.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'photo/Photo.class.php');

            $photos = new Photos($dbh);
            $lastPhotos = $photos->byTime('DESC', 1, 3);
            $params['smarty']->assign('lastPhotos', $lastPhotos);

            //videos
            require_once($GLOBALS['MODULES_DIR'] . 'video/VideoAlbums.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'video/VideoAlbum.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'video/Videos.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'video/Video.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'video/VideoTags.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'video/VideoTag.class.php');


            $videos = new Videos($dbh);
            $lastVideos = $videos->byTime('DESC', 1, 2);
            $params['smarty']->assign('lastVideos', $lastVideos);

            //calendars
            require_once($GLOBALS['MODULES_DIR'] . 'calendar/calendar.class.php');
            $calendar = new calendar($dbh);
            $params['smarty']->assign('calendar', $calendar);


            //articles
            require_once($GLOBALS['MODULES_DIR'] . 'article/Article.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'article/Articles.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'article/ArticleSection.class.php');
            require_once($GLOBALS['MODULES_DIR'] . 'article/ArticleSections.class.php');
            $articles = new Articles($dbh);
            $articles = $articles->byTime('DESC', 1, 5, array('enabled' => true));
            $params['smarty']->assign('lastArticles', $articles);
            break;
    }
    return $go;
}

/**
 * @param $user
 * @param $params
 * @param $u_params
 * @return string
 */
function check_login_forum($user, $params, $u_params)
{
    $go = check_login($user, $params, $u_params);
    if ($go == 'index' && $user) {
        try_forum_login($user, $params);
        $cookie_end_time = time() + 3600 * 24 * 30;
        $params['User']->set_cookie_autologin($user['user_id'], $params['s'], $cookie_end_time);
        $params['User']->set_value($user['user_id'], 'is_autologin', 1);


        $from = $params['Session']->get_value($params['s'], 'facebook_auth_from');
        if($from == 'forum') {
            $params['Session']->set_value($params['s'], 'facebook_auth_from', '');
            header('Location: ' . $GLOBALS['HTTP_PROJECT_PATH'].'/forum');
            exit;
        }
    }
    return $go;
}

function try_forum_login($user, $params){
    require_once($GLOBALS['CLASSES_DIR'] . "PHPBB.class.php");
    $phpbb = new PHPBB();
    $forumId = $params['User']->get_value($user['user_id'], 'forum');
    if($forumId > 0) {
        $sessionId = $phpbb->sessionCreate($forumId);
        $cookie_expire = time() + 3600;
        $phpbb->setCookie('sid', $sessionId, $cookie_expire);
        $phpbb->setCookie('u', $forumId, $cookie_expire);
    }

}