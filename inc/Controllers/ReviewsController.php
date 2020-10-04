<?php


namespace Inc\Controllers;


use inc\Base\BaseController;

class ReviewsController extends BaseController {
	public function register(){
		//register cpt.
		add_action('init',array($this,'addCpt'));
		add_action('admin_init',array($this, 'addMetaBox' ));
		add_action('wp_ajax_save_review',array($this,'saveReview'));
		add_action('save_post_review',array($this,'saveMetaBox'));

		add_shortcode('review_slideshow',array($this,'review_slideshow'));

	}

	public function addCpt(){

		$labels = array(
			'name'=> __('Review',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
			'singular_name'=>_('Review',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
			"menu_name" => _('Reviews',ADVERTISERS_INDEX_PLUGIN_DOMAIN),

		);
		$args = array(
			'labels'=>$labels,
			'public'=>true,
			'has_archive'=>false,
			'exclude_from_search'=>true,
			'publicly_queryable'=>false,
			'supports' => array('title','editor'),

		);
		register_post_type( 'review',$args);
	}

	public function addMetaBox(){
		add_meta_box(
			'review_details',
			'Review details',
			array( $this, 'renderReviewDetails' ),
			'review',
			'side',
			'default'
		);
	}

	public function renderReviewDetails($post){

		// fields: name:string,rating:Number header==title, email:string, approved:boolean, featured:boolean
		wp_nonce_field('advertisers_reviews','advertisers_reviews_nonce');
		$data = get_post_meta( $post->ID,'_advertisers_reviews_key',true);
		$name = isset($data['name'])?$data['name']:'';
		$email = isset($data['email'])?$data['email']:'';
		$advertiser_id = isset($data['advertiser_id'])?$data['advertiser_id']:null;
		$rating = isset($data['rating'])?$data['rating']:0;
		$approved = (isset($data['approved']))?$data['approved']?'checked':'':'';
		$featured =  (isset($data['featured']))?$data['featured']?'checked':'':'';

		?>
		<label for="advertisers_reviews_author" ><?  echo __('Review Author',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
		<input type="text" id="advertisers_reviews_author" name="advertisers_reviews_author" value="<? echo esc_attr($name);?>">
		<p>

			<label for="advertisers_reviews_email" ><?  echo __('Review Author email',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
			<input type="text" id="advertisers_reviews_email" name="advertisers_reviews_email" value="<? echo esc_attr($email);?>">
		</p>
        <?php
        $this->relation_field(array(
                'name' => "advertisers_reviews_advertiser_id",
                'id' => "advertisers_reviews_advertiser_id",
                'label' => __('Review Advertiser relation',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
                'value' => $advertiser_id,
                'post_type' => 'advertiser',
        ));
        $this->rating_field(array(
	        'name' => "advertisers_reviews_rating",
	        'id' => "advertisers_reviews_rating",
	        'label' => __('Rating',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
	        'value' => $rating,
        ))
        ?>

		<p>
			<label for="advertisers_reviews_approved" ><?  echo __('Approved',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
			<input type="checkbox" id="advertisers_reviews_approved" name="advertisers_reviews_approved" <?php echo $approved?> value="1">
		</p>
		<p>
			<label for="advertisers_reviews_featured" ><?  echo __('Featured',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
			<input type="checkbox" id="advertisers_reviews_featured" name="advertisers_reviews_featured" <?php echo $featured?> value="1">
		</p>

		<?php

	}

	public function saveReview() {
		//get the review details after edit and save the attributes

		wp_die();


	}

	public function relation_field(array $args){
	    // get all posts of type x set a dropdown select with name and id from args.
        $name = $args['name'];
        $id = $args['id'];
        $post_type = $args['post_type'];
        $value = $args['value'];
        $label = $args['label'];

        ?>
        <p>
            <label for="<? echo $id; ?>" ><? echo $label; ?></label>
            <select id="<? echo $id; ?>" name="<? echo $name; ?>" >
                <?php
                 $posts = get_posts(array(
                         'post_type' => $post_type,
                         'numberposts'	=> -1,
                 ));
                 foreach ($posts as $post){
                     $title = $post->post_title;
                     $selected = selected($value,$post->ID);
                     echo  '<option value="'.$post->ID.'" '.$selected.' > '.$title.'</option>';
                 }
                ?>
            </select>
        </p>
        <?php


	}

	public function rating_field(array $args){
		//print a hidden field that holds the numeric value.
        //print an initial rating representation of numeric value.
        //add js code to handle the change of value and input field updates.
	    $full_star = "★";
        $empty_star = "☆";
		$name = $args['name'];
		$id = $args['id'];
		$value = $args['value'];
		$label = $args['label'];
        if(!$value){
            $value= 0;
        }
		?>
        <p>
            <label for="<? echo $id; ?>" ><? echo $label; ?> </label>
            <input type="hidden" class="star_rating_input_js" id="<? echo $id; ?>" name="<? echo $name;?>" value="<? echo $value; ?> " />
             <div class="star_rating" >
            <?php
            $count =0;
            while ($count<5){
                $count++;
                echo '<span class="star_rating_star" data-value="'.$count.'" >'.($count>$value?$empty_star:$full_star).'</span>';
            }
            ?>
        </div>
        </p>
        <?php





	}

	public function saveMetaBox($post_id){
		if(!isset($_POST['advertisers_reviews_nonce'])){
			return $post_id;
		}

		$nonce  = $_POST['advertisers_reviews_nonce'];
		if(!wp_verify_nonce($nonce,'advertisers_reviews')){
			return $post_id;
		}
		if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE){
			return $post_id;
		}
		if(!current_user_can('edit_post',$post_id)){
			return $post_id;
		}
		$data = array(
			'name' => sanitize_text_field($_POST['advertisers_reviews_author']),
			'email' => sanitize_text_field($_POST['advertisers_reviews_email']),
			'advertiser_id' => isset($_POST['advertisers_reviews_advertiser_id'])?$_POST['advertisers_reviews_advertiser_id']:null,
		    'rating' => isset($_POST['advertisers_reviews_rating'])?$_POST['advertisers_reviews_rating']:0,
			'approved' => isset($_POST['advertisers_reviews_approved'])?1:0,
			'featured' => isset($_POST['advertisers_reviews_featured'])?1:0
		);
		update_post_meta($post_id,'_advertisers_reviews_key',$data);

	}

	public function review_slideshow(){
	    ob_start();
	    $plugin_path = ADVERTISERS_INDEX_PLUGIN_PATH;
	    $plugin_url = ADVERTISERS_INDEX_PLUGIN_URL ;
	    echo "<link rel=\"stylesheet\" href=\"$plugin_url/assets/slider.css\" type=\"text/css\" media=\"all\" />";
	    require_once("$plugin_path/page-templates/template-parts/slider.php");
	    echo "<script src=\"$plugin_url/assets/slider.js\"></script>";
	    return ob_get_clean();
	}

}