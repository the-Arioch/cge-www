<?php
/**
 * Class DiscoursePublishTest
 *
 * @package WPDiscourse
 */

namespace WPDiscourse\Test;

use \WPDiscourse\DiscourseCommentFormatter\DiscourseCommentFormatter;
use \WPDiscourse\DiscourseComment\DiscourseComment;
use \WPDiscourse\Test\UnitTest;

/**
 * DiscourseComment test case.
 */
class DiscourseCommentTest extends UnitTest {

    /**
     * Instance of DiscourseComment.
     *
     * @access protected
     * @var \WPDiscourse\DiscourseComment\DiscourseComment
     */
    protected $comment;

    /**
     * Setup each test.
     */
    public function setUp() {
        parent::setUp();

        $comment_formatter = new DiscourseCommentFormatter();
        $this->comment     = new DiscourseComment( $comment_formatter );
        $this->comment->setup_logger();

        self::$plugin_options[ 'enable-discourse-comments' ] = true;
        $this->comment->setup_options( self::$plugin_options );
  	}

    public function test_sync_comments() {
        // Mock objects and endpoints
        $discourse_post      = json_decode( $this->response_body_file( 'post_create' ) );
        $post_id             = wp_insert_post( self::$post_atts, false, false );
        $comments_response   = $this->mock_remote_post_success( 'comments' );

        // Setup the post meta
        $discourse_topic_id  = $discourse_post->topic_id;
        $discourse_permalink = self::$discourse_url . '/t/' . $discourse_post->topic_slug . '/' . $discourse_post->topic_id;
        update_post_meta( $post_id, 'discourse_permalink', $discourse_permalink );
        update_post_meta( $post_id, 'discourse_topic_id', $discourse_topic_id );

        // Setup transients
        set_transient( "wpdc_comment_html_$discourse_topic_id", $comments_response, 10 * MINUTE_IN_SECONDS );

        // Perform sync
        $this->comment->sync_comments( $post_id, true );

        // Ensure right comment json is saved
        $comments_raw = get_post_meta( $post_id, 'discourse_comments_raw' );
        $this->assertEquals( $comments_response, json_decode( $comments_raw[0] ) );

        // Ensure HTML transient is cleared
        $this->assertFalse( get_transient( "wpdc_comment_html_$discourse_topic_id" ) );

        // Cleanup
        wp_delete_post( $post_id );
    }

    public function test_sync_comments_handle_error_response() {
        // Mock objects and endpoints
        $discourse_post = json_decode( $this->response_body_file( 'post_create' ) );
        $post_id        = wp_insert_post( self::$post_atts, false, false );
        $this->mock_remote_post( $this->build_response( 'not_found' ) );

        // Setup the post meta
        $discourse_topic_id  = $discourse_post->topic_id;
        $discourse_permalink = self::$discourse_url . '/t/' . $discourse_post->topic_slug . '/' . $discourse_post->topic_id;
        update_post_meta( $post_id, 'discourse_permalink', $discourse_permalink );
        update_post_meta( $post_id, 'discourse_topic_id', $discourse_topic_id );

        // Perform sync
        $this->comment->sync_comments( $post_id, true );

        // Ensure we've made the right logs
        $log = $this->get_last_log();
        $this->assertRegExp( "/comment.ERROR: sync_comments.response_error/", $log );
        $this->assertRegExp( '/"message":"An invalid response was returned from Discourse"/', $log );
        $this->assertRegExp( '/"discourse_topic_id":"'. $discourse_topic_id . '"/', $log );
        $this->assertRegExp( '/"wp_post_id":'. $post_id . '/', $log );
        $this->assertRegExp( '/"http_code":404/', $log );

        // Cleanup
        wp_delete_post( $post_id );
    }

