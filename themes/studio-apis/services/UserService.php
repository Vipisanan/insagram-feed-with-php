<?php

class UserService
{
    public function getAllUsers(){
        global $wpdb;
        $all_users = $wpdb->get_results("SELECT * FROM std_user");
        return $all_users;
    }

    public function addUser($userData){
        global $wpdb;
        $email = $userData['email'];
        $name = $userData['name'];
        $address = $userData['address'];
        $phone = $userData['phone'];
        $created_at = date("Y-m-d H:i:s");

        if (empty($email) || empty($name) || empty($phone)){
            return 'Wrong data! have to add validation here...';
        }
        $wpdb->get_results("
            INSERT INTO `wp_users`(`user_login`, `user_pass`,`user_email`, `user_registered`, `display_name`)
            VALUES ('$name' , 'V2pass' ,'$email' ,'$created_at' , '$name');
        ");

        $wp_user_id = $wpdb->get_col("SELECT ID FROM wp_users WHERE user_email = '$email'");
        $wpdb->get_results("
            INSERT INTO `std_user`(`wp_user_id`, `email`, `name`, `address`, `phone` ,`created_at`)
            VALUES ($wp_user_id[0] ,'$email' , '$name','$address','$phone', '$created_at')
        ");
        return $wp_user_id[0];
    }


    public function findUserOrAdd($data){
        global $wpdb;
        $email = $data['email'];
        $wp_user_id = $wpdb->get_col("SELECT ID FROM wp_users WHERE user_email = '$email'");
        if (!empty($wp_user_id[0])){
            $user_id = $wpdb->get_col("SELECT id FROM std_user WHERE email = '$email'");
            return $user_id[0];
        }else{
//            register here
            $this->addUser($data);
            $user_id = $wpdb->get_col("SELECT id FROM std_user WHERE email = '$email'");
            return $user_id[0];
        }
    }

}