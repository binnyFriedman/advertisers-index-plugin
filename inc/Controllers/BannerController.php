<?php
/**
 * @package  AdvertisersIndex
 */


namespace Inc\Controllers;


class BannerController {

	public function register(){
		//add Cpt.
		add_action('init',array($this,'addCpt'));
		//add tax zones?
		add_action('init',array($this,'addTax'));
		//add metabox
		add_action('add_meta_boxes',array($this,'addMetaBox'));
		//save metaBox
		add_action('save_post_banner',array($this,'saveMetaBox'));
		//add shortcode
        add_shortcode('advertiser_banners', array($this,'displayBanners'));


	}

	public function addCpt(){
		$labels = [
			"name" => __('Banners',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
			"singular_name" =>__('Banner',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
			"menu_name" => __('Banners',ADVERTISERS_INDEX_PLUGIN_DOMAIN),

		];

		$args = array(
			"label" => __('Banners',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => true,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "banner", "with_front" => true ),
			"query_var" => true,
			"menu_position" => 5,
			"supports" => array( "title")
		);
		register_post_type('banner',$args);
	}

	public function addTax(){
		$plural = 'Banner Zones';
		$single = 'Banner Zone';
		$labels = array(
			'name'              => _x( $plural, 'taxonomy general name', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'singular_name'     => _x( $single, 'taxonomy singular name', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'search_items'      => __( "Search $plural", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'all_items'         => __( "All $plural", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'parent_item'       => __( "Parent $single", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'parent_item_colon' => __( "Parent $single:", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'edit_item'         => __( "Edit $single", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'update_item'       => __( "Update $single", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'add_new_item'      => __( "Add New $single", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'new_item_name'     => __( "New $single Name", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'menu_name'         => __( $single, ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'banner_zones' ),
		);

		register_taxonomy( 'banner_zones', array( 'advertiser','banner' ), $args );
	}

	public function addMetaBox(){
		add_meta_box(
			'banners_options',
			'Banner Fields',
			array( $this, 'renderBannerFields' ),
			'banner',
			'normal',
			'default'
		);

	}

	public function renderBannerFields($post){
		wp_nonce_field('banners_options','banners_options_nonce');
		$data = get_post_meta($post->ID,'_banners_options_key',true);
		$banner_desktop =  isset($data['banner_desktop'])?$data['banner_desktop']:"";
		$banner_mobile =  isset($data['banner_mobile'])?$data['banner_mobile']:"";
		$banner_link =  isset($data['link'])?$data['link']:"";
		?>
		<div class="options-box">
                <label for="banners_options_link">לינק אליו מוביל הבאנר</label>
                <input type="url" id="banners_options_link" placeholder="url" name="banners_options_link" value="<?php echo esc_url($banner_link); ?>">
			<div>
				<input class=" image-upload" id="banners_options_banner_desktop" name="banners_options_banner_desktop" type="hidden" value="<?php echo esc_url($banner_desktop); ?>">
				//options for banners? banner sizes. 160 x 380
				<div class="display_images">
					<?php
					echo '<div class="gallery-image" style="background-image: url('.esc_url($banner_desktop).');" ></div>';
					?>
				</div>
				<button type="button" class="button button-primary js-image-upload">Select Banner for desktop</button>
			</div>
			<div>
				<input class=" image-upload" id="banners_options_banner_mobile" name="banners_options_banner_mobile" type="hidden" value="<?php echo esc_url($banner_mobile); ?>">
				<div class="display_images">
					<?php
					echo '<div class="gallery-image" style="background-image: url('.esc_url($banner_mobile).');" ></div>';
					?>
				</div>
				<button type="button" class="button button-primary js-image-upload">Select Banner for mobile</button>
			</div>
		</div>
		<?php
	}


	public function saveMetaBox($post_id){

		if(!isset($_POST['banners_options_nonce'])){
			return $post_id;
		}

		$nonce  = $_POST['banners_options_nonce'];
		if(!wp_verify_nonce($nonce,'banners_options')){
			return $post_id;
		}
		if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE){
			return $post_id;
		}
		if(!current_user_can('edit_post',$post_id)){
			return $post_id;
		}

		$data = array(
			'banner_desktop' => isset($_POST['banners_options_banner_desktop'])?$_POST['banners_options_banner_desktop']:"",
			'banner_mobile' => isset($_POST['banners_options_banner_mobile'])?$_POST['banners_options_banner_mobile']:"",
			'link' => isset($_POST['banners_options_link'])?$_POST['banners_options_link']:"",
		);

		update_post_meta($post_id,'_banners_options_key',$data);


	}

	public function displayBanners($attributes){

	    global $post;
	    $zones = get_the_terms($post->ID,'banner_zones');
	    $numberosts = isset($attributes['numAds'])?intval($attributes['numAds']):2;
	    if($zones) {
		    $terms = array_map( function ( $tax ) {
			    return $tax->term_id;
		    }, $zones );
            $banners = get_posts(array(
                    'post_type'=>'banner',
                    'numberposts' => $numberosts,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'banner_zones',
                            'field' => 'term_id',
                            'terms' => $terms, /// Where term_id of Term 1 is "1".
                        )
                    )

            ));
	    }else{
	        $banners = get_posts(array(
	                'post_type' => 'banner',
                    'numberposts' => $numberosts
            ));
	    }
	    // get banners of first zone up to the amount specified in numAds;

//        echo var_dump($terms);
        foreach ($banners as $banner){
            $banner_data = get_post_meta($banner->ID,'_banners_options_key',true);
	        $banner_desktop =  isset($banner_data['banner_desktop'])?$banner_data['banner_desktop']:"";
	        $banner_mobile =  isset($banner_data['banner_mobile'])?$banner_data['banner_mobile']:"";
	        $banner_link =  isset($banner_data['link'])?$banner_data['link']:"";
	        ?>
            <div class="banner--wrapper">
                <a href="<? echo $banner_link?>" >
                    <img src="<? echo wp_is_mobile()?$banner_mobile:$banner_desktop; ?>" alt="<? echo $banner->post_title?>" />
                </a>
            </div>
            <?php

        }
	}

}