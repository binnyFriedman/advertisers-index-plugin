<?php

?>
<div class="contact-form--wrapper">
	<form class="wordpress-ajax-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
		<input type="text" name="name" placeholder="שם מלא" required>
		<input type="tel" name="phone" placeholder="טלפון" required>
		<input type="email" name="email" placeholder="אימייל (לא חובה)">
		<input type="hidden" name="action" value="advertiser_contact">
		<?php wp_nonce_field( 'advertiser_contact_nonce', 'advertiser_contact_nonce' ); ?>
		<button>שלחו</button>
	</form>
</div>