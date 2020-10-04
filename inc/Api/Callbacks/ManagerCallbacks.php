<?php
/**
 * @package AdvertisersIndex
 */


namespace inc\Api\Callbacks;


use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController {

	public function checkboxSanitize( $input ) {
		return $input;
	}

	public function adminSectionManager() {
		echo __( "Manage the section and Features of this plugin by activating the checkboxes from the following list.", ADVERTISERS_INDEX_PLUGIN_DOMAIN );
	}
	public function adminTaxonomyManager() {
		echo __( "Manage the taxonomy name used in templates and across the site.", ADVERTISERS_INDEX_PLUGIN_DOMAIN );
	}
	public function adminLevelsManager() {
		echo __( "Manage the taxonomy name used in templates and across the site.", ADVERTISERS_INDEX_PLUGIN_DOMAIN );
	}
	public function facebookAppSettings() {
		echo __( "Set the app id and secret key .", ADVERTISERS_INDEX_PLUGIN_DOMAIN );
		?>
		<button class="btn btn-primary" ><a href="https://developers.facebook.com/apps/">More information</a> </button>
		<?php
	}





	public function checkboxField( array $args ) {
		// moving to more efficient storage
		$name        = $args['label_for'];
		$classes     = $args['class'];
		$option_name = $args['option_name'];
		$type =         $args['input_type'];
		$placeHolder = isset($args['place_holder'])?$args['place_holder']:"";
		$checkbox    = get_option( $option_name );
		$value = 	isset($checkbox[$name])? $args['input_type']=="checkbox"?isset($checkbox[$name]):$checkbox[$name]:"";
		$description = $args['description'];
		echo '<div class="' . $classes . '">
		<p>'.$description.'</p>
		<input type="'.$type .'" id="' . $name . '" name="' . $option_name . '[' . $name . ']' . '" value="'.$value.'" class="" ' . ( $value ? "checked" : "" ) . '
		 placeholder="'.$placeHolder.'" >
		<label for="' . $name . '" />
		<div>
		</div>
	</label>
	</div>';
	}

	public function levelsField(array $args){
		// on each item on hover allow edit with an input field above to add new value.
		// if a user wishes to delete a level first ask if he is sure then check for all cpt index that include that in their meta value
		// and ask the user whether to assign them a new level or all wil be assigned to the first option in the array of levels.
		$levels = get_option('advertisers_plugin_levels');
		echo '<div >';
		$index = -1;
		foreach ($levels as  $level){
			$index++;
			$name = esc_attr($level['title']);
			echo '
			<p><input type="text" id="advertisers_plugin_levels['.$index.']" value="'.$name.'"  placeholder="Level name" name="advertisers_plugin_levels['.$index.'][title]"></p>';

		}
		echo '</div>';

	}
	public function levelsFieldSanitize(array $input){
		$output = get_option('advertisers_plugin_levels');

		$index = -1;
		foreach ($output as $level){
			$index++;
			$output[$index]['title'] = $input[$index]['title'];
		}
		return $output;
	}

	public function facebookSettingsFieldsSanitize(array $input){
		return $input;

	}
}