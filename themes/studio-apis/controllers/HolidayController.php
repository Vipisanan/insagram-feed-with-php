<?php


class HolidayController extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'holiday', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllHoliday'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
    }
    function get_items_permissions_check($request){
        return true;
    }

    function getAllHoliday(){
        $service = new HolidayService();
        return $service->getAllHoliday();
    }
}