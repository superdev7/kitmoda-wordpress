<?php
/**
 * Extra metaboxes if FES is not active.
 */
class Kitification_EDD_Metabox {

	/**
     * @var $instance
     */
	public static $instance;

	/*
	 * Init so we can attach to an action
	 */
	public static function init() {
		// If we are using FES, assume the field is added through that
		if ( class_exists( 'EDD_Front_End_Submissions' ) )
			return;

		if ( ! isset ( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Setup actions
	 */
	public function __construct() {
		add_action( 'add_meta_boxes',          array( $this, 'add_meta_boxes' ) );
		add_action( 'edd_metabox_fields_save', array( $this, 'save_post' ) );

		add_filter( 'kitification_video_field',   array( $this, 'video_field' ) );
		add_filter( 'kitification_demo_field',    array( $this, 'demo_field' ) );
	}

	/**
	 * Add meta box
	 */
	public function add_meta_boxes() {
		add_meta_box( 'edd-kitification-video', sprintf( __( '%s Video URL', 'kitification' ), edd_get_label_singular() ), array( $this, 'meta_box_video' ), 'download', 'normal', 'high' );

		add_meta_box( 'edd-kitification-demo', sprintf( __( '%s Demo URL', 'kitification' ), edd_get_label_singular() ), array( $this, 'meta_box_demo' ), 'download', 'normal', 'high' );
	}

	/**
	 * Output video meta box
	 */
	public function meta_box_video() {
		global $post;

		echo EDD()->html->text( array(
			'name'  => 'edd_video',
			'value' => esc_url( $post->edd_video ),
			'class' => 'large-text'
		) );
	}

	/**
	 * Output demo meta box
	 */
	public function meta_box_demo() {
		global $post;

		echo EDD()->html->text( array(
			'name'  => 'edd_demo',
			'value' => esc_url( $post->edd_demo ),
			'class' => 'large-text'
		) );
	}

	/**
	 * Save meta box
	 */
	public function save_post( $fields ) {
		$fields[] = 'edd_video';
		$fields[] = 'edd_demo';

		return $fields;
	}

	/**
	 * Filter the video field that is searched for the URL.
	 */
	public function video_field() {
		return 'edd_video';
	}

	/**
	 * Filter the demo field that is searched for the URL.
	 */
	public function demo_field() {
		return 'edd_demo';
	}

}
add_action( 'init', array( 'Kitification_EDD_Metabox', 'init' ) );