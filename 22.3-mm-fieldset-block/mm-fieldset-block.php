<?php
/**
 * Plugin Name: mm Legend Block
 * Plugin URI:  https://wp-plugin-erstellen.de/ebook/block-apis/bloecke-transformieren/
 * Description: An easy Gutenberg Block for generating HTML legends.
 * Version: 0.1.0
 * Author: Florian Simeth
 */

add_action('init', 'mmfb_init');

function mmfb_init()
{
    wp_register_script(
        'mmfb-fieldset-block',
        plugin_dir_url(__FILE__) . 'js/fieldset.js',
        ['wp-blocks', 'wp-data', 'wp-editor', 'wp-i18n', 'wp-components'],
        filemtime(plugin_dir_path(__FILE__) . '/js/fieldset.js')
    );

    wp_enqueue_script('mmfb-fieldset-block');

    wp_register_style(
        'mmfb-fieldset-block',
        plugin_dir_url(__FILE__) . 'css/layout.css',
        [],
        filemtime(plugin_dir_path(__FILE__) . '/css/layout.css')
    );

    if (!is_admin() && is_singular()) {
        global $wp_query;
        $post = $wp_query->get_queried_object();
        if ($post instanceof WP_Post && has_block($post->post_content)) {
            #wp_enqueue_style('mmfb-fieldset-block');
        }
    }

    register_block_type(
        'mm/fieldset',
        [
            'style' => 'mmfb-fieldset-block',
        ]
    );
}