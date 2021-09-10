<?php

 	defined( 'ABSPATH' ) || exit();

	if ( post_password_required() ) {
		echo get_the_password_form();

		return;
	}


	$course                  = LP_Global::course();
	$sections                = $course->get_sections();
	$lesson_count            = $course->count_items( LP_LESSON_CPT );
	$instructor              = $course->get_instructor();
	$instructor_profile_link = learn_press_user_profile_link( get_post_field( 'post_author', get_the_id() ) );
	$user_designation        = get_user_meta( $instructor->get_id(),'designation',true );
	$preview_video           = bisy_meta_option(get_the_id(),'course_preview_video');
	$co_instructors           = bisy_meta_option(get_the_id(),'course_instructors');
	$course_free_price       = bisy_meta_option( get_the_id(), 'course_free_price',0,'bisy_lp_course_options');
	$category                = '';
	$category                = get_the_terms( get_the_id(), 'course_category');
	
	if(is_array($category)){
		shuffle($category);
		$category = $category[0];
	}
  

?>

		<div class="single-course-area">
			<div class="course-top">
				<h4> <?php the_title(); ?> </h4>
				<div class="course-meta">
					<div class="author">
						<?php echo bisy_kses($instructor->get_profile_picture()); ?>
						<span> <?php echo esc_html__('Teacher','bisy'); ?> </span>
						<a href="<?php echo esc_url($instructor_profile_link); ?>"><?php echo esc_html($instructor->get_display_name()); ?></a>
					</div>
					<?php if( is_object( $category ) ): ?>
						<div class="categories">
							<span><?php echo esc_html__('Categories','bisy').':'; ?></span>
							<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"> <?php echo esc_html($category->name); ?> </a>
						</div>
					<?php endif; ?>
					
					<?php if( function_exists( 'learn_press_get_course_rate' ) ): ?>
						<?php

							$course_rate_res = learn_press_get_course_rate( get_the_id(), false );
							$course_rate     = $course_rate_res['rated'];
							$total           = $course_rate_res['total'];
						
						
						?>
						<div class="ratings">
							<?php foreach (range(1, 5) as $hnumber): ?>
								<i class="icon_star <?php echo esc_attr($hnumber<=$course_rate?'active':'inactive'); ?>"></i>
							<?php endforeach; ?>
							<span> <?php echo esc_html($course_rate); ?> (<?php echo esc_html($total); ?>)</span>
						</div>
					<?php endif; ?>
				</div>
				<div class="course-price">
					<?php if($course->is_free()): ?>

						<?php echo esc_html__('Free','bisy'); ?>
						<?php if($course_free_price > 0): ?>
						<span> <?php echo esc_html($course_free_price); ?> </span>
						<?php endif; ?>
						
					<?php else: ?>
						
						<?php if( $course->has_sale_price() ): ?> 
						<?php echo bisy_kses($course->get_price_html()); ?> 
						<?php endif; ?>
						<span> <?php echo bisy_kses($course->get_origin_price_html()); ?> </span>   

					<?php endif; ?>
				</div>
			</div>
			<?php if( has_post_thumbnail() ): ?>
				<div class="sc-thumb">
					<img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_id(),'full')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
				</div>
			<?php endif; ?>
			<div class="course-tab-wrapper">
				<ul class="course-tab-btn nav nav-tabs">
					<li><a href="#overview" data-toggle="tab"><i class="icon_ribbon_alt"></i><?php echo esc_html__('コース概要','bisy'); ?></a></li>
					<li><a href="#curriculum" data-toggle="tab"><i class="icon_book_alt"></i> <?php echo esc_html__('カリキュラム','bisy'); ?> </a></li>
					<li><a class="active" href="#instructors" data-toggle="tab"><i class="icon_profile"></i><?php echo esc_html__('インストラクター','bisy'); ?></a></li>
					<?php if( function_exists('learn_press_get_course_review') ): ?>
						<li><a href="#reviews" data-toggle="tab"><i class="icon_star"></i> <?php echo esc_html__('レビュー','bisy'); ?> </a></li>
					<?php endif; ?>
				</ul>
				<!-- Tab Content -->
				<div class="tab-content">
					<!-- Overview Tab -->
					<div class="tab-pane fade in" id="overview" role="tabpanel">
						<div class="overview-content">
							<h4><?php echo esc_html__('Course Description','bisy') ?></h4>
							<?php bisy_course_content(); ?>
						</div>
					</div>
					<!-- Overview Tab -->
					<!-- Curriculum Tab -->
					<div class="tab-pane fade in" id="curriculum" role="tabpanel">
						
						<?php

							foreach($sections  as $kl=> $section):

								$lessons = $section->get_items();
                            
							?>
								<div class="curriculum-item" id="id_<?php echo esc_attr($kl); ?>">

									<div class="card-header" id="cc_<?php echo esc_attr($kl); ?>">
										<h5 class="mb-0">
											<button class="btn btn-link" data-toggle="collapse" data-target="#acc_<?php echo esc_attr($kl); ?>" aria-expanded="true" aria-controls="acc_<?php echo esc_attr($kl); ?>">
												<?php echo esc_html($section->get_title()); ?>
											</button>
										</h5>
									</div>
									<div id="acc_<?php echo esc_attr($kl); ?>" class="collapse show" aria-labelledby="cc_<?php echo esc_attr($kl); ?>" data-parent="#id_<?php echo esc_attr($kl); ?>">
										<div class="card-body">
										
											<?php foreach($lessons as $ls_k=> $lesson): ?>
												<div class="ci-item <?php echo esc_attr($ls_k % 2 != 0?'with-bg':''); ?> ">
													<h5>
														<i class="icon_menu-square_alt2"></i>
														<a href="<?php echo esc_url($lesson->get_permalink()); ?>"> <?php echo esc_html($lesson->get_title()); ?> </a>
													</h5>
												
													<div class="ci-tools">
														<a href="<?php echo esc_url($lesson->get_permalink()); ?>" class="time">
															
															<?php if($lesson->get_duration()->get_minutes()<60): ?>
															  <?php printf( _nx( '%s min', '%s mins', $lesson->get_duration()->get_minutes(), 'Mins', 'bisy' ), number_format_i18n( $lesson->get_duration()->get_minutes() ) );  ?>
															<?php else: ?>
															    <?php $hours = $lesson->get_duration()->get_minutes() / 60; ?>
																<?php if($hours>1): ?>
																	<?php echo esc_html(number_format((float)$hours, 2, '.', '')).' '.esc_html__('hours','bisy'); ?>
																<?php else: ?>
																	<?php echo esc_html($hours).' '.esc_html__('hour','bisy'); ?>
																<?php endif; ?>
																
															<?php endif; ?>

														</a>
														<a href="<?php echo esc_url($lesson->get_permalink()); ?>" class="lock"><i class="<?php echo esc_attr($lesson->is_preview()?'fas fa-eye':'icon_lock_alt'); ?> "></i></a>
													</div>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>

							<?php endforeach; ?>
						
					</div>
					<!-- Curriculum Tab -->
					<!-- Instructors Tab -->
					<div class="tab-pane fade in show active" id="instructors" role="tabpanel">
					    <?php if( is_array($co_instructors)): ?>
							<?php foreach($co_instructors as $co_instructor): ?>
								<?php
									
									$teacher_info     = get_userdata( $co_instructor );
									$user_designation = get_user_meta($co_instructor,'bisy_user_designation',true);
									$user_socials     = get_user_meta($co_instructor,'user_social_link',true);
									$user_bio         = get_user_meta($co_instructor,'description',true);
									$dir              = learn_press_user_profile_picture_upload_dir();
									$pro_link         = '';
									
									if(isset($teacher_info->ID)){
										$pro_link   = get_user_meta($teacher_info->ID,'_lp_profile_picture',true); 
									 }
									 
									$base_url          = isset($dir['baseurl'])?$dir['baseurl']:'';
									$profile_link      =  $base_url.'/'.$pro_link;
									$url               = '#';
									
									if(function_exists('learn_press_user_profile_link') ){
                                        if(isset($teacher_info->ID)){
											$url = esc_url( learn_press_user_profile_link( $teacher_info->ID ) );
										}
										
									}else{
										if(isset($teacher_info->ID)){
											$url= get_author_posts_url( $teacher_info->ID );
										}
									
									}

									if( is_null(LP()->settings->get('learn_press_profile_page_id')) ){
										$url= get_author_posts_url( $teacher_info->ID );
									}
 
								?>
								<div class="teacher-item-3">
									<?php if( $pro_link !='' ): ?>
									<div class="teacher-thumb">
										<img src="<?php echo esc_url($profile_link); ?>" alt="<?php echo esc_attr($teacher_info->display_name); ?>">
									</div>
									<?php endif; ?>
									<div class="teacher-meta">
										<?php if(isset($teacher_info->display_name)): ?>
											<h5><a href="<?php echo esc_url($url); ?>"> <?php echo esc_html($teacher_info->display_name); ?> </a></h5>
										<?php endif; ?>
										<?php if($user_designation !=''): ?>
											<span> <?php echo esc_html($user_designation); ?> </span>
										<?php endif; ?>
										<?php echo bisy_kses(wpautop( $user_bio )); ?>
										<?php if(is_array($user_socials)): ?>
											<div class="teacher-social">
											
												<?php foreach($user_socials as $user_social): ?>
													<a href="<?php echo esc_url($user_social['url']); ?>"><i class="<?php echo esc_attr($user_social['icon']); ?>"></i></a>
												<?php endforeach; ?>

											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<!-- Instructors Tab -->
					<?php if( function_exists('learn_press_get_course_review') ): ?>
						<!-- Reviews Tab -->
						<div class="tab-pane fade in" id="reviews" role="tabpanel">
							<?php 
							// review rating
								$course_id       = get_the_ID();
								$course_rate_res = learn_press_get_course_rate( $course_id, false );
								$course_rate     = floor($course_rate_res['rated']);
								$total           = $course_rate_res['total'];
								$rating_items    = $course_rate_res['items'];
								
							?>
							<div class="reviw-area">
								<h4><?php echo esc_html__('Reviews','bisy'); ?></h4>
								<div class="reating-details">
									<div class="average-rate">
										<p><?php echo esc_html__( 'Average Rating','bisy' ); ?></p>
										<div class="rate-box">
											<h2> <?php echo esc_html($course_rate_res['rated']); ?> </h2>
											<div class="ratings">
												<?php foreach (range(1, 5) as $number): ?>
													<i class="icon_star <?php echo esc_attr($number<=$course_rate?'active':'inactive'); ?>"></i>
												<?php endforeach; ?>
												
											</div>
											<span>
												<?php printf( _nx( '%s Review', '%s Reviews', $total, 'Reviews', 'bisy' ), number_format_i18n( $total ) ); ?>
											</span>
										</div>
									</div>
									<div class="details-rate">
										<p><?php echo esc_html__('Detailed Rating','bisy'); ?></p>
										<div class="detail-rate-box">
											<?php foreach($rating_items as $rating_item): ?>
												<div class="rate-item">
													<p><?php echo esc_html($rating_item['rated']); ?></p>
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: <?php echo esc_attr($rating_item['percent']); ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
													<span><?php echo esc_attr(isset($rating_item['percent_float'])?$rating_item['percent_float']:$rating_item['percent'] ); ?>%</span>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
								<?php
									
									$paged         = ! empty( $_REQUEST['rpage'] ) ? intval( $_REQUEST['rpage'] ) : 1;
									$course_review = learn_press_get_course_review( $course_id, $paged, 5 );               //echo'<pre>';print_r($course_review);die;
									$reviews       = $course_review['reviews'];
									$total_reviews = $course_review['total'];
								
								?>
								<div class="review-rating">
									<h5><?php echo esc_html__('Comments','bisy'); ?> ( <?php echo esc_html($course_review['total']); ?> )</h5>
									<ol>
									<?php foreach ( $reviews as $review ):; 
									  $comment_rate = ceil($review->rate);
									?>
										<li>
											<div class="single-comment">
												<img src="<?php echo esc_url( get_avatar_url( $review->ID ) ); ?>" alt="<?php echo esc_attr($review->display_name); ?>">
												<h5><a href="#"> <?php echo esc_html($review->display_name); ?> </a></h5>
												<span> <?php echo esc_html( get_comment_date('F d Y',$review->comment_id) ).esc_html__(' at','bisy').esc_html( get_comment_date(' g:i a',$review->comment_id) ); ?> </span>
												<div class="comment">
													<?php echo wpautop($review->content ); ?>
												</div>
												<div class="ratings">
													<?php foreach (range(1, 5) as $cnumber): ?>
														<i class="icon_star <?php echo esc_attr($cnumber<=$comment_rate?'active':'inactive'); ?>"></i>
													<?php endforeach; ?>
												</div>
												<div class="c-border"></div>
											</div>
										</li>
									<?php endforeach; ?>
									</ol>
								</div>
								<!-- Pagination -->
								<div class="row">
									<div class="col-lg-12 text-center">
										<?php
											get_template_part( 'template-parts/blog/paginations/pagination', 'rating' );
										?>
									</div>
								</div>
								<!-- Pagination -->
								
								<?php  get_template_part( 'learnpress/review/content', 'form'); ?>
							</div>
						</div>
						<!-- Reviews Tab -->
					<?php endif; ?>
				</div>
				<!-- Tab Content -->
			</div>
			<?php get_template_part( 'template-parts/blog/blog-parts/part', 'social-course' ); ?>
			
			<?php  get_template_part( 'learnpress/single-course/related', 'course'); ?>
		</div>

   



    


