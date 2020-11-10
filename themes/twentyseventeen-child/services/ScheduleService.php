<?php

class ScheduleService{

    public function getAllSlotsFromToday()
    {
        global $wpdb;
        $today = date("Y-m-d H:i:s");
        $all_schedule = $wpdb->get_results("SELECT * FROM wp_std_booking_schedule WHERE schedule > '$today'");
        return $all_schedule;
    }

    public function getAllSlots(){
        global $wpdb;
        $today = date("Y-m-d H:i:s");
        $all_schedule = $wpdb->get_results("SELECT * FROM wp_std_booking_schedule");
        return $all_schedule;
    }

    public function addSlot($request)
    {
        global $wpdb;
        $name = $request['name'];
        $schedule = date($request['schedule']);
        $created_at = date("Y-m-d H:i:s");

        if (empty($schedule) || empty($name)){
            return 'Wrong data! have to add validation here...';
        }
        $std_user_id = $wpdb->get_col("SELECT ID FROM wp_std_user WHERE name = '$name'");
        if (!empty($std_user_id)) {
            $wpdb->get_results("
            INSERT INTO `wp_std_booking_schedule`(`std_user_id`, `schedule`, `created_at`)
            VALUES ($std_user_id[0] ,'$schedule' , '$created_at')
        ");
            return "successfully created schedule for " . $name . $std_user_id[0];
        }
    }

}
