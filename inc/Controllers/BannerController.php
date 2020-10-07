<?php
/**
 * @package  AdvertisersIndex
 */


namespace Inc\Controllers;


use Inc\Base\BaseController;

class BannerController extends BaseController {

	public function register(){
		$banner_slug =$this->cpts['banner'];
	    //add Cpt.
		add_action('init',array($this,'addCpt'));
		//add tax zones?
		add_action('init',array($this,'addTax'));
		//add metabox
		add_action('add_meta_boxes',array($this,'addMetaBox'));
		//save metaBox
		add_action("save_post_$banner_slug",array($this,'saveMetaBox'));
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
			"rewrite" => array( "slug" =>$this->cpts['banner'], "with_front" => true ),
			"query_var" => true,
			"menu_position" => 5,
			"supports" => array( "title")
		);
		register_post_type($this->cpts['banner'],$args);
	}

	public function addTax(){
        $this->registerTaxes(array(
                $this->taxes['banner_zones']=> array(
                        'single' =>'Banner Zone',
                        'plural' =>'Banner Zones',
                        'hierarchical'      => false,
                        'supports' => array( $this->cpts['advertiser'],$this->cpts['banner'] )
                )
        ));
	}

	public function addMetaBox(){
		add_meta_box(
			'banners_options',
			 __('Banner Fields',ADVERTISERS_INDEX_PLUGIN_DOMAIN),
			array( $this, 'renderBannerFields' ),
			$this->cpts['banner'],
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
                <label for="banners_options_link"><? echo __('Link to follow when banner is clicked',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></label>
                <input type="url" id="banners_options_link" placeholder="url" name="banners_options_link" value="<?php echo esc_url($banner_link); ?>">
			<div>
				<input class=" image-upload" id="banners_options_banner_desktop" name="banners_options_banner_desktop" type="hidden" value="<?php echo esc_url($banner_desktop); ?>">
				<? echo __('banner sizes',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?>. 160 x 380
				<div class="display_images">
					<?php
					echo '<div class="gallery-image" style="background-image: url('.esc_url($banner_desktop).');" ></div>';
					?>
				</div>
				<button type="button" class="button button-primary js-image-upload"><? echo __('Select Banner for desktop',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></button>
			</div>
			<div>
				<input class=" image-upload" id="banners_options_banner_mobile" name="banners_options_banner_mobile" type="hidden" value="<?php echo esc_url($banner_mobile); ?>">
				<div class="display_images">
					<?php
					echo '<div class="gallery-image" style="background-image: url('.esc_url($banner_mobile).');" ></div>';
					?>
				</div>
				<button type="button" class="button button-primary js-image-upload"><? echo __('Select Banner for mobile',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></button>
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
	    $zones = get_the_terms($post->ID,$this->taxes['banner_zones']);
	    $numberosts = isset($attributes['numAds'])?intval($attributes['numAds']):2;
	    if($zones) {
		    $terms = array_map( function ( $tax ) {
			    return $tax->term_id;
		    }, $zones );
            $banners = get_posts(array(
                    'post_type'=>$this->cpts['banner'],
                    'numberposts' => $numberosts,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $this->taxes['banner_zones'],
                            'field' => 'term_id',
                            'terms' => $terms,
                        )
                    )

            ));
	    }else{
	        $banners = get_posts(array(
	                'post_type' => $this->cpts['banner'],
                    'numberposts' => $numberosts
            ));
	    }

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