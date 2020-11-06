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

class Custom_Posts_Controller extends WP_REST_Controller {

    public function register_routes() {
        $namespace = 'wl/v1';
//        $path = 'latest-posts/(?P<category_id>\d+)';

        register_rest_route( $namespace, '/' . 'latest-posts/(?P<category_id>\d+)', [
            array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' )
            )
        ]);
        register_rest_route( $namespace, '/' . 'std-users', [
            array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'get_all_std_user' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
                'args'                => array(

                ),
            )
        ]);
        register_rest_route( $namespace, '/' . 'std-users/(?P<user_id>\d+)', [
            array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'get_std_user_by_id' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
                'args'                => array(

                ),
            )
        ]);

    }
    public function get_items_permissions_check($request) {
        return true;
    }

    function get_items($request) {

        $args = array(
            'category' => $request['category_id']
        );

        $posts = get_posts($args);
        if (empty($posts)) {
            return new WP_Error( 'empty_category', 'there is no post in this category', array('status' => 404) );

        }

        $response = new WP_REST_Response($posts);
        $response->set_status(200);

        return $response;
    }

    function get_all_std_user(){
        global $wpdb;
        $table_name = $wpdb->prefix . "std_user";
        $result = $wpdb->get_results("SELECT * FROM $table_name");
        if (empty($result)) {
            return new WP_Error( 'empty_category', 'there is no post in this category', array('status' => 404) );

        }
        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $response;
    }

    function get_std_user_by_id($request){
        global $wpdb;

        $args = array(
            'user_id' => $request['user_id']
        );

        $table_name = $wpdb->prefix . "std_user";
        $id= (int)$args['user_id'];

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id = $id");
        if (empty($result)) {
            return new WP_Error( 'empty user', 'there is no user in this id', array('status' => 404) );

        }
        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $response;
    }
}
//-------------------------------------------api----------------------------
