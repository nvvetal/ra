<?php

class User_container extends ValidatorContainer {

    function User_container ($validator,$class){
        $this->ValidatorContainer($validator,$class);
    }

    function init_rules(){
        $this->rules = array(
            //ACTION login
            'login'=>array(
                'login'=>array(
                    'validators'=>array(
                        "is_not_empty"=>array(),
                    ),
                    'print_name'=>"Login",
                ),

                'password'=>array(
                    'validators'=>array(
                        "is_not_empty"=>array(),
                        "is_char_min"=>array(
                            'params'=>array(
                                "min"=>3,
                             ),
                        ),
                    ),
                    'print_name'=>"Password",
                ),
             
            ),
            //ACTION register_user
            'register_user'=>array(
                'login'=>array(
                    'validators'=>array(
                        "is_not_empty"=>array(),
                        //"is_dns"=>array(),
                    ),
                    'print_name'=>"Login",
                ),
                'password'=>array(
                    'validators'=>array(
                        "is_not_empty"=>array(),
                        "is_char_min"=>array(
                            'params'=>array(
                                "min"=>5,
                            ),
                        ),
                        "is_char_max"=>array(
                            'params'=>array(
                                "max"=>20,
                            ),
                        ),                        
                    ),
                    'print_name'=>"Password",
                ),
                'email'=>array(
                    'validators'=>array(
                        "is_not_empty"=>array(),
                        "is_email"=>array(),
                    ),
                    'print_name'=>"Email",
                ),
                
                'p_sex'=>array(
                    'validators'=>array(
                        'is_not_empty'=>array(),
                    ),
                    'print_name'=>"Sex",
                ),
                 
                'p_city_id'=>array(
                    'validators'=>array(
                        'is_not_empty'=>array(),
                    ),
                    'print_name'=>"City",
                ),                                                                  
            ),

            //ACTION my_profile_save
            'my_profile_save'=>array(
                'email'=>array(
                    'validators'=>array(
                        'is_not_empty'=>array(),
                        "is_email"=>array(),
                    ),
                    'print_name'=>"Email",
                ),
                'p_sex'=>array(
                    'validators'=>array(
                        'is_not_empty'=>array(),
                    ),
                    'print_name'=>"Sex",
                ),
                'p_icq'=>array(
                    'validators'=>array(
                        'is_numeric_if_not_empty'=>array(),
                    ),
                    'print_name'=>"ICQ",
                ),
                'p_city_id'=>array(
                    'validators'=>array(
                        'is_not_empty'=>array(),
                    ),
                    'print_name'=>"City",
                ),
            ),
            'my_profile_save_password'=>array(
                'password'=>array(
                    'validators'=>array(
                        "is_not_empty"=>array(),
                        "is_char_min"=>array(
                            'params'=>array(
                                "min"=>5,
                            ),
                        ),
                        "is_char_max"=>array(
                            'params'=>array(
                                "max"=>20,
                            ),
                        ),
                    ),
                    'print_name'=>"Password",
                ),
            ),
            //ACTION password_back
            'password_back'=>array(
                'email'=>array(
                     'validators'=>array(
                        'is_not_empty'=>array(),
                        "is_email"=>array(),
                    ),
                    'print_name'=>"Email",                   
                ),
            ),
        );
    }
}

?>