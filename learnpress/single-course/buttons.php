<?php
/**
 * シングルコースのボタン
 * Template for displaying buttons of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/buttons.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined('ABSPATH') || exit();
?>

<div class="lp-course-buttons">
    <?php
        /* ユーザーがサインインしているときのみ */
        $role = wcmo_get_current_user_roles();
        $level = wcmo_get_current_user_level();

        if (is_user_logged_in()): ?>
        <?php echo $role ?>
        <?php echo $level ?>
        aaaaaaaaaaaaaaaaaaaaaaaa
    <?php endif; ?>
	<?php
    do_action('learn-press/before-course-buttons');

    /**
     * @see LP_Template_Course::course_purchase_button - 10
     * @see LP_Template_Course::course_enroll_button - 10
     * @see learn_press_course_retake_button - 10
     */
    do_action('learn-press/course-buttons');

    do_action('learn-press/after-course-buttons');
    ?>

</div>
