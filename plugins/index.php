<?php
// Silence is golden.
function control(){
    echo '<script language="javascript">';
    echo 'alert("message successfully sent")';
    echo '</script>';
    $user_id = get_current_user_id();

    if($user_id !== -1){
        add_action("admin_head" , "remove_menu_pages");
    }
}
add_action("init" , "control");

function remove_menu_pages(){
        remove_menu_page("upload.php");
}