<?php
// query the user media
$fields = "id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username";
$token = "IGQVJYMGtJdGg2djBibWxjUm9famRyTExoWThfdElGXzMxMHM0amZAJaFpxd0pidVhuN3k2UDdpNVJ5SHplc1g3VXc0T3FXTVFkSTFmU3JocWNkaEU4LTBVSjhMamFINkJfM2NjcEVYTkFJQ09VSmE4ZAAZDZD";
$limit = 10;

$json_feed_url="https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";
$json_feed = @file_get_contents($json_feed_url);
$contents = json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);

echo '<script language="javascript">';
//echo 'console.log('. json_encode( $contents) .')';
echo '</script>';