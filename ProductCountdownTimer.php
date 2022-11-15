<?php 

/**
 * @wordpress-plugin
 * Plugin Name:       ProductCountdownTimer
 * Plugin URI:        http://alexdeane.uk
 * Description:       A tool for setting delivery dates for products.
 * Version:           1.0.0
 * Author:            Alex Deane
 * Author URI:        http://alexdeane.uk
 * Text Domain:       ct
 * Domain Path:       /languages
 */

class ProductCountdownTimer {
    public static function ct_init(){
        add_action('admin_menu', [self::class, 'my_admin_menu']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_styles']);
    }

    /**
	 * Registers the style.
	 *
	 * @since    1.0.0
	 */
    public static function enqueue_styles() {
		wp_enqueue_style('ct_styles', plugins_url('css/ProductCountdownTimer.css', __FILE__), []);
	}


    /**
	 * Add custom menu page.
	 *
	 * @since    1.0.0
	 */
	public static function my_admin_menu(){
		add_menu_page(
            'Settings',
            'Countdown Timer',
            'manage_options',
            'genuine_style_countdown_timer',
            [self::class, 'countdown_timer_setings_page'],
            'dashicons-clock',
            250
        );
	}


    public static function countdown_timer_setings_page(){
        // Deleting Holiday
        if (isset($_POST['delete']) && $_POST['delete'] == 'delete') {
            $holidays = get_option('ct_holidays');
            $newHolidays = [];
            foreach($holidays as $holiday){
                if ($holiday['id'] != $_POST['id']) {
                    array_push($newHolidays, $holiday);
                }
            }
            update_option('ct_holidays', $newHolidays);
        }

        // Setting the options
        if(!get_option('ct_holidays')){
            update_option('ct_holidays', []);
        }
        if(!get_option('ct_countdown')){
            update_option('ct_countdown', []);
        }

        //update_option('ct_holidays', []);
        //update_option('ct_countdown', []);

        // Populating the options with data
        if(isset($_POST['setting']) && $_POST['setting'] == 'holidays'){
            $holidays_option = get_option('ct_holidays');
            array_push($holidays_option, $_POST);
            update_option('ct_holidays', $holidays_option);
        } else if(isset($_POST['setting'])){
            update_option('ct_' . $_POST['setting'], $_POST);
        }
        
        // Creating array to store options data
        $settings = [
            'Countdown Settings' => get_option('ct_countdown'),
            'Holidays Settings' => get_option('ct_holidays'),
        ];


        wp_enqueue_script('moment');
        wp_enqueue_script('ct_js', plugins_url('js/ProductCountdownTimer.js', __FILE__), ['jquery'], '1.0.0');
        wp_localize_script('ct_js', 'ct_settings', $settings);
        require_once __DIR__ . '/settings.php';
    }
}
ProductCountdownTimer::ct_Init();




// It adds a JS script only on the WooCommerce product page.
add_action( 'wp_footer', function(){
    // Only on the product page.
    if ( is_product() ) {
        // Creating array to store options data
        $settings = [
            'Countdown Settings' => get_option('ct_countdown'),
            'Holidays Settings' => get_option('ct_holidays'),
        ];
    
        wp_enqueue_script('moment');
        wp_enqueue_script('ct_js', plugins_url('js/ProductCountdownTimer.js', __FILE__), ['jquery'], '1.0.0a');
        wp_localize_script('ct_js', 'ct_settings', $settings);
    }
});

add_shortcode('countdown_timer', function(){
    ob_start();
    ?>
        <div id="ct_target"></div>
    <?php 
    return ob_get_clean();
});