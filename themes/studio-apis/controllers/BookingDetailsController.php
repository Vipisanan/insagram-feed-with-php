<?php


class BookingDetailsController extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'booking', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllBookedDetails'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
        register_rest_route($namespace, '/' . 'booking', [
            array(
                'methods' => 'POST',
                'callback' => array($this, 'bookingStudio'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
    }
    function get_items_permissions_check($request){
        return true;
    }

    function getAllBookedDetails(){
        $service = new BookingDetailsService();
        return $service->getAllBookedDetails();
    }

    function bookingStudio(WP_REST_Request $request){
        $params = $request->get_params();
        $service = new BookingDetailsService();
        $response = $service->addBookingDetails($params);
        return $response;
    }
}