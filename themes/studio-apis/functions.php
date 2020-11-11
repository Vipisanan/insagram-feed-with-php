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
//----------------------------------------------------------------------------------------------------------

//-------------------------------------------api----------------------------
include('services/UserService.php');
include ('controllers/UserController.php');

add_action('rest_api_init', function () {
    $custom_posts_controller = new UserController();
    $custom_posts_controller->register_routes();
});
