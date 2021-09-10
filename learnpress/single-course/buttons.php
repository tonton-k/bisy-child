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
        $is_login = is_user_logged_in();
        $role = wcmo_get_current_user_roles(); // サイトに登録しているかどうか
        $level = wcmo_get_current_user_level(); // 課金ユーザーかどうか
        $is_paid_user = $level != 0 ? true : false;

        $is_logged_in_and_paid = $is_login && $is_paid_user;
        $is_logged_in_not_paid = $is_login && !$is_paid_user; // not paid
    ?>

        <?php if ($is_logged_in_and_paid): // ログイン課金者?>
            <p>課金者です</p>
        <?php elseif ($is_logged_in_not_paid): // ログイン無課金?>
            <p>無課金バーサーク！！</p>
        <?php else: // ログインしていない?>
            <p>ログインしてよね！</p>
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
