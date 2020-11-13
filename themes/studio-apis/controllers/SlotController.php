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
        register_rest_route($namespace, '/' . 'slots/(?P<studio_id>\d+)', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllSlotsByStudio'),
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

    function getAllSlotsByStudio(WP_REST_Request $request){
        $params = $request->get_params();
        $id = (int)$params['studio_id'];

        $service = new SlotService();
        $res = $service->getAllSlotsByStudio($id);
        if (empty($res)){
            return new WP_Error('empty slots', 'there is no slots for this id', array('status' => 404));
        }
        return $res;
    }
}