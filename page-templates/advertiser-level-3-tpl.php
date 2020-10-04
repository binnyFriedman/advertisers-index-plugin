<?php
/**
 *  Template Name: Advertiser Level 1
 */

get_header();
global $post;
$data    = get_post_meta( $post->ID, '_advertisers_options_key', true );
$header  = isset( $data['header'] ) ? $data['header'] : "";
$bullets = isset( $data['bullets'] ) ? $data['bullets'] : "";
//contact fields
$website       = isset( $data['website'] ) ? $data['website'] : "";
$facebook      = isset( $data['facebook'] ) ? $data['facebook'] : "";
$instagram     = isset( $data['instagram'] ) ? $data['instagram'] : "";
$phone         = isset( $data['phone'] ) ? $data['phone'] : "";
$address       = isset( $data['address'] ) ? $data['address'] : "";
$opening_hours = isset( $data['opening_hours'] ) ? $data['opening_hours'] : "";
$emails        = isset( $data['emails'] ) ? $data['emails'] : "";
//gallery fields
$cover_image = isset( $data['cover_image'] ) ? $data['cover_image'] : "";

$professions = get_the_terms($post->ID,'profession');
$profession = isset($professions[0])?$professions[0]->name:"";
the_post();
?>
	<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
	<style>
        @import url('https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;600;700;800&display=swap');

        :root {
            --secondery-color: #E88E9E;
            --primary-color: #F37F94;

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
            font-size: 45px;
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
	<div class="pt-40 px-6 bg-opacity-75 bg-center  bg-no-repeat bg-cover text-center"
	     style="box-shadow: inset 0 0 0 2000px rgb(255 255 255 / 75%);background-image: url('<?php echo esc_url( $cover_image ) ?>');">
		<div class="inline-flex justify-center flex-wrap mx-auto mb-40">
			<div class="rounded-full  bg-center bg-no-repeat"
			     style="width: 214px;height: 214px; background-image: url('<? echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>')"></div>
			<div class="text-right px-10">
				<h1 class="text-primary"><? echo $post->post_title; ?> - <? echo $profession; ?> </h1>
				<h2 class="text-center"><? echo $header; ?></h2>
				<div class="bullets list-disc text-3xl mb-4">
					<? echo $bullets; ?>
				</div>
				<div class="contact-buttons  flex flex-wrap justify-center">
					<?php if ( $phone != "" ): ?>
						<span class="px-20 mb-8 lg:px-24 py-3 ">
             <a class="flex" href="tel:<? echo $phone; ?>">
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


				</div>
			</div>
		</div>
	</div>
	<div class="breadcrums-cover px-8 lg:px-40 py-10 ">
		<span class="container"> בית > מומחים > <?php echo the_title();?></span>
	</div>
	<div class="bg-white pt-24 p-8">

		<div class="flex flex-wrap  justify-center ">

			<div class="first-col lg:pl-3 container lg:max-w-screen-md">
				<div class="p-content mb-5">
					<? echo the_content();?>
				</div>
				<div class="my-10">
					<h3 class="expertise"><? echo get_taxonomy('expertise')->labels->name;?></h3>
					<div class="py-5 expertise flex flex-wrap">
						<?
						$expertises = get_the_terms($post->ID,'expertise');
						foreach ($expertises as $expertise){
							?>
							<span><a href="<? echo get_term_link($expertise);?>" title="<? echo $expertise->name?>" > <? echo $expertise->name; ?></a></span>
							<?
						}
						?>
					</div>

				</div>



			</div>
			<div class="lg:pr-32">
				<div class="contact-form">
					<h3>לייעוץ רפואי ומידע נוסף</h3>
					<? echo do_shortcode('[advertiser_contact_form]');?>
				</div>
				<div class="contact-info my-20" >
					<? if($address!=''): ?>
						<div class="flex">
                    <span class="pl-2 my-auto">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.375 2C8.62594 2 5.59375 5.13 5.59375 9C5.59375 14.25 12.375 22 12.375 22C12.375 22 19.1562 14.25 19.1562 9C19.1562 5.13 16.1241 2 12.375 2ZM12.375 11.5C11.0381 11.5 9.95312 10.38 9.95312 9C9.95312 7.62 11.0381 6.5 12.375 6.5C13.7119 6.5 14.7969 7.62 14.7969 9C14.7969 10.38 13.7119 11.5 12.375 11.5Z" fill="#E88E9E"/>
                        </svg>
                    </span>
							<span class="pl-2 font-bold" >כתובת: </span>
							<span ><? echo $address; ?></span>
						</div>
					<? endif; ?>
					<? if($phone!=''): ?>
						<div class="flex">
                        <span class="pl-2 my-auto">
                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.62 10.79C8.06 13.62 10.38 15.93 13.21 17.38L15.41 15.18C15.68 14.91 16.08 14.82 16.43 14.94C17.55 15.31 18.76 15.51 20 15.51C20.55 15.51 21 15.96 21 16.51V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z" fill="#E88E9E"/>
                            </svg>
                        </span>
							<span class="pl-2 font-bold" >טלפון: </span>
							<span ><a href="tel:<? echo $phone; ?>" ><? echo $phone; ?></a></span>
						</div>
					<? endif; ?>
					<? if($opening_hours!=''): ?>
						<div class="flex">
                        <span class="pl-2 mt-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="12.5" cy="12" rx="9.5" ry="10" fill="#E88E9E"/>
                                <path d="M12.8594 7H11.4062V13L16.4922 16.15L17.2188 14.92L12.8594 12.25V7Z" fill="white"/>
                            </svg>
                            </span>
							<div>
								<span class=" font-bold" >שעות פעילות: </span>
								<span class="w-full"><? echo $opening_hours; ?></span>
							</div>
						</div>
					<? endif; ?>
				</div>

				<div class="ad-zones">
					<?php echo do_shortcode('[advertiser_banners  numAds="2" ]');  ?>
				</div>
			</div>

		</div>
		<div class="container text-center mx-auto">
			<hr class="w-full border-black mx-auto my-24" />
			<?
			// TODO: Add an option for profession meta because we need a plural verse for the tax name.
			?>
			<h2 class="font-bold" >לעוד מומחים בתחום</h2>
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
									$terms = get_the_terms( $post->ID , 'expertise');
									//Pluck out the IDs to get an array of IDS
									$term_ids = wp_list_pluck($terms,'term_id');
									$more_advertisers = new WP_Query( array(
										'post_type' => 'advertiser',
										'tax_query' => array(
											array(
												'taxonomy' => 'expertise',
												'field' => 'id',
												'terms' => $term_ids,
												'operator'=> 'IN' //Or 'AND' or 'NOT IN'
											)),
										'ignore_sticky_posts' => 1,
										'orderby' => 'rand',
										'post__not_in'=>array($post->ID)
									) );
									//Loop through posts and display...
									$count = 0;
									$is_mobile= wp_is_mobile();
									if($more_advertisers->have_posts()) {
										while ($more_advertisers->have_posts() ) : $more_advertisers->the_post();
											$professions = get_the_terms(null,'profession');
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
		</div>
	</div>


<?php
get_footer();

