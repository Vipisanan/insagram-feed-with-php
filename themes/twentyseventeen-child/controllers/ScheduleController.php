<?php
class StudioScheduleController extends WP_REST_Controller
{

    public function register_routes(){
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'schedule', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllSlots'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
        register_rest_route($namespace, '/' . 'schedule', [
            array(
                'methods' => 'POST',
                'callback' => array($this, 'addSlot'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);

    }
    function get_items_permissions_check($request){
        return true;
    }

    function getAllSlots(){
        $scheduleService = new ScheduleService();
        $result = $scheduleService->getAllSlots();
        if (empty($result)) {
            return new WP_Error('empty_category', 'there is no slot', array('status' => 404));

        }
        $response = new WP_REST_Response($result);
        $response->set_status(200);

        return $result;
    }

    function addSlot(WP_REST_Request $request){

        $scheduleService = new ScheduleService();
        $result = $scheduleService->addSlot($request);

        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $result;
    }
}