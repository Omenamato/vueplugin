<?php

namespace App;
include_once(plugin_dir_path( __FILE__ ).'validate.php');

/*
Plugin Name: Registration Plugin
Description: Plugin for registration
Version: 1.0
*/

class RegistrationPlugin {
    
    private $objectvalidator;
    
    // Constructor
    public function __construct(ObjectValidator $objectvalidator) {
        $this->objectvalidator = $objectvalidator;
        add_shortcode('registrationForm', array($this, 'handle_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('rest_api_init', array($this, 'register_route'));
    }

    public function handle_shortcode() {
        return '<div id="mount"></div>';
    }

    public function enqueue_scripts() {
        global $post;
        if (has_shortcode($post->post_content, "registrationForm")) {
            wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js', [], '2.5.17');
        }
    
        wp_enqueue_script('registrationform', plugin_dir_url( __FILE__ ) . 'registrationform.js', [], '1.0', true);
    
        wp_register_style( 'style', plugins_url('style.css', __FILE__) );
        wp_enqueue_style( 'style' );
    }

    public function register_route() {
        register_rest_route( 'vueplugin/v1', 'validate-form-data', array(
                        'methods' => 'POST',
                        'callback' => array($this->objectvalidator, 'validate'),
                    )
                );
    }
}

$objectvalidator = new ObjectValidator;
$registrationplugin = new RegistrationPlugin($objectvalidator);
