<?php
/**
 * @package  AdvertisersIndex
 */


namespace Inc\Controllers;


use Inc\Base\BaseController;

class Advertiser extends BaseController {
    public $templates = array();
    public $plugin_path = ADVERTISERS_INDEX_PLUGIN_PATH;
    public $plugin_url = ADVERTISERS_INDEX_PLUGIN_URL ;
	public function register(){
		$this->templates = array(
			'page-templates/advertiser-level-1-tpl.php' => 'Advertiser Level 1',
			'page-templates/advertiser-level-2-tpl.php' => 'Advertiser Level 2',
			'page-templates/advertiser-level-3-tpl.php' => 'Advertiser Level 3',
		);
		add_action('init',array($this,'registerCpt'));
		add_action('init',array($this,'registerTax'));
		add_action('add_meta_boxes',array($this,'addMetaBox'));
		add_action('save_post_advertiser',array($this,'saveMetaBoxes'));
		add_action('wp_ajax_advertiser_contact',array($this,'advertiser_contact_form_ajax'));
		add_action('wp_ajax_nopriv_advertiser_contact',array($this,'advertiser_contact_form_ajax'));
		add_filter('theme_advertiser_templates',array($this,'addTemplates'));
		add_filter('template_include',array($this,'getTemplate'));

		add_shortcode('advertiser_contact_form',array($this,'advertiser_contact_form'));
		add_shortcode('advertiser_gallery',array($this,'advertiser_gallery'));
		add_shortcode('facebook_login',array($this,'facebookLogin'));
		add_shortcode('advertiser_contact_form',array($this,'advertiser_contact_form'));

	}

	//add default cpt.
	public function registerCpt(){
		//get options from settings about the title of the advertisers, singular and plural names.

		$cpt_settings = get_option('advertisers_plugin');
		$singular = $cpt_settings['cpt_singular_name'];
		$plural = $cpt_settings['cpt_plural_name'];
		$is_hierarchical = $cpt_settings['cpt_is_hierarchical'];


		$labels = [
			"name" => $plural,
			"singular_name" =>$singular,
			"menu_name" => $plural,

		];

		$args = array(
			"label" => $plural,
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => $is_hierarchical,
			"rewrite" => array( "slug" => "advertiser", "with_front" => true ),
			"query_var" => true,
			"menu_position" => 5,
			"supports" => array( "title", "editor", "thumbnail", "excerpt", "revisions", "author" ),
		);

		register_post_type( "advertiser", $args );
	}
	// add custom fields
	public function addMetaBox(){

		add_meta_box(
			'advertisers_options',
			'Advertisers Options',
			array( $this, 'renderAdvertiserOptions' ),
			'advertiser',
			'normal',
			'default'
		);

		add_meta_box(
			'advertisers_reviews',
			'Reviews',
			array( $this, 'displayRelatedReviews' ),
			'advertiser',
			'normal',
			'default'
        );



	}


    public function renderTextField(array $args){
	    $name  = $args['name'];
	    $id  = $args['id'];
	    $class  = $args['class'];
	    $value  = $args['value'];
	    $label  = $args['label'];

	    echo "<p>
                <label for='$id' >$label</label>
                <input type='text' name='$name' class='$class' value='$value' id='$id' />
            </p>";
    }

    public function render_editor(array $args){
	    $id  = $args['id'];
	    $value  = $args['value'];
	    $label  = $args['label'];
	    $args =isset($args['args'])?$args['args']:array('');
	    echo "<label for='$id' >$label</label>";
	    wp_editor( $value,$id,$args );
    }

