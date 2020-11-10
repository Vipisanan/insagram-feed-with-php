<?php

class StudioInvoiceController extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'std';

        register_rest_route($namespace, '/' . 'invoice-all', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getAllInvoice'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
        register_rest_route($namespace, '/' . 'invoice/(?P<invoice_id>\d+)', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'getInvoiceById'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
    }
    public function get_items_permissions_check($request){
        return true;
    }

    function getInvoiceById(WP_REST_Request $request){
        $params = $request->get_params();

        $id = (int)$params['invoice_id'];
        $invoiceService = new InvoiceService();

        return $invoiceService->getInvoiceById($id);;
    }
}