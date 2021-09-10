<?php
/**
 * displays course sidebar
 */
?>

<?php if (is_singular('lp_course') && is_active_sidebar('sidebar-course')): ?>
	<div class="col-lg-3 col-md-12">
		<aside class="course-sidebar" role="complementary">
			<?php dynamic_sidebar('sidebar-course'); ?>
		</aside> <!-- #sidebar --> 
	</div><!-- Sidebar col end -->
<?php else: ?>
	<?php if (is_active_sidebar('sidebar-course-archive')) { ?>
		<div class="col-lg-3 col-md-12">
			<aside class="course-sidebar" role="complementary">
			<?php dynamic_sidebar('sidebar-course-archive'); ?>
			</aside> <!-- #sidebar course-archive -->
		</div><!-- Sidebar col end -->
	<?php } ?>
<?php endif; ?>
