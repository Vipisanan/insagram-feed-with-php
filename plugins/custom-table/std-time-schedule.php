<?php
/*
Plugin Name: Custom tables for studio
Description: Create a custom table
Version: 0.1.2
Author: Vipisanan
*/


global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE `{$wpdb->base_prefix}std_user` (
    id bigint(20) AUTO_INCREMENT PRIMARY KEY,
    wp_user_id bigint(20) NOT NULL,
    email VARCHAR(50),
    name VARCHAR(30),
    photographer_name VARCHAR(30),
    shoot_type VARCHAR(20),
    note VARCHAR(500),
    created_at datetime NOT NULL
) $charset_collate;";

$rooms = "CREATE TABLE `{$wpdb->base_prefix}std_rooms` (
                id bigint(20) AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30),
                address VARCHAR(50),
                email VARCHAR(50),
                created_at datetime NOT NULL
            )$charset_collate;";

$invoice = "CREATE TABLE `{$wpdb->base_prefix}std_invoices` (
            id bigint(20) AUTO_INCREMENT PRIMARY KEY,
            std_user_id bigint(20) NOT NULL,
            total_amount float NOT NULL,
            booking_type VARCHAR(30) NOT NULL,
            no_of_hours VARCHAR(10) NOT NULL,
            FOREIGN KEY (std_user_id) REFERENCES `{$wpdb->base_prefix}std_user`(id)
            )$charset_collate;";

$schedule = "CREATE TABLE `{$wpdb->base_prefix}std_booking_schedule` (
              id bigint(20) AUTO_INCREMENT PRIMARY KEY,
              std_user_id bigint(20) NOT NULL,
              room_id bigint(20) NOT NULL,
              invoice_id bigint(20) NOT NULL,
              schedule datetime NOT NULL,
              created_at datetime NOT NULL,
              FOREIGN KEY (std_user_id) REFERENCES `{$wpdb->base_prefix}std_user`(id),
              FOREIGN KEY (room_id) REFERENCES `{$wpdb->base_prefix}std_rooms`(id),
              FOREIGN KEY (invoice_id) REFERENCES `{$wpdb->base_prefix}std_invoices`(id)
        )$charset_collate;";


$promo_code = "CREATE TABLE `{$wpdb->base_prefix}std_promo_code` (
                id bigint(20) AUTO_INCREMENT PRIMARY KEY,
                promo_type VARCHAR(30) NOT NULL,
                promo_code VARCHAR(50) NOT NULL,
                discount bigint(20)
                )$charset_collate;";


require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
dbDelta($rooms);
dbDelta($invoice);
dbDelta($schedule);
dbDelta($promo_code);

