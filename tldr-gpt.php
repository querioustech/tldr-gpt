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

require plugin_dir_path( __FILE__ ) . 'src/includes/tldr-gpt.php';
require plugin_dir_path( __FILE__ ) . 'src/admin/tldr-gpt.php';

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
    update_post_meta($post_id, 'tldrgpt_summary', $summary);
  }
}

function tldrgpt_gutenberg_register_block() {

	// Register the block by passing the location of block.json to register_block_type.
	register_block_type( __DIR__. '/build/tldrgpt-jsx' );
}

function tldrgpt_register_meta() {
    register_post_meta(
        'post',
        'tldrgpt_summary',
        [
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
        ]
    );
}
add_action( 'init', 'tldrgpt_register_meta');
add_action( 'init', 'tldrgpt_gutenberg_register_block' );
add_action('admin_menu', 'tldrgpt_add_admin_menu');
add_action( 'admin_init', 'tldrgpt_settings_init' );
add_action('save_post_post', 'tldrgpt_on_save_post', 10, 3);