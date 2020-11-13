<?php

class SlotService
{
    public function getAllSlots(){
        global $wpdb;
//        hove to change query as from today
        $res = $wpdb->get_results("SELECT * FROM std_booking_slot");
        return $res;
    }

    public function getAllSlotsByStudio($studio_id){
        global $wpdb;
        $today = date("Y-m-d H:i:s");

//        hove to change query as from today
        $res = $wpdb->get_results("SELECT * FROM std_booking_slot WHERE studio_id ='$studio_id' AND slot > '$today'");
        return $res;
    }

    public function addSlot($slot_data , $booking_id){
        global $wpdb;
        $slot = $slot_data['slot'];
        $studio_id = $slot_data['studio_id'];
        $created_at = date("Y-m-d H:i:s");

        $wpdb->get_results("INSERT INTO `std_booking_slot`(`studio_id` , `booking_id` , `type` ,`slot`,`created_at`)
                            VALUE (
                            '$studio_id',
                            '$booking_id',
                            'full',
                            '$slot',
                            '$created_at'
                            )");
        return "Slot booked";
//        return ("INSERT INTO `std_booking_slot`(`studio_id` , `booking_id` , `type` ,`slot`,`created_at`) VALUE ($studio_id,$booking_id,'full','$slot','$created_at')");
    }

}