	public function renderAdvertiserOptions($post){
	    //move all meta including every thing to here.
	    wp_nonce_field('advertisers_options','advertisers_options_nonce');
		$data = get_post_meta( $post->ID,'_advertisers_options_key',true);
		$header = isset($data['header'])?$data['header']:"";
		$bullets = isset($data['bullets'])?$data['bullets']:"";
		$curLevel = isset($data['curLevel'])?$data['curLevel']:"";
		$banner = isset($data['banner'])?$data['banner']:"";
		//contact fields
		$website = isset($data['website'])?$data['website']:"";
		$facebook = isset($data['facebook'])?$data['facebook']:"";
		$instagram = isset($data['instagram'])?$data['instagram']:"";
		$phone = isset($data['phone'])?$data['phone']:"";
		$address = isset($data['address'])?$data['address']:"";
		$opening_hours = isset($data['opening_hours'])?$data['opening_hours']:"";
		$emails = isset($data['emails'])?$data['emails']:"";
		//gallery fields
		$gallery = isset($data['gallery'])?$data['gallery']:"";
		$cover_image = isset($data['cover_image'])?$data['cover_image']:"";

		$fields = array(
			array(
				'name' => 'advertisers_options_website',
				'id'   => 'advertisers_options_website',
				'label'=> __('Website',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
				'class'=> '',
				'value'=> $website
			),
			array(
				'name' => 'advertisers_options_facebook',
				'id'   => 'advertisers_options_facebook',
				'label'=> __('Facebook Page',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
				'class'=> '',
				'value'=> $facebook
			), array(
				'name' => 'advertisers_options_instagram',
				'id'   => 'advertisers_options_instagram',
				'label'=> __('Instagram Page',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
				'class'=> '',
				'value'=> $instagram
			), array(
				'name' => 'advertisers_options_phone',
				'id'   => 'advertisers_options_phone',
				'label'=> __('Phone number',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
				'class'=> '',
				'value'=> $phone
			), array(
				'name' => 'advertisers_options_address',
				'id'   => 'advertisers_options_address',
				'label'=> __('Address',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
				'class'=> 'widefat',
				'value'=> $address
			), array(
				'name' => 'advertisers_options_opening_hours',
				'id'   => 'advertisers_options_opening_hours',
				'label'=> __('Opening hours',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
				'class'=> '',
				'value'=> $opening_hours,
                'type' => 'editor'
			), array(
				'name' => 'advertisers_options_emails',
				'id'   => 'advertisers_options_emails',
				'label'=> __('List of all emails for contact',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
				'class'=> 'widefat',
				'value'=> $emails
			),
		);

		?>
        <div class="options-box">
            <br/>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1">Advertiser Settings</a></li>
                <li><a href="#tab-2">Contact details</a></li>

                <li><a href="#tab-3">Gallery</a></li>
            </ul>

            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                     <h3>Advertiser meta</h3>
                    <p>

                        <label for="advertisers_options_header" ><?  echo __('Advertisers header',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
                        <input class="widefat" type="text" id="advertisers_options_header" name="advertisers_options_header" value="<? echo esc_attr($header);?>">
                    </p>
                    <p>
                        <label for="advertisers_options_bullets" ><?  echo __('Advertisers bullets',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
                        <?php
                        wp_editor($bullets,"advertisers_options_bullets", array('textarea_rows' => '5'));
                        ?>
                    </p>
                    <p>
                        <span>Choose the level for this advertiser</span>

                        <label for="advertisers_options_level" ><?  echo __('Advertisers level',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
                        <select id="advertisers_options_level" name="advertisers_options_level">
			                <?php
			                $levels = get_option('advertisers_plugin_levels');
			                foreach ($levels as  $level){
				                $name = esc_attr($level['title']);
				                $selected = selected($curLevel,$name);
				                echo '
                                 <option  value="'.$name.'" '.$selected.' >'.$name.'</option>';
			                }
			                ?>
                        </select>
                    </p>
                    <p>
                        <span>Here must be a relationship field</span>
                        <label for="advertisers_options_banner" ><?  echo __('Advertisers banner',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
                        <input type="text" id="advertisers_options_banner" name="advertisers_options_banner" value="<? echo esc_attr($banner);?>">
                    </p>

                </div>

                <div id="tab-2" class="tab-pane">
                    <h3>Contact details</h3>
	                <?php
	                foreach ($fields as $field){
	                    if(isset($field['type'])){
	                        if($field['type']=='editor'){
		                        $this->render_editor($field);
	                        }else{
		                    $this->renderTextField($field);
	                        }
	                    }else{
		                    $this->renderTextField($field);
	                    }
	                }
	                ?>
                </div>

                <div id="tab-3" class="tab-pane">
                    <h3>Gallery</h3>
                    <div>

                    <input class=" image-upload" id="advertisers_options_gallery" name="advertisers_options_gallery" type="hidden" value="<?php echo esc_attr($gallery)?>">
                        <div class="display_images">
                            <?php
                                $imgs = explode(',',$gallery);
                                foreach ($imgs as $img){
                                    if($img!=""){

                                    echo '<div class="gallery-image" style="background-image: url('.$img.');" ></div>';
                                    }
                                }
                            ?>
                        </div>
                    <button type="button" class="button button-primary js-image-upload multiple">Select Images</button>
                    </div>
                    <div>
                        <input class=" image-upload" id="advertisers_options_cover_image" name="advertisers_options_cover_image" type="hidden" value="<?php echo esc_url($cover_image); ?>">
                        <div class="display_images">
                            <?php
                                     echo '<div class="gallery-image" style="background-image: url('.esc_url($cover_image).');" ></div>';
                            ?>
                        </div>
                        <button type="button" class="button button-primary js-image-upload">Select Cover Image</button>
                    </div>
                </div>
            </div>

        </div>


    <?php
	}

	public function saveMetaBoxes($post_id){

		if(!isset($_POST['advertisers_options_nonce'])){
			return $post_id;
		}

		$nonce  = $_POST['advertisers_options_nonce'];
		if(!wp_verify_nonce($nonce,'advertisers_options')){
			return $post_id;
		}
		if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE){
			return $post_id;
		}
		if(!current_user_can('edit_post',$post_id)){
			return $post_id;
		}
		$data = array(
           'header' => sanitize_text_field($_POST['advertisers_options_header']),
           'bullets' => isset($_POST['advertisers_options_bullets'])?$_POST['advertisers_options_bullets']:"",
           'curLevel' => sanitize_text_field($_POST['advertisers_options_level']),
           'banner' => sanitize_text_field($_POST['advertisers_options_banner']),
            //contact fields
           'website' => sanitize_text_field($_POST['advertisers_options_website']),
           'facebook' => sanitize_text_field($_POST['advertisers_options_facebook']),
           'instagram' => sanitize_text_field($_POST['advertisers_options_instagram']),
           'phone' => sanitize_text_field($_POST['advertisers_options_phone']),
           'address' => sanitize_text_field($_POST['advertisers_options_address']),
           'opening_hours' => isset($_POST['advertisers_options_opening_hours'])?$_POST['advertisers_options_opening_hours']:"",
           'emails' => sanitize_text_field($_POST['advertisers_options_emails']),
            //gallery fields
           'gallery' => $_POST['advertisers_options_gallery'],
			'cover_image' =>  $_POST['advertisers_options_cover_image'],

	);

		update_post_meta($post_id,'_advertisers_options_key',$data);


	}

	public function displayRelatedReviews($post){
            // display a table with the reviews and set ajax to post with js the changes made.
            ?>
            <div class="reviews-table">

                <span>
                    Name
                </span>
                <span>
                    Email
                </span>
                <span>
                    Rating
                </span>
                <span>
                    Approved
                </span>
                <span>
                    Featured
                </span>
                <span>
                    Header
                </span>
                <span>
                    Content
                </span>

                <?php
                $reviews = $this->getAdvertisersReviews($post->ID);
                foreach ($reviews as $review){
	                    $data = get_post_meta($review->ID,'_advertisers_reviews_key',true);

	                    $name = isset($data['name'])?$data['name']:'';
	                    $email = isset($data['email'])?$data['email']:'';
	                    $rating = isset($data['rating'])?$data['rating']:0;
	                    $approved = (isset($data['approved']))?$data['approved']?'YES':'NO':'NO';
	                    $featured =  (isset($data['featured']))?$data['featured']?'YES':'NO':'NO';
	                    ?>
                                <div><a href="<? echo get_edit_post_link($review->ID)?>"><? echo $name; ?></a></div>
                                <div><? echo $email; ?></div>
                                <div><? echo $rating; ?></div>
                                <div><? echo $approved; ?></div>
                                <div><? echo $featured; ?></div>
                                <div><? echo $review->post_title; ?></div>
                                <div><? echo $review->post_content; ?></div>
                        <?php
                    }
                ?>
            </div>
            <?php



    }

    public function registerTax(){

	    // register expertise.
	    $tax_settings = get_option('advertisers_plugin');
        $single = $tax_settings['taxonomy_singular_name'];
        $plural = $tax_settings['taxonomy_plural_name'];

       $taxes = array(
               'expertise' => array(
                   'single'=>$single,
                    'plural'=> $plural,
                    'hierarchical' => false,
                    'supports' =>  array( 'advertiser' )
               ),
                'profession' => array(
	                'single'=> __('Profession',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
	                'plural'=> __('Professions',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
	                'hierarchical' => true,
	                'supports' =>  array( 'advertiser' )
                )
       );

       $this->registerTaxes($taxes);

	    // register profession



    }

    public function addTemplates($templates){

        $templates = array_merge($templates,$this->templates);
        return $templates;

    }

    public function getTemplate($template){
	    global $post;

	    if ( ! $post ) {
		    return $template;
	    }

	    $template_name = get_post_meta( $post->ID, '_wp_page_template', true );

	    if ( ! isset( $this->templates[$template_name] ) ) {
		    return $template;
	    }

	    $file = ADVERTISERS_INDEX_PLUGIN_PATH . $template_name;

	    if ( file_exists( $file ) ) {
		    return $file;
	    }

	    return $template;
    }

    public static function getAdvertisersReviews($post_id,$args = array()){
	    $value = '"advertiser_id";s:'.self::count_digits($post_id).':"'.$post_id.'"';
	    $args = array_merge($args, array(
		    'post_type' => 'review',
		    'meta_query'=> array(
			    array(
				    'key' => '_advertisers_reviews_key',
				    'value'=> $value,
				    'compare'=> 'LIKE'
			    )
		    )
	    ));

	    return get_posts($args);
    }
    public static function count_digits($x){
	    $count =1;
        while($x>=10){
            $x =  $x * 0.1;
            $count++;
        }
        return $count;
    }

    public function advertiser_contact_form(){
	    ob_start();
	    echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/contact_form.css\" type=\"text/css\" media=\"all\" />";
	    require_once("$this->plugin_path/page-templates/template-parts/contact_form.php");
	    echo "<script src=\"$this->plugin_url/assets/contact_form.js\"></script>";
	    return ob_get_clean();
    }


    public function advertiser_contact_form_ajax(){
        // verify nonce
	    if (
		    ! isset( $_POST['advertiser_contact_nonce'] )
		    || ! wp_verify_nonce( $_POST['advertiser_contact_nonce'], 'advertiser_contact_nonce')
	    ) {

		    exit('The form is not valid');

	    }


	    $response = array(
		    'error' => false,
	    );

	    if (trim($_POST['phone']) == ''||trim($_POST['name']) == '') {
		    $response['error'] = true;
		    $response['error_message'] = 'Fields name anf phone are required';
		    exit(json_encode($response));
	    }
        // get post id
        global $post;
	    $template_name = get_post_meta( $post->ID, '_wp_page_template', true );
	    $sendToAdvertiser = $template_name=='Advertiser Level 1';
	    $to = array(get_option('admin_email'));
	    // get advertiser level
	    if($sendToAdvertiser){
	        $advertiser_data =  get_post_meta($post->ID,'_advertisers_options_key',true);
		    $emails = isset($advertiser_data['emails'])?explode(',',trim($advertiser_data['emails'])):array();
	        $to = array_merge($to,$emails);
	    }
	    //TODO: must have an emails option to complete in settings for sending the email.
        $website_name = get_option('blogname');
	    $name = sanitize_text_field($_POST['name']);
	    $phone = sanitize_text_field($_POST['phone']);
	    $email = sanitize_email($_POST['email']);

	    $subject = "ליד חדש מהאתר $website_name ";
        $message = "
            פרטי הליד:
            שם: $name
            טלפון: $phone
            אימייל: $email 
        ";
	    $is_mail_ok =  wp_mail( $to, $subject, $message );
	    if(!$is_mail_ok){
		    $response['error'] = true;
		    $response['error_message'] = 'There was a problem with sending the email';
	    }
        // add entry in db?
	    // Don't forget to exit at the end of processing
	    exit(json_encode($response));
    }


   public function advertiser_gallery(){
	    ob_start();
	   echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/gallery.css\" type=\"text/css\" media=\"all\" />";
	   require_once("$this->plugin_path/page-templates/template-parts/gallery.php");
	   echo "<script src=\"$this->plugin_url/assets/gallery.js\"></script>";
	    return ob_get_clean();
    }

    public function facebookLogin(){
	    // get all reviews that are approved but not featured.
        // display them.
        // add a form to which can be filled only by signing in with facebook.
        ob_start();
        echo '<div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/he_IL/sdk.js#xfbml=1&version=v8.0&appId=245301383583073&autoLogAppEvents=1" nonce="LnbKGRpa"></script>';
        echo '<div class="fb-comments" data-href="'.get_the_permalink().'" data-lazy="true" data-numposts="20" data-width="666" ></div>';
        return ob_get_clean();
    }

}