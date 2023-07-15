<?php
/*
Plugin Name: TLDR-GPT
Plugin URL: https:/querious.tech/tldr-gpt
Description: Generate a TLDR Section with ChatGPT
Author: Querious.tech
Author URI: https://querious.tech
Contributors: harshanas
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

require plugin_dir_path( __FILE__ ) . 'includes/tldr-gpt.php';
require plugin_dir_path( __FILE__ ) . 'admin/tldr-gpt.php';

function tldrgpt_on_save_post($post_id, $post, $update)
{
  if (wp_is_post_autosave($post_id))
  {
    return;
  }

  if (!$update)
  {
    return;
  }

  if ( $summary = tldrgpt_summarize($post_id, $post) )
  {
    update_post_meta($post_id, 'tldrgpt-summary', $summary);
  }
}

add_action('admin_menu', 'tldrgpt_add_admin_menu');
add_action( 'admin_init', 'tldrgpt_settings_init' );
add_action('save_post_post', 'tldrgpt_on_save_post', 10, 3);