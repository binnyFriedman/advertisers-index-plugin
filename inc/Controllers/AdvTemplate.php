<?php
/**
 * @package Advertisers-index
 */

namespace Inc\Controllers;
use Inc\Base\BaseController;
use WP_Query;

class AdvTemplate extends BaseController {



	public $meta = array();
	public $professions = array();
	public $options = array();
	public $profession;
	public $post;
	/**
	 * @var mixed|string
	 */
	public $secondary_color;
	/**
	 * @var mixed|string
	 */
	public $primary_color;

	public function __construct(){
		parent::__construct();
		global $post;
		$this->post = $post;
		$this->meta = Advertiser::get_advertiser_meta($this->post->ID);
		$this->professions = get_the_terms($this->post->ID,$this->taxes['profession']);
		$this->profession = isset($this->professions[0])?$this->professions[0]->name:"";
		$this->options = get_option('advertisers_template_options');
		$this->primary_color = isset($this->options['template_primary_color'])?$this->options['template_primary_color']:'#F37F94';
		$this->secondary_color = isset($this->options['template_secondary_color'])?$this->options['template_secondary_color']:'#E88E9E';

	}

	public function get_base_style(){
		ob_start();
		?>
		<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
		<style>
		    @import url('https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;600;700;800&display=swap');

		    :root {
		        --secondery-color: <? echo $this->secondary_color; ?>;
		        --primary-color: <? echo $this->primary_color; ?>;

		        font-family: 'Assistant', sans-serif;
		        font-size: 12px;

		    }

		    html, body {
		        direction: rtl;
		        font-family: 'Assistant', sans-serif;
		    }

		    .bullets ul {
		        padding-right: 25px;
		    }

		    .bullets li::before {
		        content: "";
		        border: 8px var(--secondery-color) solid !important;
		        border-radius: 50px;
		        margin-top: 5px;
		        margin-right: -34px;
		        position: absolute;
		    }

		    .bullets li {
		        margin: 0.5rem 1rem 0 0;
		        font-weight: normal;
		        font-size: 20px;
		        line-height: 26px;
		    }

		    .text-primary {
		        color: var(--primary-color);
		    }

		    .text-secondary {
		        color: var(--secondery-color);
		    }

		    h1 {
		        font-style: normal;
		        font-weight: bold;
		        font-size: 42px;
                line-height: 59px;
		    }

		    h2 {
		        font-weight: normal;
		        font-size: 30px;
		        line-height: 39px;
		        color: #000000;
		    }

		    .contact-buttons span {
		        background: var(--secondery-color);
		        color: white;
		        margin-left: 17px;
		        display: flex;
		    }

		    .social {
		        width: 46px;
		        height: 46px;
		    }
		    .breadcrums-cover{
		        background: var(--primary-color);
		        color: white;
		        font-size: 18px;
		        line-height: 23.54px;
		    }
		    .p-content{
		        font-weight: normal;
		        font-size: 20px;
		        line-height: 26px;
		        margin-bottom: 40px;
		    }
		    h3{
		        font-weight: bold;
		        font-size: 24px;
		        line-height: 31px;
		        padding-bottom: 16px;
		    }

		    .expertise span{
		        font-size: 20px;
		        line-height: 26px;
		        border: black solid thin;
		        padding: 10px 13px;
		        margin-left: 12px;
		        margin-bottom: 10px;
		    }
		    .featured-testimonials .slider--outer-wrapper {
		        background: linear-gradient(to left,var(--primary-color),#F291A2,var(--secondery-color));
		        color: white;
		    }
		    .contact-form h3{
		        font-weight: normal;
		        font-size: 30px;
		        line-height: 39px;
		        color: #686868;
		    }
		    .sec-col{
		        padding-right: 104px;
		    }
		    .contact-info span{
		        font-size: 20px;
		        line-height: 26px;
		        text-align: right;
		        color: #000000;
		    }

		    .ad-zones{
		        background: #F8F8F8;
		        padding: 36px;
		    }
		    .banner--wrapper{
		        margin-bottom: 36px;
		    }
		    img{
		        border: none;
		    }
		    h4{
		        font-style: normal;
		        font-weight: normal;
		        font-size: 18px;
		        line-height: 24px;
		        color: #000000;
		    }
		    .related-advertisers {

		    }

		</style>
		<?php
		return ob_get_clean();
	}


	public function get_hero(){
	    ?>
                <div class="py-20 md:pt-40 px-6 bg-opacity-75 bg-center  bg-no-repeat bg-cover text-center"
             style="box-shadow: inset 0 0 0 2000px rgb(255 255 255 / 75%);background-image: url('<?php echo esc_url( $this->meta['cover_image'] ) ?>');">
            <div class="inline-flex justify-center flex-wrap mx-auto">
                <div class="rounded-full  bg-center bg-no-repeat"
                     style="width: 214px;height: 214px; background-image: url('<? echo get_the_post_thumbnail_url( $this->post->ID, 'full' ); ?>')"></div>
                <div class="text-right  px-10">
                    <h1 class="text-primary"><? echo $this->post->post_title; ?><? echo " - ".$this->profession; ?> </h1>
                    <h2 class="text-center md:text-right"><? echo $this->meta['header']; ?></h2>
                    <div class="bullets list-disc text-3xl mb-4">
                        <? echo $this->meta['bullets']; ?>
                    </div>
                    <div class="contact-buttons  flex flex-wrap justify-center">
                        <?php if ( $this->meta['phone'] != "" ): ?>
                            <span class="px-20 mb-8 lg:px-24 py-3 ">
                     <a class="flex" href="tel:<? echo $this->meta['phone']; ?>">
                            <span class="my-auto">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M6.62 10.79C8.06 13.62 10.38 15.93 13.21 17.38L15.41 15.18C15.68 14.91 16.08 14.82 16.43 14.94C17.55 15.31 18.76 15.51 20 15.51C20.55 15.51 21 15.96 21 16.51V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z"
                                       fill="white"/>
                            </svg>
                            </span>
                         <span>
                        צרו קשר
                         </span>
                     </a>
                    </span>
                        <? endif ?>
                        <?php if ( $this->meta['website'] != "" ): ?>
                            <span class="p-3 rounded-full social text-center">
                        <a class="m-auto"  href="<? echo esc_url( $this->meta['website'] ); ?>">
                        <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.48 3V2.7C21.4813 2.3459 21.4127 1.99503 21.2781 1.66751C21.1435 1.33999 20.9456 1.04226 20.6956 0.791415C20.4457 0.540565 20.1487 0.341526 19.8217 0.205716C19.4947 0.0699063 19.1441 -2.4467e-06 18.79 0H3.20998C2.85588 -2.4467e-06 2.50526 0.0699063 2.17824 0.205716C1.85122 0.341526 1.55424 0.540565 1.30432 0.791415C1.05439 1.04226 0.85646 1.33999 0.721864 1.66751C0.587268 1.99503 0.518661 2.3459 0.519977 2.7V3H21.48Z"
                                  fill="white"/>
                            <path d="M21.48 5H0.479999V18.17C0.478677 18.5236 0.547354 18.874 0.682071 19.201C0.816788 19.5279 1.01488 19.825 1.26493 20.0751C1.51499 20.3251 1.81206 20.5232 2.13902 20.6579C2.46598 20.7926 2.81637 20.8613 3.17 20.86H18.79C19.1436 20.8613 19.494 20.7926 19.821 20.6579C20.1479 20.5232 20.445 20.3251 20.6951 20.0751C20.9451 19.825 21.1432 19.5279 21.2779 19.201C21.4126 18.874 21.4813 18.5236 21.48 18.17V5ZM9.85 12.75L8.52 17.75C8.47128 17.9362 8.37413 18.1061 8.23844 18.2426C8.10274 18.3791 7.93333 18.4772 7.74744 18.5269C7.56154 18.5767 7.36577 18.5764 7.18004 18.526C6.99431 18.4756 6.82523 18.3769 6.69 18.24L5.57 17.1L3.87 18.81C3.77656 18.9027 3.66574 18.976 3.54391 19.0258C3.42207 19.0755 3.29161 19.1008 3.16 19.1C3.02839 19.1008 2.89793 19.0755 2.77609 19.0258C2.65426 18.976 2.54344 18.9027 2.45 18.81C2.35627 18.717 2.28188 18.6064 2.23111 18.4846C2.18034 18.3627 2.1542 18.232 2.1542 18.1C2.1542 17.968 2.18034 17.8373 2.23111 17.7154C2.28188 17.5936 2.35627 17.483 2.45 17.39L4.16 15.69L3.05 14.58C2.91353 14.4437 2.81531 14.2738 2.76519 14.0876C2.71508 13.9013 2.71483 13.7051 2.76447 13.5187C2.81411 13.3323 2.91189 13.1622 3.04801 13.0256C3.18413 12.8889 3.3538 12.7904 3.54 12.74L8.54 11.41C8.72367 11.3655 8.91576 11.3695 9.09742 11.4216C9.27908 11.4737 9.44406 11.5722 9.57618 11.7073C9.70829 11.8425 9.803 12.0097 9.851 12.1925C9.89901 12.3752 9.89866 12.5674 9.85 12.75Z"
                                  fill="white"/>
                            </svg>

                        </a>
                    </span>
                        <? endif ?>
                        <?php if ( $this->meta['instagram'] != "" ): ?>
                            <span class="p-3 rounded-full social text-center">
                        <a class="m-auto" href="<? echo esc_url( $this->meta['instagram'] ); ?>">
                           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.33 1.52H4.67002C3.83459 1.52 3.03337 1.85188 2.44263 2.44262C1.85189 3.03336 1.52002 3.83457 1.52002 4.67V19.33C1.52002 20.1654 1.85189 20.9667 2.44263 21.5574C3.03337 22.1481 3.83459 22.48 4.67002 22.48H19.33C20.1655 22.48 20.9667 22.1481 21.5574 21.5574C22.1481 20.9667 22.48 20.1654 22.48 19.33V4.67C22.48 3.83457 22.1481 3.03336 21.5574 2.44262C20.9667 1.85188 20.1655 1.52 19.33 1.52ZM12 17.29C10.9538 17.29 9.93099 16.9798 9.06105 16.3985C8.19112 15.8172 7.51308 14.991 7.1127 14.0244C6.71231 13.0578 6.60755 11.9941 6.81167 10.968C7.01578 9.94182 7.5196 8.99923 8.25942 8.25941C8.99924 7.51959 9.94183 7.01577 10.968 6.81165C11.9942 6.60753 13.0578 6.71229 14.0244 7.11268C14.991 7.51307 15.8172 8.1911 16.3985 9.06104C16.9798 9.93097 17.29 10.9537 17.29 12C17.29 13.403 16.7327 14.7485 15.7406 15.7406C14.7485 16.7327 13.403 17.29 12 17.29ZM18.82 6.78C18.515 6.78 18.2169 6.68942 17.9634 6.51976C17.7099 6.35009 17.5126 6.10899 17.3963 5.827C17.2801 5.54502 17.2501 5.23487 17.3104 4.93587C17.3706 4.63687 17.5183 4.36249 17.7347 4.14752C17.951 3.93255 18.2264 3.78667 18.5258 3.72839C18.8251 3.6701 19.1351 3.70203 19.4163 3.82012C19.6975 3.93821 19.9373 4.13716 20.1054 4.39172C20.2734 4.64628 20.362 4.945 20.36 5.25C20.3574 5.6567 20.194 6.04584 19.9054 6.33249C19.6169 6.61914 19.2267 6.78001 18.82 6.78Z" fill="white"/>
                        <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" fill="white"/>
                        </svg>
                        </a>
                    </span>
                        <? endif ?>
                        <?php if ( $this->meta['facebook'] != "" ): ?>
                            <span class="p-3 rounded-full social text-center">
                        <a class="m-auto" href="<? echo esc_url( $this->meta['facebook'] ); ?>">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.9 4.17V1.68C17.9014 1.56235 17.879 1.44562 17.834 1.33689C17.789 1.22817 17.7224 1.12969 17.6383 1.04743C17.5542 0.965166 17.4542 0.900825 17.3445 0.858297C17.2348 0.815769 17.1176 0.795938 17 0.800004H12.57C12.1512 0.799985 11.7365 0.882963 11.3499 1.04414C10.9634 1.20532 10.6126 1.44151 10.3178 1.73906C10.023 2.0366 9.79017 2.38961 9.63264 2.77768C9.47511 3.16575 9.39604 3.5812 9.4 4V9H7C6.8849 9 6.77095 9.02283 6.66474 9.06717C6.55853 9.11152 6.46217 9.1765 6.38126 9.25835C6.30034 9.3402 6.23646 9.43729 6.19333 9.544C6.1502 9.65071 6.12868 9.76492 6.13 9.88V12.38C6.13 12.6107 6.22166 12.832 6.38482 12.9952C6.54798 13.1583 6.76926 13.25 7 13.25H9.4V22.5C9.40263 22.7317 9.49651 22.9529 9.66126 23.1158C9.826 23.2787 10.0483 23.37 10.28 23.37H13.28C13.5117 23.37 13.734 23.2787 13.8987 23.1158C14.0635 22.9529 14.1574 22.7317 14.16 22.5V13.28H17C17.2307 13.28 17.452 13.1883 17.6152 13.0252C17.7783 12.862 17.87 12.6407 17.87 12.41V9.91C17.8754 9.79243 17.8569 9.67499 17.8156 9.56477C17.7743 9.45456 17.7111 9.35387 17.6298 9.2688C17.5484 9.18373 17.4507 9.11604 17.3424 9.06984C17.2342 9.02364 17.1177 8.99988 17 9H14.1V5.93C14.0986 5.81235 14.121 5.69562 14.166 5.58689C14.211 5.47817 14.2776 5.37969 14.3617 5.29743C14.4458 5.21517 14.5458 5.15082 14.6555 5.1083C14.7652 5.06577 14.8824 5.04594 15 5.05H17C17.1176 5.05407 17.2348 5.03424 17.3445 4.99171C17.4542 4.94918 17.5542 4.88484 17.6383 4.80258C17.7224 4.72032 17.789 4.62184 17.834 4.51311C17.879 4.40439 17.9014 4.28766 17.9 4.17Z"
                                  fill="white"/>
                            </svg>

                        </a>
                    </span>
                        <? endif ?>


                    </div>
                </div>
            </div>
        </div>
        <?php
	}

	public function get_breadcrums(){
	    // check if there is a breadcrums plugin installed

	    ?>
		<div class="breadcrums-cover px-8 lg:px-40 py-10 ">
			<span class="container"> בית > מומחים > <?php echo the_title();?></span>
		</div>
	<?php
	}


	public function print_expertise($with_link =false){
		?>
		<div class="my-10">
			<h3 class="expertise"><? echo get_taxonomy($this->taxes['expertise'])->labels->name;?></h3>
			<div class="py-5 expertise flex flex-wrap">
				<?
				$expertises = get_the_terms($this->post->ID,$this->taxes['expertise']);
				foreach ($expertises as $expertise){
					?>
                    <? if($with_link): ?>
                    <span><a href="<? echo get_term_link($expertise);?>" title="<? echo $expertise->name?>" > <? echo $expertise->name; ?></a></span>
                        <? else: ?>
                    <span> <? echo $expertise->name; ?></span>
                    <? endif; ?>
					<?
				}
				?>
			</div>

		</div>
		<?php
	}

	public function print_contact_info(){
		ob_start();
	    ?>
		<div class="contact-info my-20" >
					<? if($this->meta['address']!=''): ?>
						<div class="flex">
                    <span class="pl-2 my-auto">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.375 2C8.62594 2 5.59375 5.13 5.59375 9C5.59375 14.25 12.375 22 12.375 22C12.375 22 19.1562 14.25 19.1562 9C19.1562 5.13 16.1241 2 12.375 2ZM12.375 11.5C11.0381 11.5 9.95312 10.38 9.95312 9C9.95312 7.62 11.0381 6.5 12.375 6.5C13.7119 6.5 14.7969 7.62 14.7969 9C14.7969 10.38 13.7119 11.5 12.375 11.5Z" fill="#E88E9E"/>
                        </svg>
                    </span>
							<span class="pl-2 font-bold" ><? echo __('Address:',ADVERTISERS_INDEX_PLUGIN_DOMAIN);?>  </span>
							<span ><? echo $this->meta['address']; ?></span>
						</div>
					<? endif; ?>
					<? if($this->meta['phone']!=''): ?>
						<div class="flex">
                        <span class="pl-2 my-auto">
                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.62 10.79C8.06 13.62 10.38 15.93 13.21 17.38L15.41 15.18C15.68 14.91 16.08 14.82 16.43 14.94C17.55 15.31 18.76 15.51 20 15.51C20.55 15.51 21 15.96 21 16.51V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z" fill="#E88E9E"/>
                            </svg>
                        </span>
							<span class="pl-2 font-bold" >טלפון:<? echo __('Phone number:',ADVERTISERS_INDEX_PLUGIN_DOMAIN);?> </span>
							<span ><a href="tel:<? echo $this->meta['phone']; ?>" ><? echo $this->meta['phone']; ?></a></span>
						</div>
					<? endif; ?>
					<? if($this->meta['opening_hours']!=''): ?>
						<div class="flex">
                        <span class="pl-2 mt-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="12.5" cy="12" rx="9.5" ry="10" fill="#E88E9E"/>
                                <path d="M12.8594 7H11.4062V13L16.4922 16.15L17.2188 14.92L12.8594 12.25V7Z" fill="white"/>
                            </svg>
                            </span>
							<div>
								<span class=" font-bold" ><? echo __('Opening hours:',ADVERTISERS_INDEX_PLUGIN_DOMAIN);?> </span>
								<span class="w-full"><? echo $this->meta['opening_hours']; ?></span>
							</div>
						</div>
					<? endif; ?>
				</div>
				<?php
        return ob_get_clean();
	}


	public function more_advertisers(){
		ob_start();
	    ?>
		<h2 class="font-bold" ><? echo isset($this->options['more_advertisers'])?$this->options['more_advertisers']:__('For more experts in this field',ADVERTISERS_INDEX_PLUGIN_DOMAIN);  ?></h2>
		<div class="related-advertisers">
			<div class="slider--outer-wrapper">
				<div class="slider--wrapper">
					<div class="slider--container">
						<div class="slider--view">
							<ul>
								<?php
								//Query more advertisers with same taxonomies,
								// Create separate custom field for profession
								//Get array of terms
								$terms = get_the_terms( $this->post->ID , $this->taxes['expertise']);
								//Pluck out the IDs to get an array of IDS
								$term_ids = wp_list_pluck($terms,'term_id');
								$more_advertisers = new WP_Query( array(
									'post_type' => $this->cpts['advertiser'],
									'tax_query' => array(
										array(
											'taxonomy' => $this->taxes['expertise'],
											'field' => 'id',
											'terms' => $term_ids,
											'operator'=> 'IN' //Or 'AND' or 'NOT IN'
										)),
									'ignore_sticky_posts' => 1,
									'orderby' => 'rand',
									'post__not_in'=>array($this->post->ID)
								) );
								//Loop through posts and display...
								$count = 0;
								$is_mobile= wp_is_mobile();
								if($more_advertisers->have_posts()) {
									while ($more_advertisers->have_posts() ) : $more_advertisers->the_post();
										$professions = get_the_terms(null, $this->taxes['profession']);
										$profession = isset($professions[0])?$professions[0]->name:"";
										?>
										<? if($count%4==0||$is_mobile): ?>
											<li class="slider--view__slides <? echo $count==0?"is-active":"";?>">
											<div class="flex lg:grid lg:grid-cols-4 place-items-center lg:gap-x-10">
										<? endif;
										$count++;
										?>

										<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
											<?php if (has_post_thumbnail()) { ?>
												<div class="bg-cover bg-center bg-no-repeat rounded-full mb-6" style="width: 164px;height: 164px; background-image: url('<?php the_post_thumbnail_url(); ?>')" ></div>
											<?php } else { ?>
												<?php the_title(); ?>
											<?php } ?>
											<h3 class="font-normal pb-0"><?php the_title(); ?></h3>
											<h4 ><?php echo $profession; ?></h4>
										</a>

										<? if($count%4==0||$is_mobile): ?>
											</div>
											</li>
										<? endif; ?>

									<?php endwhile; wp_reset_query(); ?>
								<?php } ?>
							</ul>
							<? if($is_mobile&&$count>1||$count>4): ?>
								<div class="slider--arrows">
                        <span class="arrow slider--arrows__right" >
                    <svg width="27" height="28" viewBox="0 0 27 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0334 2.09284L24.0668 14L12.0334 25.9072" stroke="#E88E9E" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                        </span>
									<span class="arrow slider--arrows__left" >
                       <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.0334 25.8144L3.00001 13.9072L15.0334 2.00007" stroke="#E88E9E" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        </span>
								</div>
							<? endif; ?>
						</div>
					</div>
				</div>
			</div>


		</div>
		<?php
        return ob_get_clean();
	}


	public function include_slider_js(){
	    ob_start();
	    $plugin_url = ADVERTISERS_INDEX_PLUGIN_URL;
		echo "<script src=\"$plugin_url/assets/slider.js\"></script>";
		echo "<link rel=\"stylesheet\" href=\"$plugin_url/assets/slider.css\" type=\"text/css\" media=\"all\" />";
		return ob_get_clean();

	}






}