<?php


class StudioController extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'studio', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllStudio'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
    }
    function get_items_permissions_check($request){
        return true;
    }

    function getAllStudio(){
        $service = new StudioService();
        return $service->getAllStudio();
    }
}