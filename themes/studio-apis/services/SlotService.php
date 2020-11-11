<?php

class SlotService
{
    public function getAllSlots(){
        global $wpdb;
//        hove to change query as from today
        $res = $wpdb->get_results("SELECT * FROM std_booking_slot");
        return $res;
    }

}