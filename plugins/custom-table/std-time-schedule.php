<?php
/*
Plugin Name: Custom tables for studio
Description: Create a custom table
Version: 0.1.2
Author: Vipisanan
*/
//global $wpdb;
//
//$charset_collate = $wpdb->get_charset_collate();
//
//$sql = "CREATE TABLE `{$wpdb->base_prefix}cli_logins` (
//      public_key varchar(191) NOT NULL,
//      private_key varchar(191) NOT NULL,
//      user_id bigint(20) UNSIGNED NOT NULL,
//      created_at datetime NOT NULL,
//      expires_at datetime NOT NULL,
//      PRIMARY KEY  (public_key)
//    ) $charset_collate;";
//
//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//dbDelta($sql);




global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE `{$wpdb->base_prefix}std_user` (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    wp_user_id bigint(20) NOT NULL,
    email VARCHAR(50),
    name VARCHAR(30),
    photographer_name VARCHAR(30),
    shoot_type VARCHAR(20),
    note VARCHAR(500),
    created_at datetime NOT NULL
) $charset_collate;";

$sql2 = "CREATE TABLE `{$wpdb->base_prefix}std_booking_schedule` (
  id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  std_user_id bigint(20) NOT NULL,
  schedule datetime NOT NULL,
  created_at datetime NOT NULL,
  FOREIGN KEY (std_user_id) REFERENCES `{$wpdb->base_prefix}std_user`(id)
) $charset_collate;";


require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
dbDelta($sql2);
//
