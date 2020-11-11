<?php

class StudioService
{
    public function getAllStudio(){
        global $wpdb;
        $all_users = $wpdb->get_results("SELECT * FROM std_studio");
        return $all_users;
    }

}