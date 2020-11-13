<?php

class DiscountService
{
    public function getAllDiscount(){
        global $wpdb;
//        hove to change query as from today
        $res = $wpdb->get_results("SELECT * FROM std_discounts");
        return $res;
    }

}