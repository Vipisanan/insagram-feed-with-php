<?php

class Custom_Posts_Controller extends WP_REST_Controller {

    public function register_routes() {
        $namespace = 'wl/v1';
        $path = 'latest-posts/(?P<category_id>\d+)';

        register_rest_route( $namespace, '/' . $path, [
            array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' )
            ),

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
}