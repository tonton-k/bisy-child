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
        <?php elseif ($is_logged_in_not_paid): // ログイン無課金?>
            <p>無課金バーサーク！！</p>
			<div id="learn-press-pmpro-notice" class="learn-press-pmpro-buy-membership purchase-course">
				<a class="lp-button button purchase-button" href="/lambda/%E3%83%A1%E3%83%B3%E3%83%90%E3%83%BC%E3%82%B7%E3%83%83%E3%83%97%E3%82%A2%E3%82%AB%E3%82%A6%E3%83%B3%E3%83%88/%E4%BC%9A%E5%93%A1%E3%83%AC%E3%83%99%E3%83%AB/">Buy Membership</a>
			</div>
        <?php else: // ログインしていない?>
            <p>ログインしてよね！</p>
			<div id="learn-press-pmpro-notice" class="learn-press-pmpro-buy-membership purchase-course">
				<a class="lp-button button purchase-button" href="/lambda/user-profile/">Buy Membership</a>
			</div>
        <?php endif; ?>


</div>
