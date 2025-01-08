<?php

/*
Plugin Name: Contact Form Plugin
Description: A simple contact form plugin for WordPress.
Version: 1.0
Author: Luceq
*/

function contact_form_enqueue_styles() {
    wp_enqueue_style('contact-form-style', plugins_url('style.css', __FILE__));
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

}
add_action('wp_enqueue_scripts', 'contact_form_enqueue_styles');

function contact_form_shortcode() {
    $content = '';
    $content .= '<div class="contact-form-container">';
    $content .= '<div class="left-column">';
    $content .= '<div class="contact-info">';
    $content .= '<p><i class="fas fa-phone"></i><strong>Phone:</strong> +123 456 789</p>';
    $content .= '<p><i class="fas fa-envelope"></i><strong>Email:</strong> contact@example.com</p>';
    $content .= '<p><i class="fas fa-map-marker-alt"></i><strong>Address:</strong> 123 Main Street, City, Country</p>';
    $content .= '<p><i class="fas fa-clock"></i><strong>Opening Hours:</strong> Mon-Fri 9:00 AM - 5:00 PM</p>';
    $content .= '</div>';
    $content .= '<div class="map-container">';
    $content .= '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019112484041!2d144.9537363153169!3d-37.81627997975195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d1e0c0b0d0b!2s123%20Main%20St%2C%20Melbourne%20VIC%203000%2C%20Australia!5e0!3m2!1sen!2sus!4v1633078471234!5m2!1sen!2sus" allowfullscreen="" loading="lazy"></iframe>';
    $content .= '</div>';
    $content .= '</div>';
    $content .= '<div class="right-column">';
    $content .= '<h2>Contact Us</h2>';
    $content .= '<form method="post" action="">';
    $content .= '<input type="text" name="cf-name" placeholder="Your Name" required>';
    $content .= '<input type="email" name="cf-email" placeholder="Your Email" required>';
    $content .= '<textarea name="cf-message" placeholder="Your Message" required></textarea>';
    $content .= '<input type="submit" name="cf-submitted" value="Send">';
    $content .= '</form>';
    $content .= '</div>';
    $content .= '</div>';
    
    return $content;
}

add_shortcode('contact_form', 'contact_form_shortcode');

function handle_form_submission() {
    if (isset($_POST['cf-submitted'])) {
        $name = sanitize_text_field($_POST['cf-name']);
        $email = sanitize_email($_POST['cf-email']);
        $message = sanitize_textarea_field($_POST['cf-message']);

        // Przykład: zapisanie danych do bazy danych (zabezpieczone przed SQL Injection)
        global $wpdb;
        $table = $wpdb->prefix . 'contact_form';
        $wpdb->insert(
            $table,
            array(
                'name' => $name,
                'email' => $email,
                'message' => $message,
            )
        );

        // Wyślij email lub wykonaj inne akcje
    }
}
add_action('init', 'handle_form_submission');