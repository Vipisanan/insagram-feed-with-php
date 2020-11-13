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

include('services/HolidayService.php');
include('controllers/HolidayController.php');

include('services/SlotService.php');
include('controllers/SlotController.php');

include('services/BookingDetailsService.php');
include('controllers/BookingDetailsController.php');

include('services/DiscountService.php');
include('controllers/DiscountController.php');

add_action('rest_api_init', function () {
    $user_controller = new UserController();
    $user_controller->register_routes();

    $studio_controller = new StudioController();
    $studio_controller->register_routes();

    $holiday_controller = new HolidayController();
    $holiday_controller->register_routes();

    $slots_controller = new SlotController();
    $slots_controller->register_routes();

    $booking_details_controller = new BookingDetailsController();
    $booking_details_controller->register_routes();

    $discount_controller = new DiscountController();
    $discount_controller->register_routes();
});
