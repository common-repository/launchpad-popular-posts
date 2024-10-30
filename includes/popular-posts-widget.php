<?php 

class Launchpad_Most_Popular_Post_Widget extends WP_Widget{
	public function __construct(){
		parent:: __construct('most_popular_post_widget', 'Launchpad Popular Posts Widget',array(
          'description'=> 'Shown your most views post, Recent Posts and Related Posts'
		));
	}

 	public	function widget($args,$instance){
		
		$title=$instance['title'];
		$post_per_page=$instance['post_per_page'];
		$displayviews=$instance['displayviews'];
		$cmtcount=$instance['cmtcount'];
		$dauthor=$instance['dauthor'];
		$orderby=$instance['order_by'];
		
      	if($orderby == 'popular_post'){
			$launchpad_posts = new WP_Query( array(
				"posts_per_page" => $post_per_page,
				"post_type" => "post",
				"meta_key" => "views",
				"orderby" => "meta_value_num",
				"order" => "DESC",
				"ignore_sticky_posts" => 1,
			));			
		}elseif($orderby == 'recents_post'){
			$launchpad_posts = new WP_Query( array(
				"posts_per_page" => $post_per_page,
				"post_type" => "post",
				"orderby" => "date",
				"order" => "DESC",
				"ignore_sticky_posts" => 1,
			));	
		}else{
			global $post;
			$latest_category = wp_get_post_categories($post->ID);
			$launchpad_posts = new WP_Query( array(
				"posts_per_page" => $post_per_page,
				"post_type" => "post",
				'post__not_in' => array($post->ID),
				'category__in' => $latest_category,
				"ignore_sticky_posts" => 1,
			));			
		}


      	echo $args['before_widget'];
      	echo $args['before_title'];
      	echo $title;
        echo $args['after_title'];
 		
 		if ( $launchpad_posts->have_posts() ) {
			echo '	<section id="mc_popular_articles" class="widget_mc_related_articles">
						<div class="widget-wrap"><div class="related-articles wrap"><div class="related-posts-column">';
								while ( $launchpad_posts->have_posts() ) {
									$launchpad_posts->the_post();
									$thumb	=	wp_get_attachment_image_src(get_post_thumbnail_id(),'thumb_related');
									$thumb    =   $thumb[0];
									if(!$thumb){$thumb = esc_url( get_template_directory_uri() ).'/framework/images/placeholder-image.jpg';}	
				 
									
									$count = get_post_meta(get_the_id(),'views', true);
			
									echo '<div class="related-item">
										<div class="related-img">
											<a href="'.get_the_permalink().'" rel="bookmark" title="'.get_the_title().'"><img width="347" height="180" src="'.$thumb.'" class="attachment-three-columns size-three-columns wp-post-image jetpack-lazy-image--handled"></a>
										</div>
										<div class="related-title">
											<h2><a href="'.get_the_permalink().'" rel="bookmark" title="'.get_the_title().'">'.get_the_title().'</a></h2>
										</div>
									</div>';

								}
							echo '</div></div></div></section>';
		} else {
			echo '';
		}
      	echo $args['after_widget'];
	}

 	public	function form($instance){
 	  	if(isset($instance['title'])){
 	  		$title = $instance['title'];
 	  	}else{
 	   		$title = '';
 	  	}  

 	  	if(isset($instance['post_per_page'])){
 	  		$post_per_page = $instance['post_per_page'];
 	  	}else{
 	   		$post_per_page = 5;
 	  	}  
 
 		if(isset($instance['displayviews'])){
 	  		$displayviews = $instance['displayviews'];
 	  	}else{
 	   		$displayviews = 0;
 	  	}
 	  
 	  	if(isset($instance['cmtcount'])){
 	  		$cmtcount = $instance['cmtcount'];
 	  	}else{
 	   		$cmtcount = 0;
 	  	} 

 	  	if(isset($instance['dauthor'])){
 	  		$dauthor = $instance['dauthor'];
 	  	}else{
 	   		$dauthor = 0;
 	  	} 
		if(isset($instance['order_by'])){
 	  		$orderby = $instance['order_by'];
 	  	}else{
 	   		$orderby ='';
 	  	} 


 	  
		?>
       <p>
       	<label for="<?php echo $this->get_field_id('title') ?>">Widget Title:</label>
       	<input type="text" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>"
       	value="<?php echo esc_attr ($title); ?>" class="widefat">
       </p>

		<p>
	       	<label for="<?php echo $this->get_field_id('post_per_page') ?>">Posts Per Page</label>
	       	<input type="text" id="<?php echo $this->get_field_id('post_per_page') ?>" name="<?php echo $this->get_field_name('post_per_page') ?>"
	       	value="<?php echo esc_attr ($post_per_page); ?>" class="widefat">
       </p>
       	<p>
       		<label for="<?php echo $this->get_field_id('order_by') ?>">Order by</label>
       		<select name="<?php echo $this->get_field_name('order_by') ?>">
       			<option value="popular_post" <?php if($orderby=='popular_post'){echo 'selected';} ?>>Popular Post</option>
       			<option value="recents_post" <?php if($orderby=='recents_post'){echo 'selected';} ?>>Recent Post</option>
       			<option value="related_post" <?php if($orderby=='related_post'){echo 'selected';} ?>>Related Post</option>
       		</select>
       	</p>
       <!--p>
       <input type="checkbox" id="<?php echo $this->get_field_id('displayviews') ?>" name="<?php echo $this->get_field_name('displayviews') ?>"
       	value="1" <?php checked($displayviews,1); ?> class="widefat">
       	<label for="<?php echo $this->get_field_id('displayviews') ?>">Display Views Count</label>
       	</p>

       <p>
       	<input type="checkbox" id="<?php echo $this->get_field_id('cmtcount') ?>" name="<?php echo $this->get_field_name('cmtcount') ?>"
       	value="1" <?php checked($cmtcount,1); ?> class="widefat">
       	<label for="<?php echo $this->get_field_id('cmtcount') ?>">Display Comment Count</label>
       	</p>

     	  <p>
       	  <input type="checkbox" id="<?php echo $this->get_field_id('dauthor') ?>" name="<?php echo $this->get_field_name('dauthor') ?>"value="1" <?php checked($dauthor,1); ?> class="widefat">
       	<label for="<?php echo $this->get_field_id('dauthor') ?>">Display Author</label>
       </p-->

	<?php }

    public function update($new_instance, $old_instance){
      	$instance = array();
      	$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
      	$instance['post_per_page'] = (!empty($new_instance['post_per_page'])) ? strip_tags($new_instance['post_per_page']) : '';
       	$instance['order_by'] = (!empty($new_instance['order_by'])) ? strip_tags($new_instance['order_by']) : '';

     	// $instance['displayviews'] = (!empty($new_instance['displayviews'])) ? strip_tags($new_instance['displayviews']) : '';
      	//$instance['cmtcount'] = (!empty($new_instance['cmtcount'])) ? strip_tags($new_instance['cmtcount']) : '';
      	//$instance['dauthor'] = (!empty($new_instance['dauthor'])) ? strip_tags($new_instance['dauthor']) : '';
      	return $instance;
	 }

}



									// if($displayviews == 1){
									// 	echo $count. ' views ';}
									// if($cmtcount == 1){
									//  	comments_popup_link( '0 comment', '1 comment', '% comments', 'comments-link', 'Comment off'); echo '&nbsp'; }
									// if($dauthor == 1){
									// 	echo the_author_posts_link();
									// }