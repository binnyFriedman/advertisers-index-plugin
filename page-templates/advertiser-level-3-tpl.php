<?php
/**
 *  Template Name: Advertiser Level 3
 *  AKA FREE
 */
use Inc\Controllers\AdvTemplate;
get_header();
$template = new AdvTemplate();
echo $template->get_base_style();
$template->get_hero();
$template->get_breadcrums();
?>
    <div class="bg-white pt-24 p-8">

        <div class="flex flex-wrap  justify-center ">

            <div class="first-col lg:pl-3 container lg:max-w-screen-md">
                <div class="p-content mb-5">
					<?  the_content();?>
                </div>
				<? $template->print_expertise(true); ?>

            </div>
            <div class="lg:pr-32">
                <div class="contact-form">
                    <h3><? echo __('For medical advice and more information',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?> </h3>
					<? echo do_shortcode('[advertiser_contact_form]'); ?>
                </div>

                <div class="ad-zones">
					<?php echo do_shortcode('[advertiser_banners  numAds="2" ]');  ?>
                </div>
            </div>

        </div>
        <div class="container text-center mx-auto">
            <hr class="w-full border-black mx-auto my-24" />
	        <? echo $template->include_slider_js(); ?>

            <? echo $template->more_advertisers(); ?>

        </div>
    </div>


<?php
get_footer();