    /**
     * Get comment type for posts works with display_public_comments_only.
     */
    public function test_get_comment_type_for_post_display_public_comments_only() {
        // Setup plugin options
        self::$plugin_options[ "comment-type" ] = "display-public-comments-only";
        $this->comment->setup_options( self::$plugin_options );

        // Setup the categories response
        $site_json         = $this->response_body_file( 'site' );
        $response          = $this->build_response( 'success' );
        $response['body']  = $site_json;
        $this->mock_remote_post( $response );

        // Setup the category ids.
        $site = json_decode( $site_json );
        $categories = $site->categories;
        $public_category_id = null;
        $private_category_id = null;

        foreach( $categories as $category ) {
          if ( $category->read_restricted === false) {
            $public_category_id = $category->id;
          }
          if ( $category->read_restricted === true) {
            $private_category_id = $category->id;
          }
        }

        // Add the posts.
        self::$post_atts['meta_input']['discourse_post_id'] = 1;
        self::$post_atts['meta_input']['publish_post_category'] =  $public_category_id;
        $public_post_id = wp_insert_post( self::$post_atts, false, false );

        self::$post_atts['meta_input']['discourse_post_id'] = 2;
        self::$post_atts['meta_input']['publish_post_category'] =  $private_category_id;
        $private_post_id = wp_insert_post( self::$post_atts, false, false );

        // Get the comment types.
        $context = 'test';
        $public_comment_type = $this->comment->get_comment_type_for_post( $public_post_id, $context );
        $private_comment_type = $this->comment->get_comment_type_for_post( $private_post_id, $context );

        // Ensure we got the right types.
        $this->assertEquals( $public_comment_type, 'display-comments' );
        $this->assertEquals( $private_comment_type, 'display-comments-link' );

        // Cleanup.
        wp_delete_post( $public_post_id );
        wp_delete_post( $private_post_id );
    }

    /**
     * Get comment type for posts handles connection errors with display_public_comments_only.
     */
    public function test_get_comment_type_for_post_display_public_comments_only_when_connection_fails() {
        $response_error = 'forbidden';

        // Setup plugin options
        self::$plugin_options[ "comment-type" ] = "display-public-comments-only";
        $this->comment->setup_options( self::$plugin_options );

        // Setup the categories response
        delete_transient( "wpdc_discourse_categories" );
        $response = $this->build_response( $response_error );
        $this->mock_remote_post( $response );

        // Setup the category ids.
        $site = json_decode( $this->response_body_file( 'site' ) );
        $categories = $site->categories;
        $public_category_id = null;
        $private_category_id = null;

        foreach( $categories as $category ) {
          if ( $category->read_restricted === false) {
            $public_category_id = $category->id;
          }
          if ( $category->read_restricted === true) {
            $private_category_id = $category->id;
          }
        }

        // Add the posts.
        self::$post_atts['meta_input']['discourse_post_id'] = 1;
        self::$post_atts['meta_input']['publish_post_category'] =  $public_category_id;
        $public_post_id = wp_insert_post( self::$post_atts, false, false );

        self::$post_atts['meta_input']['discourse_post_id'] = 2;
        self::$post_atts['meta_input']['publish_post_category'] =  $private_category_id;
        $private_post_id = wp_insert_post( self::$post_atts, false, false );

        // Get the comment types.
        $context = 'test';
        $public_comment_type = $this->comment->get_comment_type_for_post( $public_post_id, $context );
        $private_comment_type = $this->comment->get_comment_type_for_post( $private_post_id, $context );

        // Ensure we got the right types.
        $this->assertEquals( $public_comment_type, 'display-comments-link' );
        $this->assertEquals( $private_comment_type, 'display-comments-link' );

        // Ensure we've made the right logs
        $log = $this->get_last_log();
        $this->assertRegExp( "/comment.ERROR: $context.get_discourse_category/", $log );
        $this->assertRegExp( '/"message":"An invalid response was returned from Discourse"/', $log );

        // Cleanup.
        wp_delete_post( $public_post_id );
        wp_delete_post( $private_post_id );
    }
}

