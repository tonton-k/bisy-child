<?php
    add_action('wp_enqueue_scripts', 'bisy_child_enqueue_styles', 100);
    function bisy_child_enqueue_styles()
    {
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    }

    function wcmo_get_current_user_roles()
    {
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $roles = ( array ) $user->roles;
            return $roles[0]; // This returns an array
        // Use this to return a single value
        } else {
            return 'none';
        }
    }
