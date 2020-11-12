<?php

class BookingDetailsService
{
    public function getAllBookedDetails(){
        global $wpdb;
        $res = $wpdb->get_results("SELECT * FROM std_booking_details");
        return $res;
    }

    public function addBookingDetails($data){
        return $data['note'];
    }

}