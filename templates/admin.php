<div class="wrap">
    <h1>Advertisers Plugin</h1>
	<?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Cpt Settings</a></li>
        <li><a href="#tab-2">Levels</a></li>
        <li><a href="#tab-3">Facebook app settings</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">

            <form method="post" action="options.php">
				<?php
				settings_fields('advertisers_plugin_settings');
				do_settings_fields('advertisers_plugin','advertisers_admin_cpt');
				do_settings_fields('advertisers_plugin','advertisers_admin_taxonomy');
				submit_button();
				?>
            </form>

        </div>

        <div id="tab-2" class="tab-pane">
            <h3>Levels</h3>
            <form method="post" action="options.php">
		        <?php
		        settings_fields('advertisers_plugin_levels_settings');
		        do_settings_fields('advertisers_plugin','advertisers_admin_levels');

		        submit_button();
		        ?>
            </form>
        </div>

        <div id="tab-3" class="tab-pane">
            <h3>Facebook </h3>
            <form method="post" action="options.php">
		        <?php
		        settings_fields('advertisers_plugin_facebook_settings');
		        do_settings_fields('advertisers_plugin','advertisers_facebook_settings');

		        submit_button();
		        ?>
            </form>
        </div>
    </div>
</div>