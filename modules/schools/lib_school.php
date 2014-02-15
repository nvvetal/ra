<?php

function school_actions($go,$action,$params){
    switch ($action){
        case "add_school":
            $city_id = isset($_REQUEST['city_id'])?$_REQUEST['city_id']:"";

            $s_params = array(
                "name"=>isset($_REQUEST['name'])?$_REQUEST['name']:"",
                "city_id"=>$city_id,
                "url"=>isset($_REQUEST['url'])?$_REQUEST['url']:"",
                "forum_url"=>isset($_REQUEST['forum_url'])?$_REQUEST['forum_url']:"",
                "email"=>isset($_REQUEST['email'])?$_REQUEST['email']:"",
                "icq"=>isset($_REQUEST['icq'])?$_REQUEST['icq']:"",
                "skype"=>isset($_REQUEST['skype'])?$_REQUEST['skype']:"",
                "phone_1"=>isset($_REQUEST['phone_1'])?$_REQUEST['phone_1']:"",
                "phone_2"=>isset($_REQUEST['phone_2'])?$_REQUEST['phone_2']:"",
                "address"=>isset($_REQUEST['address'])?$_REQUEST['address']:"",
                "description"=>isset($_REQUEST['description'])?$_REQUEST['description']:"",
                "created_date_time"=>time(),
                "last_updated_date"=>time(),
                'is_approved'=> 1,
            );
            $s_params['owner_id']=$params['Session']->get_value($params['s'],'user_id');
            require_once('school_container.class.php');
            $school_container_class = new school_container($params['Validator'],$params['school']);
            $school_id = $school_container_class->call_method("add_school",$s_params);
            $errors = '';
            if($school_container_class->is_valid($school_id) == false){
                $params['smarty']->assign('errors',$school_container_class->get_errors($school_id));
                $go = "add_school";
                return $go;
            }
            if(is_uploaded_file($_FILES['school_image_file']['tmp_name'])) {
                $i_ret = $params['Images']->upload_image($_FILES['school_image_file'],$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],'upload');
                if($i_ret['res'] == true ){
                    $params['Images']->assign_image($i_ret['ID'],$school_id,'school');
                    $params['school']->edit_school($school_id,array('image_id'=>$i_ret['ID']));
                }else{
                    $errors = '&errors[Image][message]='.urlencode('Your image not valid - max file size or wrong file format!');
                }
            }
            if(!empty($errors)){
                header('Location: ?go=edit_school&school_id='.$school_id.'&s='.$params['s'].$errors);
            }else{
                header('Location: ?go=school&school_id='.$school_id.'&s='.$params['s']);
            }
            exit;
            break;

        case "edit_school":
            $school_id = isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"";
            $school = $params['school']->get_school($school_id);
            $user_id = $params['Session']->get_value($params['s'],'user_id');
            $city_id = isset($_REQUEST['city_id'])?$_REQUEST['city_id']:"";
            if($school['owner_id'] != $user_id && $params['User']->get_value($user_id,'admin_schools') != 1 ){
                return $go = 'school_bad_user';
            }

            $s_params = array(
                "name"=>isset($_REQUEST['name'])?$_REQUEST['name']:"",
                "city_id"=>$city_id,
                "url"=>isset($_REQUEST['url'])?$_REQUEST['url']:"",
                "forum_url"=>isset($_REQUEST['forum_url'])?$_REQUEST['forum_url']:"",
                "email"=>isset($_REQUEST['email'])?$_REQUEST['email']:"",
                "icq"=>isset($_REQUEST['icq'])?$_REQUEST['icq']:"",
                "skype"=>isset($_REQUEST['skype'])?$_REQUEST['skype']:"",
                "phone_1"=>isset($_REQUEST['phone_1'])?$_REQUEST['phone_1']:"",
                "phone_2"=>isset($_REQUEST['phone_2'])?$_REQUEST['phone_2']:"",
                "address"=>isset($_REQUEST['address'])?$_REQUEST['address']:"",
                "description"=>isset($_REQUEST['description'])?$_REQUEST['description']:"",
                "last_updated_date"=>time(),
                'is_approved'=>1,
            );
            require_once('school_container.class.php');
            $school_container_class = new school_container($params['Validator'],$params['school']);
            $res = $school_container_class->call_method_by_id("edit_school",$school_id,$s_params);
            $errors = '';
            if($school_container_class->is_valid($res) == false){
                $params['smarty']->assign('errors',$school_container_class->get_errors($res));
                $go = "edit_school";
                return $go;
            }
            if(is_uploaded_file($_FILES['school_image_file']['tmp_name'])) {
                $i_ret = $params['Images']->upload_image($_FILES['school_image_file'],$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],'upload');
                if($i_ret['res'] == true ){
                    $params['Images']->assign_image($i_ret['ID'],$school_id,'school');
                    $params['school']->edit_school($school_id,array('image_id'=>$i_ret['ID']));
                }else{
                    $errors = '&errors[Image][message]='.urlencode('Your image not valid - max file size or wrong file format!');
                }
            }
            header('Location: ?go=edit_school&school_id='.$school_id.'&s='.$params['s'].$errors);
            exit;
            break;

        case "delete_school":
            $school_id = isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"";
            $school = $params['school']->get_school($school_id);
            $user_id = $params['Session']->get_value($params['s'],'user_id');
            if($school['owner_id'] != $user_id && $params['User']->get_value($user_id,'admin_schools') != 1){
                return $go = 'school_bad_user';
            }
            $params['school']->delete_school($school_id);
            break;

        case "enable_school":
            $user_id = $params['Session']->get_value($params['s'],'user_id');
            if($params['User']->get_value($user_id,'admin_schools') != 1){
                return $go = 'school_bad_user';
            }
            $school_id = isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"";
            $params['school']->approve_school($school_id, 1);
            break;

        case "disable_school":
            $user_id = $params['Session']->get_value($params['s'],'user_id');
            if($params['User']->get_value($user_id,'admin_schools') != 1){
                return $go = 'school_bad_user';
            }
            $school_id = isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"";
            $params['school']->approve_school($school_id, 0);
            break;

        case "add_blog":
            $b_params = array(
                'author_id' => $params['Session']->get_value($params['s'],'user_id'),
                'pid' => isset($_REQUEST['pid'])?intval($_REQUEST['pid']):0,
                'school_id' => isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"",
                'text' => isset($_REQUEST['text'])?$_REQUEST['text']:"",
            );
            require_once('school_blog_container.class.php');
            $school_blog_container_class = new school_blog_container($params['Validator'],$params['school_blog']);
            $blog_id = $school_blog_container_class->call_method("add_data",$b_params);
            if($school_blog_container_class->is_valid($blog_id) == false){
                $params['smarty']->assign('errors',$school_blog_container_class->get_errors($blog_id));
                $go = "add_blog";
                return $go;
            }
            break;

        case "makeSchoolVIP":
            //1.Check is user have this school
            //2.Check money of user
            //3.Set school VIP
            $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 0;
            $user_id = $params['Session']->get_value($params['s'],'user_id');
            $isOwner = $params['school']->is_user_owner($school_id,$user_id);
            if(!$isOwner){
                $params['smarty']->assign('errors',array('VIP'=>array('message'=>'You are not owner of this school!')));
                $go = "schoolVip";
                return $go;
            }
            $canPay = $params['User']->can_pay_raks_money($user_id,$params['school']->get_cost('makeSchoolVIP'));
            if(!$canPay['ok']){
                $params['smarty']->assign('errors',array('VIP'=>array('message'=>'You dont have enought raks money to pay!')));
                $go = "schoolVip";
                return $go;
            }
            $raksMoney = $params['school']->get_cost('makeSchoolVIP');
            $params['User']->pay_raks_money($user_id,$raksMoney);
            $params['school']->set_vip($school_id);
            $params['smarty']->assign('is_success',1);
            $Payment = Registry::get('Payment');
            $Payment->addStats($user_id,'school_premium',1);
            $Payment->addStats($user_id,'raks_out',$raksMoney);
            header('Location: ?go=schoolVIP&s='.$params['s'].'&is_success=1&school_id='.$school_id);
            exit;
            break;

        case "makeSchoolTop":
            //1.Check is user have this school
            //2.Check money of user
            //3.Set school VIP
            $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 0;
            $user_id = $params['Session']->get_value($params['s'],'user_id');
            $isOwner = $params['school']->is_user_owner($school_id,$user_id);
            if(!$isOwner){
                $params['smarty']->assign('errors',array('VIP'=>array('message'=>'You are not owner of this school!')));
                $go = "schoolTop";
                return $go;
            }
            $canPay = $params['User']->can_pay_raks_money($user_id,$params['school']->get_cost('makeSchoolTop'));
            if(!$canPay['ok']){
                $params['smarty']->assign('errors',array('VIP'=>array('message'=>'You dont have enought raks money to pay!')));
                $go = "schoolTop";
                return $go;
            }
            $raksMoney = $params['school']->get_cost('makeSchoolTop');
            $params['User']->pay_raks_money($user_id,$raksMoney);
            $params['school']->set_top($school_id);
            $params['smarty']->assign('is_success',1);
            $Payment = Registry::get('Payment');
            $Payment->addStats($user_id,'school_up',1);
            $Payment->addStats($user_id,'raks_out',$raksMoney);
            header('Location: ?go=schoolTop&s='.$params['s'].'&is_success=1&school_id='.$school_id);
            exit;
            break;



    }

    switch($go){
        case "schools":
            if(empty($action) && is_array($params['User']->get_session_data('schoolsSearchData'))) return $go;
            $order_by = (isset($_REQUEST['order_by']) && in_array($_REQUEST['order_by'],array('last','name'))) ? $_REQUEST['order_by'] : 'last';
            $city_id = (isset($_REQUEST['city_id'])) ? intval($_REQUEST['city_id']) : '';
            $subdivision_id = (isset($_REQUEST['subdivision_id'])) ? intval($_REQUEST['subdivision_id']) : '';
            $country_id = (isset($_REQUEST['country_id'])) ? intval($_REQUEST['country_id']) : '';
            $page = (isset($_REQUEST['page'])) ? intval($_REQUEST['page']) : 1;
            $per_page = (isset($_REQUEST['per_page'])) ? intval($_REQUEST['per_page']) : 25;
            $schoolsSearchData = array(
                'order_by' => $order_by,
                'city_id' => $city_id,
                'subdivision_id' => $subdivision_id,
                'country_id' => $country_id,
                'per_page' => $per_page,
                'page' => $page,
            );
            $params['User']->set_session_data('schoolsSearchData',$schoolsSearchData);
            break;
    }


    return $go;

}
