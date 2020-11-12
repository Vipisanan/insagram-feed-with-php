<?php
/*
Plugin Name: SQL Tables for studio
Description: Create a custom table for studio
Version: 0.1.2
Author: Vipisanan
*/

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$user = "CREATE TABLE std_user (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    wp_user_id bigint(20) UNSIGNED NOT NULL,
    email VARCHAR(50),
    name VARCHAR(30),
    address VARCHAR(30),
    phone VARCHAR(30),
    role VARCHAR(30),
    created_at datetime NOT NULL,
    FOREIGN KEY (wp_user_id) REFERENCES wp_users(ID)    
) $charset_collate;";

$booking_tbl = "CREATE TABLE std_booking_details (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    user_id bigint(20) NOT NULL,
    booking_type VARCHAR(20),
    photographer_name VARCHAR(30),
    shoot_type VARCHAR(30),
    note VARCHAR(30),
    sub_total float,
    discount float,
    total float,   
    promo_code VARCHAR(20),
    promo_code_discount float ,
    tax float,
    grand_total float,
    payment_status VARCHAR(50),
    gate_way_response json NOT NULL,
    created_at datetime NOT NULL,
    FOREIGN KEY (user_id) REFERENCES std_user(id)    
) $charset_collate;";


$studio = "CREATE TABLE std_studio (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    status VARCHAR(50),
    type VARCHAR(50),
    max_reservation int,
    tax float,
    price float,
    created_at datetime NOT NULL
) $charset_collate;";

$discount = "CREATE TABLE std_discounts (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    studio_id bigint(20) NOT NULL ,
    no_of_slot int,
    discount float,
    created_at datetime NOT NULL,
    FOREIGN KEY (studio_id) REFERENCES std_studio(id)
) $charset_collate;";

$booking_slot =  "CREATE TABLE std_booking_slot (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    studio_id bigint(20) NOT NULL,
    booking_id bigint(20) NOT NULL,
    type VARCHAR(20),
    slot datetime NOT NULL,
    created_at datetime NOT NULL,
    FOREIGN KEY (studio_id) REFERENCES std_studio(id),
    FOREIGN KEY (booking_id) REFERENCES std_booking_details(id)
) $charset_collate;";

$promo = "CREATE TABLE std_promo_code (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    user_id bigint(20),
    code VARCHAR(20) NOT NULL,
    type VARCHAR(20),
    discount float,
    created_at datetime NOT NULL,
    FOREIGN KEY (user_id) REFERENCES std_user(id)
) $charset_collate;";

$open_close = "CREATE TABLE std_open_close (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    studio_id bigint(20) NOT NULL,
    day VARCHAR(20) NOT NULL,
    type VARCHAR(20),
    open time NOT NULL,
    close time NOT NULL,
    created_at datetime NOT NULL,
    FOREIGN KEY (studio_id) REFERENCES std_user(id)
) $charset_collate;";

$holidays = "CREATE TABLE std_holidays (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    reason VARCHAR(20),
    type VARCHAR(20),
    open datetime,
    close datetime,
    created_at datetime NOT NULL
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($user); //
dbDelta($booking_tbl); //
dbDelta($studio); //
dbDelta($discount); //
dbDelta($booking_slot);
dbDelta($promo); //
dbDelta($open_close);
dbDelta($holidays);

