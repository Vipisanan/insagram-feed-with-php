<?php


class UserController extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'users', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllUsers'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
    }
    function get_items_permissions_check($request){
        return true;
    }

    function getAllUsers(){
        $service = new UserService();
        return $service->getAllUsers();
    }
}