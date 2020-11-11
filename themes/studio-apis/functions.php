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

include('services/StudioService.php');
include ('controllers/StudioController.php');

add_action('rest_api_init', function () {
    $custom_user_controller = new UserController();
    $custom_user_controller->register_routes();

    $custom_studio_controller = new StudioController();
    $custom_studio_controller->register_routes();
});
