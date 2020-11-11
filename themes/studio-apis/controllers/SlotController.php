<?php


class SlotController extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'slots', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllSlots'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
    }
    function get_items_permissions_check($request){
        return true;
    }

    function getAllSlots(){
        $service = new SlotService();
        return $service->getAllSlots();
    }
}