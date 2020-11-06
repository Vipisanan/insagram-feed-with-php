<?php
// style
function theme_enqueue_styles()
{
    $parent_style = 'parent-style';
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style)
    );
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


//-------------------------------------------api----------------------------

add_action('rest_api_init', function () {
    $custom_posts_controller = new Custom_Posts_Controller();
    $custom_posts_controller->register_routes();
});

class Custom_Posts_Controller extends WP_REST_Controller
{

    public function register_routes()
    {
        $namespace = 'wl/v1';
//        $path = 'latest-posts/(?P<category_id>\d+)';

        register_rest_route($namespace, '/' . 'latest-posts/(?P<category_id>\d+)', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'get_items'),
                'permission_callback' => array($this, 'get_items_permissions_check')
            )
        ]);
        register_rest_route($namespace, '/' . 'std-users', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'get_all_std_user'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(),
            )
        ]);
        register_rest_route($namespace, '/' . 'std-users/(?P<user_id>\d+)', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'get_std_user_by_id'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(
                    'user' => 'vipisanan'
                ),
            )
        ]);

        register_rest_route($namespace, '/' . 'std-users', [
            array(
                'methods' => 'POST',
                'callback' => array($this, 'add_std_user'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(
                    'user' => 'vipisanan'
                ),
            )
        ]);

        register_rest_route($namespace, '/' . 'schedule', [
            array(
                'methods' => 'POST',
                'callback' => array($this, 'create_schedule'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(

                ),
            )
        ]);
        register_rest_route($namespace, '/' . 'schedule', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'get_all_schedule'),
                'permission_callback' => array($this, 'get_items_permissions_check'),
                'args' => array(

                ),
            )
        ]);


    }

    public function get_items_permissions_check($request)
    {
        return true;
    }

    function get_items($request)
    {

        $args = array(
            'category' => $request['category_id']
        );

        $posts = get_posts($args);
        if (empty($posts)) {
            return new WP_Error('empty_category', 'there is no post in this category', array('status' => 404));

        }

        $response = new WP_REST_Response($posts);
        $response->set_status(200);

        return $response;
    }

    function get_all_std_user()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "std_user";
        /*
         * get_results for get all data
         * if we want to get coloum use get_col()
         */
        $result = $wpdb->get_results("SELECT * FROM $table_name");
        if (empty($result)) {
            return new WP_Error('empty_category', 'there is no post in this category', array('status' => 404));

        }
        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $response;
    }

    function get_std_user_by_id(WP_REST_Request $request)
    {
        global $wpdb;
        $params = $request->get_params();
//        $body = $request->get_body();
//        $param = $request['name'];
//        return $param;

        $table_name = $wpdb->prefix . "std_user";
        $id = (int)$params['user_id'];

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id = $id");
        if (empty($result)) {
            return new WP_Error('empty user', 'there is no user in this id', array('status' => 404));

        }
        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $response;
    }

    function add_std_user(WP_REST_Request $request)
    {
        global $wpdb;
//        $body = $request->get_body();
        $email = $request['email'];
        $name = $request['name'];
        $photographer_name = $request['photographer_name'];
        $shoot_type = $request['shoot_type'];
        $note = $request['note'];
        $created_at = date("Y-m-d H:i:s");

        $table_name = $wpdb->prefix . "std_user";
//01  first check is he/she have wp_user id.
//02  if no add there also with random password, then get wp_user_id
//        INSERT INTO `wp_users`(`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_registered`, `user_status`, `display_name`)
//        VALUES ('loGvipi', 'pass' , 'vipi' , 'vipi@gmail.com' , '2020-10-26 06:37:20' , 0 , 'vipi')
//03  if yes already have user in WP_user


// check user
        $isUser = $wpdb->get_col("SELECT ID FROM wp_users WHERE user_login = '$name'");
        if (empty($isUser)) {
//            create user here
            $wpdb->get_results("
            INSERT INTO `wp_users`(`user_login`, `user_pass`,`user_email`, `user_registered`, `display_name`)
            VALUES ('$name' , 'pass' ,'$email' ,'$created_at' , '$name');
        ");
//            return "WELCOME TO WP " . $name;
        }
        $wp_user_id = $wpdb->get_col("SELECT ID FROM wp_users WHERE user_login = '$name'");
        $std_user_id = $wpdb->get_col("SELECT ID FROM wp_std_user WHERE user_login = '$name'");
        if (empty($std_user_id)) {
            $wpdb->get_results("
            INSERT INTO `wp_std_user`(`wp_user_id`, `email`, `name`, `photographer_name`, `shoot_type`, `note` ,`created_at`)
            VALUES ($wp_user_id[0] ,'$email' , '$name','$photographer_name','$shoot_type','$note' , '$created_at')
        ");
        } else {
            return 'You are already registered as user';
        }

        return 'user created We will send password';
    }


    function create_schedule(WP_REST_Request $request)
    {
//        INSERT INTO `wp_std_booking_schedule`(`std_user_id`, `schedule`, `created_at`)
//        VALUES (1,'2020-10-26 06:37:20','2020-10-26 06:37:20')
        global $wpdb;
        $name = $request['name'];
        $schedule = date($request['schedule']);
        $created_at = date("Y-m-d H:i:s");
        $std_user_id = $wpdb->get_col("SELECT ID FROM wp_std_user WHERE name = '$name'");
        if (!empty($std_user_id)) {
            $wpdb->get_results("
            INSERT INTO `wp_std_booking_schedule`(`std_user_id`, `schedule`, `created_at`)
            VALUES ($std_user_id[0] ,'$schedule' , '$created_at')
        ");
            return "successfully created schedule for " . $name . $std_user_id[0];
        }
    }

    function get_all_schedule(WP_REST_Request $request){
        global $wpdb;
        $all_schedule = $wpdb->get_results("SELECT * FROM wp_std_booking_schedule");
        $response = new WP_REST_Response($all_schedule);
        $response->set_status(200);
        return $response;
    }
}
//-------------------------------------------api----------------------------
