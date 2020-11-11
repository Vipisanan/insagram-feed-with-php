<?php

class UserService
{
    public function getAllUsers(){
        global $wpdb;
        $all_users = $wpdb->get_results("SELECT * FROM std_user");
        return $all_users;
    }

}