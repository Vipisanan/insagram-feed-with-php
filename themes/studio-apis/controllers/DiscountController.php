<?php


class DiscountController extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'discount', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllDiscount'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
    }
    function get_items_permissions_check($request){
        return true;
    }

    function getAllDiscount(){
        $service = new DiscountService();
        return $service->getAllDiscount();
    }
}