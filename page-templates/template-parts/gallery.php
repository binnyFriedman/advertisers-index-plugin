<?php

global $post;

$data    = get_post_meta( $post->ID, '_advertisers_options_key', true );
$gallery     = isset( $data['gallery'] ) ? $data['gallery'] : "";
$images = explode(",",$gallery);
$count = 0;
if(count($images)>0&&$images[0]!=""){
?>
<h3>גלריה</h3>
<div class="ad-gallery--wrapper">
	<ul>
		<?
			foreach ($images as $image){
			    if($image!=""){
			        $count++;
				    echo '<li class="ad-gallery--img '.($count>6?"hidden":"").'"><img src="'.esc_url(trim($image)).'" /> </li>';
                }
			}

		?>
	</ul>
    <?
    if($count>5){
	    echo "<button class='gallery-show-more mt-10'  data-expanded='false' type='button' >תמונות נוספות</button>";
    }
    ?>
</div>

<?php }