<?php
class RoomService {

    public function getRoomById($id){
        global $wpdb;
        $room = $wpdb->get_results("SELECT * FROM wp_std_rooms WHERE id=$id");
        return $room;
    }
}