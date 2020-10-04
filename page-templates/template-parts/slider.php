<?php
	global $post;
	$reviews =  \Inc\Controllers\Advertiser::getAdvertisersReviews($post->ID,array('post_status'=>'publish'));
	$count =1;
	if(count($reviews)>0){
?>
            <div class="featured-testimonials" >

        <h3>המלצות</h3>
	    <div class="slider--outer-wrapper">
            <div class="slider--wrapper">
                <div class="slider--container">
                    <div class="slider--view">

            <ul >
    <?
		foreach ($reviews as $review){
			$data = get_post_meta($review->ID,'_advertisers_reviews_key',true);
			$name = isset($data['name'])?$data['name']:'';
			$rating = isset($data['rating'])?$data['rating']:0;
			$approved = isset($data['approved']);
			$featured =  isset($data['featured']);
			if($approved && $featured){
    ?>
                <li class="slider--view__slides <? echo $count==1?"is-active":"";?>">
                    <div class="testimonial-quote">"<? echo $review->post_content?>"</div>
                    <div class="rating">
						<?
						$full_star = "★";
						$empty_star = "☆";
						for ($i=0;$i<5;$i++){
							echo $i<$rating?$full_star:$empty_star;
						}
						?>
                    </div>
                    <div class="testimonial-author"><? echo $name;?></div>
                </li>
				<?
				$count++;
			}
		}

	?>
</ul>
            <? if($count>2): ?>
            <div class="slider--arrows">
                <span class="arrow slider--arrows__right" ><svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.03339 2.0007L18.0668 10.9393L9.03339 19.878" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                        <span class="arrow slider--arrows__left" ><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.0334 19.878L3.00001 10.9393L12.0334 2.0007" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
            </div>
            <? endif; ?>
        </div>
    </div>
</div>
</div>
            </div>

	<?php } ?>