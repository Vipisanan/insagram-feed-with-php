<?php


add_action('rest_api_init', function () {
    register_rest_route( 'wl/v1', 'latest-posts/(?P<category_id>\d+)',array(
        'methods'  => 'GET',
        'callback' => 'get_latest_posts_by_category'
    ));
    register_rest_route( 'wl/v1','users/(?P<user_id>\d+)' , array(
        'methods'  => 'GET',
        'callback' => 'get_all_users_by_category'
    ));
    register_rest_route( 'wl/v1', 'posts/(?P<slug>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'wl_post',
    ) );
    register_rest_route( 'wl/v1','/add-user', array(
        'methods' => 'POST',
        'callback' => 'vi_add_user',
    ) );
});

//get by post_td
function get_latest_posts_by_category($request) {

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

//get user data by id
function get_all_users_by_category($request) {
    $args = $request['user_id'];

    $posts = get_userdata($args);
    if (empty($posts)) {
        return new WP_Error( 'empty_category', 'there is no user for this id', array('status' => 404) );

    }

    $response = new WP_REST_Response($posts);
    $response->set_status(200);

    return $response;
}

function wl_post( $slug ) {
    $args = [
        'slug' => $slug['slug'],
        'post_type' => 'post'
    ];

    $post = get_posts($args);


    $data['id'] = $post[0]->ID;
    $data['title'] = $post[0]->post_title;
    $data['content'] = $post[0]->post_content;
    $data['slug'] = $post[0]->post_name;
    $data['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post[0]->ID, 'thumbnail');
    $data['featured_image']['medium'] = get_the_post_thumbnail_url($post[0]->ID, 'medium');
    $data['featured_image']['large'] = get_the_post_thumbnail_url($post[0]->ID, 'large');

    return $data;
}

function vi_add_user() {

//    $posts = get_posts($args);

    $data = [];

        $data['id'] = 'vipi';
        $data['username'] = "vipi";
        $data['email'] = "vipi@gmail.com";
        $data['description'] = 'it a first post method';
        $data['roles'] = 1;
        $data['password'] = 'vipi875020';
    $user_id = wp_create_user( 'vipi_subscriber', 'vipi875020', 'vipi@gmail.com');
    if ( is_int($user_id) )
    {
        $wp_user_object = new WP_User($user_id);
        $wp_user_object->set_role('subscriber');
//        echo 'Successfully created new admin user. Now delete this file!';
    }
    return $user_id;
}
