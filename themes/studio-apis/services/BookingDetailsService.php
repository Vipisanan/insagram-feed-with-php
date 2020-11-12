<?php

class BookingDetailsService
{
    public function getAllBookedDetails(){
        global $wpdb;
        $res = $wpdb->get_results("SELECT * FROM std_booking_details");
        return $res;
    }

    public function saveBooingDetailsOnly($bookingData , $user_id){
        global $wpdb;
        $booking_type = $bookingData['booking_type'];
        $photographer_name = $bookingData['photographer_name'];
        $shoot_type = $bookingData['shoot_type'];
        $note = $bookingData['note'];
        $sub_total = $bookingData['sub_total'];
        $discount = $bookingData['discount'];
        $total = $bookingData['total'];
        $promo_code = $bookingData['promo_code'];
        $promo_code_discount = $bookingData['promo_code_discount'];
        $tax = $bookingData['tax'];
        $grand_total = $bookingData['grand_total'];
        $payment_status = $bookingData['payment_status'];
        $gate_way_response = $bookingData['gate_way_response'];
        $created_at = date("Y-m-d H:i:s");
        $json_data = json_encode($gate_way_response);
        $wpdb->get_results("
            INSERT INTO `std_booking_details`(  `user_id`, `booking_type`,
                                                `photographer_name`, `shoot_type`,
                                                `note`, `sub_total`,
                                                `discount`, `total`,
                                                `promo_code`, `promo_code_discount`,
                                                `tax`, `grand_total`,
                                                `payment_status`, `gate_way_response`,
                                                `created_at`)
            VALUES ('$user_id' ,
                    '$booking_type' ,
                    '$photographer_name',
                    '$shoot_type',
                    '$note',
                    '$sub_total' ,
                    '$discount' ,
                    '$total' ,
                    '$promo_code' ,
                    '$promo_code_discount' ,
                    '$tax' ,
                    '$grand_total' ,
                    '$payment_status' ,
                    '$json_data' ,
                    '$created_at'  )
        ");


//        return ("INSERT INTO `std_booking_details`(`user_id`,`gate_way_response`,`created_at`)VALUES ( $user_id ,'$json_data','$created_at');");


        $booking_id = $wpdb->get_col("SELECT id FROM std_booking_details WHERE created_at = '$created_at'");
        return $booking_id[0];
    }
    public function addBookingDetails($data){

//        check isUser
//        no :- save as WP_and std_user
//        yes:- store with slots and payment response
        $user_service = new UserService();
        $user_id = $user_service->findUserOrAdd($data);
//        after got user id
//        1 :- register booking
//        2 :- register slots
        $booking_id =  $this->saveBooingDetailsOnly($data ,(int)$user_id );
//      save slots to slot table
        $slot_service = new SlotService();
        $slot_data =  new ArrayObject();

//        have to add loop here

        $slot_data['studio_id'] = 1;
        $slot_data['slot'] = "2020-11-19 11:00:00";

        return $slot_service->addSlot($slot_data , 10);
//        return $booking_id;
    }


}