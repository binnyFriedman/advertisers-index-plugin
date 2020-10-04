<?php
/**
 * @package AdvertisersPlugin
 */

namespace Inc\Controllers;



class TestimonialsController extends \Inc\Base\BaseController {

	public function register(){
		if(!$this->activated('testimonial_manager')) return;
		add_action('init',array($this,'addCpt'));
		add_action('add_meta_boxes',array($this,'addMetaBox'));
		add_action('save_post_testimonial',array($this,'saveMetaBox'));
		add_action('manage_testimonial_posts_columns',array($this,'setCustomColumns'));
		add_action('manage_testimonial_posts_custom_column',array($this,'setCustomColumnsData'),10,2);
		add_filter('manage_edit-testimonial_sortable_columns',array($this,'setCustomColumnsSortable'));

	}
	public function addCpt(){
		$labels = array(
			'name'=> __('Testimonials',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
			'singular_name'=>_('Testimonials',ADVERTISERS_INDEX_PLUGIN_DOMAIN)
		);
		$args = array(
			'labels'=>$labels,
			'public'=>true,
			'has_archive'=>false,
			'menu_icon'=>'dashicons-testimonial',
			'exclude_from_search'=>true,
			'publicly_queryable'=>false,
			'supports' => array('title','editor'),

		);
		register_post_type('testimonial',$args);
	}

	public function addMetaBox(){
		add_meta_box(
			'testimonial_author',
			'Testimonial Options',
			array( $this, 'renderAuthorBox' ),
			'testimonial',
			'side',
			'default'
		);
		// author email

        // approved [checkbox]

        //featured [checkbox]


	}

	public function renderAuthorBox($post){
		wp_nonce_field('advertisers_testimonials','advertisers_testimonials_nonce');
		$data = get_post_meta( $post->ID,'_advertisers_testimonials_key',true);
		$name = isset($data['name'])?$data['name']:'';
		$email = isset($data['email'])?$data['email']:'';
		$approved = (isset($data['approved']))?$data['approved']?'checked':'':'';
		$featured =  (isset($data['featured']))?$data['featured']?'checked':'':'';

		?>
		<label for="advertisers_testimonials_author" ><?  echo __('Testimonials Author',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
		<input type="text" id="advertisers_testimonials_author" name="advertisers_testimonials_author" value="<? echo esc_attr($name);?>">
        <p>

		<label for="advertisers_testimonials_email" ><?  echo __('Testimonials Author email',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
		<input type="text" id="advertisers_testimonials_email" name="advertisers_testimonials_email" value="<? echo esc_attr($email);?>">
        </p>

        <p>
		<label for="advertisers_testimonials_approved" ><?  echo __('Approved',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
		<input type="checkbox" id="advertisers_testimonials_approved" name="advertisers_testimonials_approved" <?php echo $approved?> value="1">
        </p>
        <p>
		<label for="advertisers_testimonials_featured" ><?  echo __('Featured',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
		<input type="checkbox" id="advertisers_testimonials_featured" name="advertisers_testimonials_featured" <?php echo $featured?> value="1">
        </p>

		<?php

	}

	public function saveMetaBox($post_id){
        if(!isset($_POST['advertisers_testimonials_nonce'])){
            return $post_id;
        }

        $nonce  = $_POST['advertisers_testimonials_nonce'];
        if(!wp_verify_nonce($nonce,'advertisers_testimonials')){
            return $post_id;
        }
        if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE){
            return $post_id;
        }
        if(!current_user_can('edit_post',$post_id)){
            return $post_id;
        }

		$data = array(
        'name' => sanitize_text_field($_POST['advertisers_testimonials_author']),
		'email' => sanitize_text_field($_POST['advertisers_testimonials_email']),
		'approved' => isset($_POST['advertisers_testimonials_approved'])?1:0,
        'featured' => isset($_POST['advertisers_testimonials_featured'])?1:0
        );
        update_post_meta($post_id,'_advertisers_testimonials_key',$data);
	}

	public function setCustomColumns($columns){
	    $title = $columns['title'];
	    $date = $columns['date'];

	    unset($columns['title'],$columns['date']);

	    $columns['name'] = 'Authors name';
	    $columns['title'] = $title;
	    $columns['approved'] = 'Approved';
	    $columns['featured'] = 'Featured';
	    $columns['date'] = $date;


	    return $columns;
	}

	public function setCustomColumnsData($column,$post_id){
		$data = get_post_meta( $post_id,'_advertisers_testimonials_key',true);
		$name = isset($data['name'])?$data['name']:'';
		$email = isset($data['email'])?$data['email']:'';
		$approved = (isset($data['approved']))&&$data['approved']==1?'<strong>'.__('YES',ADVERTISERS_INDEX_PLUGIN_DOMAIN).'</strong>':'NO';
		$featured =  (isset($data['featured']))&&$data['featured']==1?'<strong>'.__('YES',ADVERTISERS_INDEX_PLUGIN_DOMAIN).'</strong>':'NO';

		switch($column) {
			case 'name':
				echo '<strong>' . $name . '</strong><br/><a href="mailto:' . $email . '">' . $email . '</a>';
				break;

			case 'approved':
				echo $approved;
				break;

			case 'featured':
				echo $featured;
				break;
		}
	}

	public function setCustomColumnsSortable($columns){
		$columns['name'] = 'name';
		$columns['approved'] = 'approved';
		$columns['featured'] = 'featured';

		return $columns;
	}
}