<?php
/*
Plugin Name: Test Comparatif Plugin B2B
Plugin URI: 
Description: Ceci est un test pour la création d'un plugin B2B
Author: John
Version: 1.0
Author URI: 
*/

define( 'COMPARATIF_PLUGIN_FILE', __FILE__ );

register_activation_hook( COMPARATIF_PLUGIN_FILE, 'comparatif_plugin_activation' );

function comparatif_plugin_activation() {
  
  if ( ! current_user_can( 'activate_plugins' ) ) return;
  
  
  if ( ! $page = get_page_by_path( 'comparatif') ) {
    apply_filters( 'theme_page_templates', 'wpse255804_add_page_template' );
    apply_filters( 'page_template', 'wpse255804_redirect_page_template' );
    add_action( 'init', addPage() ) ;
  }

  
}


function addPage(){
     
        $current_user = wp_get_current_user();
        
        // create post object
        $page = array(
          'post_title'  => __( 'Comparatif' ),
          'post_status' => 'publish',
          'post_author' => $current_user->ID,
          'post_type'   => 'page',
          'post_slug'     => 'comparatif',
          'page_template' => 'template-comparatif.php'
        );
        
        // insert the post into the database
        $pageId = wp_insert_post( $page );
}

function wpse255804_add_page_template ($templates) {
  $templates['template-comparatif.php'] = 'Comparatif';
  return $templates;
  }

add_filter ('theme_page_templates', 'wpse255804_add_page_template');

function wpse255804_redirect_page_template ($template) {
  $post = get_post();
  $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
  if ('template-comparatif.php' == basename ($page_template))
      $template = COMPARATIF_PLUGIN_FILE . '/test-plugin/templates/template-comparatif.php';
  return $template;
  }

add_filter ('page_template', 'wpse255804_redirect_page_template');

