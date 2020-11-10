<?php


class StudioUserController extends WP_REST_Controller
{
    public function register_routes(){
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'user', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllStudioUsers'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
        register_rest_route($namespace, '/' . 'user/(?P<user_id>\d+)', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getStudioUserById'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
        register_rest_route($namespace, '/' . 'user', [
            array(
                'methods' => 'POST',
                'callback' => array($this, 'saveUser'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
    }
    function get_items_permissions_check($request){
        return true;
    }

    function getAllStudioUsers(){
        $studioUserService = new StudioUserService();
        $result = $studioUserService->getAllStudioUsersName();
        if (empty($result)) {
            return new WP_Error('empty_category', 'there is no post in this category', array('status' => 404));

        }
        $response = new WP_REST_Response($result);
        $response->set_status(200);

        return $result;
    }

    function getStudioUserById(WP_REST_Request $request){
        $studioUserService = new StudioUserService();
        $params = $request->get_params();

        $id = (int)$params['user_id'];
        $result = $studioUserService->getStudioUserById($id);

        if (empty($result)) {
            return new WP_Error('empty user', 'there is no user in this id', array('status' => 404));

        }
        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $response;
    }

    function saveUser(WP_REST_Request $request){
        $studioUserService = new StudioUserService();
        $result = $studioUserService->saveUser($request);

        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $response;

    }
}