<?php
    add_action('wp_enqueue_scripts', 'bisy_child_enqueue_styles', 100);
    function bisy_child_enqueue_styles()
    {
        /*
            default styles
            aaaaaa
            wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
        */
        wp_enqueue_style('parent-style', get_template_directory_uri().'/style.css');
        wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
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

    function wcmo_get_current_user_level()
    {
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $level = $user->membership_level->id;
            if ($level == null or $level == 0) {
                return 0;
            } else {
                return $level;
            }
        } else {
            return false;
        }
    }
