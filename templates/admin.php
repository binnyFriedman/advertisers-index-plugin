<div class="wrap">
    <h1><? echo __('Advertisers Plugin',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?> </h1>
	<?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1"><? echo __('Cpt Settings',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></a></li>
        <li><a href="#tab-2"><? echo __('Levels',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></a></li>
        <li><a href="#tab-3"><? echo __('Contact form options',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></a></li>
        <li><a href="#tab-4"><? echo __('Facebook app settings',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></a></li>
        <li><a href="#tab-5"><? echo __('Default template settings',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></a></li>
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
            <h3><? echo __('Levels',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></h3>
            <form method="post" action="options.php">
		        <?php
		        settings_fields('advertisers_plugin_levels_settings');
		        do_settings_fields('advertisers_plugin','advertisers_admin_levels');

		        submit_button();
		        ?>
            </form>
        </div>
        <div id="tab-3" class="tab-pane">
            <h3><? echo __('Contact form options',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?></h3>
            <form method="post" action="options.php">
			    <?php
			    settings_fields('advertisers_contact_form_options');
			    do_settings_fields('advertisers_plugin','advertisers_contact_form_options');

			    submit_button();
			    ?>
            </form>
        </div>
        <div id="tab-4" class="tab-pane">
            <h3><? echo __('Facebook app settings',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?> </h3>
            <form method="post" action="options.php">
		        <?php
		        settings_fields('advertisers_plugin_facebook_settings');
		        do_settings_fields('advertisers_plugin','advertisers_facebook_settings');

		        submit_button();
		        ?>
            </form>
        </div>
        <div id="tab-5" class="tab-pane">
            <h3><? echo __('Default template settings',ADVERTISERS_INDEX_PLUGIN_DOMAIN); ?> </h3>
            <form method="post" action="options.php">
		        <?php
		        settings_fields('advertisers_template_options');
		        do_settings_fields('advertisers_plugin','advertisers_template_options');

		        submit_button();
		        ?>
            </form>
        </div>
    </div>
</div>