<?php
if (is_user_logged_in()) {
} else {
    wp_redirect('lambda/user-profile/');
}
