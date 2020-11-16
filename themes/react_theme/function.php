<?php

add_action('rest_api_init', function () {
    $custom_posts_controller = new Custom_Posts_Controller();
    $custom_posts_controller->register_routes();

});
public function register_routes()
    {
        $namespace = 'v1';

        register_rest_route($namespace, '/' . 'test', [
            array(
                'methods' => 'GET',
                'callback' => array($this, 'get_items'),
                'permission_callback' => array($this, 'get_items_permissions_check')
            )
        ]);

           }

            public function get_items_permissions_check($request)
            {
                return true;
            }

            function get_items()
            {

                return 'response';
            }
}
