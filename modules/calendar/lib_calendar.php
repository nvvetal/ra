<?php

function calendar_actions($go,$action,$params){
    switch($go){
        case "add_calendar":
            $creator_id = $params['Session']->get_value($params['s'],'user_id');
            if($creator_id == 0){
                header('Location: '.$GLOBALS['HTTP_PROJECT_ROOT'].'?go=login&s='.$params['s']);
            }
            break;
    }


    switch ($action){
        case "add_calendar":
            $creator_id = $params['Session']->get_value($params['s'],'user_id');
            if($creator_id == 0){
                $params['smarty']->assign('errors',array(0=>array('message'=>'Error owner')));
                return $go;
            }
            $forumDate = sprintf('%02d.%02d.%04d',@$_REQUEST['bdate_Day'],@$_REQUEST['bdate_Month'],@$_REQUEST['bdate_Year']);
            $cityId = isset($_REQUEST['city_id'])?$_REQUEST['city_id']:0;
            $cityData = $params['Geo']->get_city($cityId);
            $fields = array(
                'name'=>isset($_REQUEST['name'])?$_REQUEST['name']:'',
                'bdate'=>sprintf('%04d-%02d-%02d',@$_REQUEST['bdate_Year'],@$_REQUEST['bdate_Month'],@$_REQUEST['bdate_Day']),
                'edate'=>sprintf('%04d-%02d-%02d',@$_REQUEST['edate_Year'],@$_REQUEST['edate_Month'],@$_REQUEST['edate_Day']),
                'city_id'=>$cityId,
                'address'=>isset($_REQUEST['address'])?$_REQUEST['address']:'',
                'category_id'=>isset($_REQUEST['category_id'])?$_REQUEST['category_id']:0,
  //              'small_info'=>isset($_REQUEST['small_info'])?$_REQUEST['small_info']:'',
                'full_info'=>isset($_REQUEST['full_info'])?$_REQUEST['full_info']:'',
                'creator_id'=>$creator_id,
                'organizator_name'=>isset($_REQUEST['organizator_name'])?$_REQUEST['organizator_name']:'',
                'is_approved' => 1,
            );
            require_once('calendar_container.class.php');
            $calendar_container_class = new calendar_container($params['Validator'],$params['calendar']);
            $calendar_id = $calendar_container_class->call_method("add_calendar",$fields);
            if($calendar_container_class->is_valid($calendar_id) == false){
                $params['smarty']->assign('errors',$calendar_container_class->get_errors($calendar_id));
                return $go;
            }
            $category = $params['calendar']->get_category($fields['category_id']);
            $calendarForum = new calendar_forum();
            $posterId = $params['User']->get_value($params['Session']->get_value($params['s'],'user_id'),'forum');
            $posterName = $params['User']->get_value($params['Session']->get_value($params['s'],'user_id'),'login');
            $topicData = array(
                'forum_id'          => $category['forum_id'],
                'topic_approved'    => 1,
                'topic_title'       => $forumDate."::".$cityData['name']."::".$fields['name'],
                'topic_poster'      => $posterId,
                'topic_time'        => time(),
            );
            $topicId = $calendarForum->createTopic($topicData);
            $bbcodeUID = substr(base_convert(uniqid(), 16, 36), 0, 8);
            require_once('calendar_forum_message_parser.class.php');
            $messParser = new calendar_forum_message_parser($fields['full_info']);
            $bitField = $messParser->get_bitfield();
            $forumMessageData = array(
                'topic_id'          => $topicId,
                'forum_id'          => $category['forum_id'],
                'poster_id'         => $posterId,
                'poster_ip'         => $_SERVER['REMOTE_ADDR'],
                'post_time'         => time(),
                'post_approved'     => 1,
                'post_subject' 	    => $fields['name'],
                'post_text'         => $messParser->add_bbcode_uid($bbcodeUID, $fields['full_info']),
                'bbcode_uid'        => $bbcodeUID,
                'bbcode_bitfield'   => $bitField,
                'enable_sig'        => 1,
            );
           
            $postId = $calendarForum->postMessage(0, $forumMessageData);
            
            $topicData = array(
                'topic_first_post_id'       => $postId,
                'topic_first_poster_name' 	=> $posterName,
                'topic_last_post_id'        => $postId,
                'topic_last_poster_id'      => $posterId,
                'topic_last_poster_name'    => $posterName,
                'topic_last_post_time'      => time(),
            ); 
            $calendarForum->setTopic($topicId, $topicData);
            
            $params['calendar']->set_calendar($calendar_id,array('forum_topic_id'=>$topicId));
            $params['calendar']->set_calendar($calendar_id,array('forum_post_id'=>$postId));

            
            $additional_info_params = array();
            if(isset($_REQUEST['lfm'])){
                $i=0;
                foreach ($_REQUEST['lfm'] as $key=>$value){
                    $additional_info_params['lfm'.$i]=$value;
                    $i++;
                }
            }
            if(isset($_REQUEST['web'])){
                $i=0;
                foreach ($_REQUEST['web'] as $key=>$value){
                    $additional_info_params['web'.$i]=$value;
                    $i++;
                }
            }
            if(isset($_REQUEST['email'])){
                $i=0;
                foreach ($_REQUEST['email'] as $key=>$value){
                    $additional_info_params['email'.$i]=$value;
                    $i++;
                }
            }
            if(isset($_REQUEST['phone'])){
                $i=0;
                foreach ($_REQUEST['phone'] as $key=>$value){
                    $additional_info_params['phone'.$i]=$value;
                    $i++;
                }
            }
            if(isset($_FILES['image'])){
                $k=0;
                foreach ($_FILES['image']['name'] as $i=>$iv){
                    if(is_uploaded_file($_FILES['image']['tmp_name'][$i])){
                        $image = array(
                            'name'=>$_FILES['image']['name'][$i],
                            'type'=>$_FILES['image']['type'][$i],
                            'tmp_name'=>$_FILES['image']['tmp_name'][$i],
                            'error'=>$_FILES['image']['error'][$i],
                            'size'=>$_FILES['image']['size'][$i],
                        );
                        $i_ret = $params['Images']->upload_image($image,$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],'upload');
                        if($i_ret['res'] != true ) continue;
                        $params['Images']->assign_image($i_ret['ID'],$calendar_id,'calendar');
                        $additional_info_params['image'.$k]=$i_ret['ID'];
                        $k++;
                    }
                }
            }
            $params['calendar']->set_calendar_additional_info($calendar_id,$additional_info_params);
            header('Location: ?go=view_calendar&calendar_id='.$calendar_id.'&s='.$params['s']);
        break;
        case "set_calendar":
            $calendar_id = isset($_REQUEST['calendar_id']) ? $_REQUEST['calendar_id'] : 0;
            $calendar_data = $params['calendar']->get_calendar($calendar_id);
            $creator_id = $params['Session']->get_value($params['s'],'user_id');
            if($creator_id == 0 ||
                ($creator_id != $calendar_data['creator_id'] &&
                    !in_array($params['User']->get_value($creator_id,'type'), array('admin','moderator'))
                )
            ){
                $params['smarty']->assign('errors',array(0=>array('message'=>'Error owner')));
                return $go;
            }
            $forumDate = sprintf('%02d.%02d.%04d',@$_REQUEST['bdate_Day'],@$_REQUEST['bdate_Month'],@$_REQUEST['bdate_Year']);
            $cityId = isset($_REQUEST['city_id'])?$_REQUEST['city_id']:0;
            $cityData = $params['Geo']->get_city($cityId);            
            $fields = array(
                'name'=>isset($_REQUEST['name'])?$_REQUEST['name']:'',
                'bdate'=>sprintf('%04d-%02d-%02d',@$_REQUEST['bdate_Year'],@$_REQUEST['bdate_Month'],@$_REQUEST['bdate_Day']),
                'edate'=>sprintf('%04d-%02d-%02d',@$_REQUEST['edate_Year'],@$_REQUEST['edate_Month'],@$_REQUEST['edate_Day']),
                'city_id'=>$cityId,
                'address'=>isset($_REQUEST['address'])?$_REQUEST['address']:'',
                'category_id'=>isset($_REQUEST['category_id'])?$_REQUEST['category_id']:0,
//                'small_info'=>isset($_REQUEST['small_info'])?$_REQUEST['small_info']:'',
                'full_info'=>isset($_REQUEST['full_info'])?$_REQUEST['full_info']:'',
                'organizator_name'=>isset($_REQUEST['organizator_name'])?$_REQUEST['organizator_name']:'',
                'is_approved'=>1,
            );
            require_once('calendar_container.class.php');
            $calendar_container_class = new calendar_container($params['Validator'],$params['calendar']);
            $res = $calendar_container_class->call_method_by_id("set_calendar",$calendar_id,$fields);
            if($calendar_container_class->is_valid($res) == false){
                $params['smarty']->assign('errors',$calendar_container_class->get_errors($res));
                return $go;
            }
            
            
            $category = $params['calendar']->get_category($fields['category_id']);
            $calendarForum = new calendar_forum();
            $topicId = $calendar_data['forum_topic_id'];
            $postId = $calendar_data['forum_post_id'];
            $topicData = array(
                'topic_title'       => $forumDate."::".$cityData['name']."::".$fields['name'],
                //'topic_time'        => time(),
            );
            $topicId = $calendarForum->setTopic($topicId, $topicData);
            $bbcodeUID = substr(base_convert(uniqid(), 16, 36), 0, 8);
            require_once('calendar_forum_message_parser.class.php');
            $messParser = new calendar_forum_message_parser($fields['full_info']);
            $bitField = $messParser->get_bitfield();
            $forumMessageData = array(
                'poster_ip'         => $_SERVER['REMOTE_ADDR'],
                //'post_time'         => time(),
                'post_approved'     => 1,
                'post_subject' 	    => $fields['name'],
                'post_text'         => $messParser->add_bbcode_uid($bbcodeUID, $fields['full_info']),
                'bbcode_uid'        => $bbcodeUID,
                'bbcode_bitfield'   => $bitField,
                'enable_sig'        => 1,
            );
           
            $postId = $calendarForum->postMessage($postId, $forumMessageData);    
            
            $calendarForum->updateTopicForumId($topicId, $category['forum_id']);        
            
            $additional_info_params = array();
            //checking selected images
            $img_cnt = 0;
            if(isset($_REQUEST['image_downloaded'])){
                foreach ($_REQUEST['image_downloaded'] as $k=>$i_data){
                    $i_data = explode('_',$i_data);
                    $additional_info_params['image'.$img_cnt] = $i_data[1];
                    $img_cnt++;
                }
                $already_added_images = $params['calendar']->get_calendar_additional_info($calendar_id,'image');
                foreach($already_added_images as $k=>$image_id){
                    $is_found = false;
                    foreach ($additional_info_params as $j=>$j_id){
                        if($image_id == $j_id){
                            $is_found = true;
                            break;
                        }
                    }
                    if($is_found == false){
                        $params['Images']->delete_image($image_id,$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']);
                    }
                }
            }  
            if(isset($_REQUEST['lfm'])){
                $i=0;
                foreach ($_REQUEST['lfm'] as $key=>$value){
                    $additional_info_params['lfm'.$i]=$value;
                    $i++;
                }
            }
            if(isset($_REQUEST['web'])){
                $i=0;
                foreach ($_REQUEST['web'] as $key=>$value){
                    $additional_info_params['web'.$i]=$value;
                    $i++;
                }
            }
            if(isset($_REQUEST['email'])){
                $i=0;
                foreach ($_REQUEST['email'] as $key=>$value){
                    $additional_info_params['email'.$i]=$value;
                    $i++;
                }
            }
            if(isset($_REQUEST['phone'])){
                $i=0;
                foreach ($_REQUEST['phone'] as $key=>$value){
                    $additional_info_params['phone'.$i]=$value;
                    $i++;
                }
            }
            if(isset($_FILES['image'])){
                foreach ($_FILES['image']['name'] as $i=>$iv){
                    if(is_uploaded_file($_FILES['image']['tmp_name'][$i])){
                        $image = array(
                            'name'=>$_FILES['image']['name'][$i],
                            'type'=>$_FILES['image']['type'][$i],
                            'tmp_name'=>$_FILES['image']['tmp_name'][$i],
                            'error'=>$_FILES['image']['error'][$i],
                            'size'=>$_FILES['image']['size'][$i],
                        );
                        $i_ret = $params['Images']->upload_image($image,$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],'upload');
                        if($i_ret['res'] != true ) continue;
                        $params['Images']->assign_image($i_ret['ID'],$calendar_id,'calendar');
                        $additional_info_params['image'.$img_cnt]=$i_ret['ID'];
                        $img_cnt++;
                    }
                }
            }
            $params['calendar']->set_calendar_additional_info($calendar_id,$additional_info_params);
            header('Location: ?go=view_calendar&calendar_id='.$calendar_id.'&s='.$params['s']);
        break;
		
		case "makeCalendarVIP":
            $calendar_id = isset($_REQUEST['calendar_id']) ? $_REQUEST['calendar_id'] : 0;
            $user_id = $params['Session']->get_value($params['s'],'user_id');
            $isOwner = $params['calendar']->is_user_owner($calendar_id, $user_id);
            $userType = $params['User']->get_value($user_id, 'type');
			$raksMoney = $params['calendar']->get_cost('makeCalendarVIP');
            if(!$isOwner && !in_array($userType, array('moderator', 'admin'))){
                $params['smarty']->assign('errors',array('VIP'=>array('message'=>'You are not owner of this calendar!')));
                $go = "calendarVIP";
                return $go;                
            }

            if ($params['calendar']->is_vip($calendar_id)) {
                $params['smarty']->assign('errors', array('VIP' => array('message' => 'Calendar already VIP!')));
            }

            if(!in_array($userType, array('moderator', 'admin'))) {
                $canPay = $params['User']->can_pay_raks_money($user_id, $raksMoney);
                if (!$canPay['ok']) {
                    $params['smarty']->assign('errors', array('VIP' => array('message' => 'You dont have enought raks money to pay!')));
                    $go = "calendarVIP";
                    return $go;
                }

                $params['User']->pay_raks_money($user_id, $raksMoney);
            }
            $params['calendar']->set_vip($calendar_id);
            
            $Payment = Registry::get('Payment');
            $params['smarty']->assign('is_success',1);
            $Payment->addStats($user_id, 'calendar_premium', 1);
            $Payment->addStats($user_id, 'raks_out', $raksMoney);
            header('Location: ?go=calendarVIP&s='.$params['s'].'&is_success=1&calendar_id='.$calendar_id);
            exit;
		break;

    }

    return $go;
}

?>