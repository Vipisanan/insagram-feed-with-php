<?php


class StudioUserService {

    function getAllStudioUsersName(){
        global $wpdb;
        $table_name = $wpdb->prefix . "std_user";
        /*
         * get_results for get all data
         * if we want to get coloum use get_col()
         */
        $result = $wpdb->get_results("SELECT * FROM $table_name");

        return $result;
    }

    public function getStudioUserById($id) {
        global $wpdb;

        $table_name = $wpdb->prefix . "std_user";

        return $wpdb->get_results("SELECT * FROM $table_name WHERE id = $id");

    }

    public function saveUser(WP_REST_Request $request){
        global $wpdb;
//        $body = $request->get_body();
        $email = $request['email'];
        $name = $request['name'];
        $photographer_name = $request['photographer_name'];
        $shoot_type = $request['shoot_type'];
        $note = $request['note'];
        $created_at = date("Y-m-d H:i:s");

        $table_name = $wpdb->prefix . "std_user";

        if (empty($email) || empty($name) || empty($photographer_name) || empty($shoot_type)){
            return 'Wrong data! have to add validation here...';
        }
//01  first check is he/she have wp_user id.
//02  if no add there also with random password, then get wp_user_id
//03  if yes already have user in WP_user

// check user
        $isUser = $wpdb->get_col("SELECT ID FROM wp_users WHERE user_login = '$name'");
        if (empty($isUser)) {
//            create user here
            $wpdb->get_results("
            INSERT INTO `wp_users`(`user_login`, `user_pass`,`user_email`, `user_registered`, `display_name`)
            VALUES ('$name' , 'pass' ,'$email' ,'$created_at' , '$name');
        ");
//            return "WELCOME TO WP " . $name;
        }
        $wp_user_id = $wpdb->get_col("SELECT ID FROM wp_users WHERE user_login = '$name'");
        $std_user_id = $wpdb->get_col("SELECT ID FROM wp_std_user WHERE user_login = '$name'");
        if (empty($std_user_id)) {
            $wpdb->get_results("
            INSERT INTO `wp_std_user`(`wp_user_id`, `email`, `name`, `photographer_name`, `shoot_type`, `note` ,`created_at`)
            VALUES ($wp_user_id[0] ,'$email' , '$name','$photographer_name','$shoot_type','$note' , '$created_at')
        ");
        } else {
            return 'You are already registered as user';
        }

        return 'user created We will send password';
    }
}