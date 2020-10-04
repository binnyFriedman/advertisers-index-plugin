<?php
try {
	$config = get_option('advertisers_facebook_settings');



	if($config['app_id']!=''&&$config['app_secret']!='') {


		$fb = new Facebook\Facebook( [
			'app_id'                => $config['app_id'],
			'app_secret'            => $config['app_secret'],
			'default_graph_version' => 'v2.10',
		] );

		$helper = $fb->getRedirectLoginHelper();

		$permissions = [ 'email' ]; // Optional permissions
		$loginUrl    = $helper->getLoginUrl( 'fb-callback.php', $permissions );

		echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
	}
} catch ( \Facebook\Exceptions\FacebookSDKException $e ) {

}
