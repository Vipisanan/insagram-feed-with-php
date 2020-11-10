<?php

class InvoiceService{

    public function getAllInvoice()
    {
        global $wpdb;
        $today = date("Y-m-d H:i:s");
        $all_schedule = $wpdb->get_results("SELECT * FROM wp_std_invoices");
        return $all_schedule;
    }
    public function getInvoiceById($id){
        global $wpdb;
        $scheduleService = new ScheduleService();
        $roomService = new RoomService();

        $invoice = $wpdb->get_results("SELECT * FROM wp_std_invoices WHERE id =$id");
        if (empty($invoice)){
            return new WP_Error('empty user', 'there is no invoice for this id', array('status' => 404));
        }


        $schedules = $scheduleService->getAllScheduleByInvoiceId($id);
        $userService = new StudioUserService();
        $schedule = array();
        foreach ($schedules as $sc){
            $schedule[] = $sc->schedule;
        }
        $invoice_data = new ArrayObject();

        $invoice_data['id'] = $invoice[0]->id;
        $invoice_data['total_amount'] = $invoice[0]->total_amount;
        $invoice_data['booking_type'] = $invoice[0]->booking_type;
        $invoice_data['no_of_hours'] = $invoice[0]->no_of_hours;
        $invoice_data['user'] = $userService->getStudioUserById($invoice[0]->id)[0];
        $invoice_data['room'] = $roomService->getRoomById($schedules[0]->room_id)[0];


        $response = array(
            'invoice' => $invoice_data,
            'schedule' => $schedule
        );

        return $response;
    }

}
