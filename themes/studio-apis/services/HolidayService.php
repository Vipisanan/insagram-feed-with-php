<?php

class HolidayService
{
    public function getAllHoliday(){
        global $wpdb;
//        hove to change query as from today
        $res = $wpdb->get_results("SELECT * FROM std_holidays");
        return $res;
    }

}