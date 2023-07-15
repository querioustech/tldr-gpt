<?php

function tldrgpt_settings_init()
{
    register_setting( 'TLDRGPTSettingsPage', 'tldrgpt_settings' );

    add_settings_section(
		'tldrgpt__TLDRGPTSettingsPage_section', 
		__( 'TLDR-GPT Settings', 'tldrgpt' ), 
		'tldrgpt__settings_section_callback', 
		'TLDRGPTSettingsPage'
	);

    add_settings_field( 
		'tldrgpt_openai_apikey', 
		__( 'OpenAI API Key', 'tldrgpt' ), 
		'tldrgpt_openai_api_key_render', 
		'TLDRGPTSettingsPage', 
		'tldrgpt__TLDRGPTSettingsPage_section' 
	);
}

function tldrgpt__settings_section_callback(  ) { 

	echo __( 'Basic Settings', 'tldrgpt' );

}

function tldrgpt_openai_api_key_render( ) { 

	$options = get_option( 'tldrgpt_settings' );
	?>
	<input type='text' name='tldrgpt_settings[openai-apikey]' value='<?php echo $options['openai-apikey']; ?>'>
	<?php

}

function tldrgpt_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		<?php
		settings_fields( 'TLDRGPTSettingsPage' );
		do_settings_sections( 'TLDRGPTSettingsPage' );
		submit_button();
		?>

	</form>
	<?php
}

function tldrgpt_add_admin_menu(  ) { 
	add_options_page( 'TLDR-GPT', 'TLDR-GPT', 'manage_options', 'tldrgpt', 'tldrgpt_options_page' );
}