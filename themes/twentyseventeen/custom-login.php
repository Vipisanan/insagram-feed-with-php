<?php

global $user_ID;
global $wpdb;

if(!$user_ID){
    if($_POST){
          //We shall SQL escape all inputs to avoid sql injection.
        $username = $wpdb->escape($_POST['username']);
        $password = $wpdb->escape($_POST['password']);
        
        $login_array = array();
        $login_array['user_login'] =  $username;
        $login_array['user_password'] =  $password;
        
        $verify_user = wp_signon($login_array , true);
        if(!is_wp_error($verify_user)){
            echo '<script language="javascript">';
            echo 'alert("login successfull")';
            echo '</script>';
            echo "<script> window.location = '".site_url()."'</script>";
            
        }else{
            echo '<script language="javascript">';
            echo 'alert("login faild")';
            echo '</script>';
            echo "<p>Invalid user</p>";
        }
    }else{
        get_header();
        ?>
        <form method="post">
                        <p>
                            <label for="usename">name?email</label>
                            <input type="text" id="username" name="username" placeholder="name">
                        </p>
                        <p>
                            <label for="password">password</label>
                            <input type="text" id="password" name="password" placeholder="password">
                        </p>
                        <p>
                            <button type="submit" name="btn_submit">login</button>
                        </p>
        </form>
        <?php
    get_footer();
    }
}else{

}