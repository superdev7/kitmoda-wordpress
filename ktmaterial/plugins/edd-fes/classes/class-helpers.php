<?php
class FES_Helpers{
    function __construct() {
        add_shortcode( 'fes-meta-value', array( $this, 'fes_meta_shortcode' ) );
        add_shortcode( 'fes-user-value', array( $this, 'fes_user_shortcode' ) );
    }

    public function fes_meta_shortcode( $atts ) {

        extract( shortcode_atts( array(
            'name' => '',
            'post_id' => '',
            'type' => 'normal',
            'size' => 'thumbnail',
            'height' => 250,
            'width' => 450,
            'zoom' => 12
        ), $atts ) );

        if ( empty( $name ) ) {
            return;
        }

        $post = get_post( $post_id );

        if ( $type == 'image' || $type == 'file' ) {
            $images = get_post_meta( $post->ID, $name );

            if ( $images ) {
                $html = '';
                if ( isset( $images[0] ) && is_array( $images[0] ) ){
                    $images = $images[0];
                }
                foreach ($images as $attachment_id ) {
                    if ( $type == 'image' ) {
                        $thumb = wp_get_attachment_image( $attachment_id, $size );
                    } else {
                        $thumb = get_post_field( 'post_title', $attachment_id );
                    }

                    $full_size = wp_get_attachment_url( $attachment_id );
                    $html .= sprintf( '<a href="%s">%s</a> ', $full_size, $thumb );
                }
                return $html;
            }
        } elseif ( $type == 'repeat' ) {
            return implode( '; ', get_post_meta( $post->ID, $name ) );
        } else {
            return implode( ', ', get_post_meta( $post->ID, $name ) );
        }
    }

    public function get_post_meta( $name, $post_id, $type = 'normal' ){
        if ( empty( $name ) || empty( $post_id ) ) {
            return;
        }

        $post = get_post( $post_id );

        if ( $type == 'image' || $type == 'file' ) {
            $images = get_post_meta( $post->ID, $name );

            if ( $images ) {
                $html = '';
                if ( isset( $images[0] ) && is_array( $images[0] ) ){
                    $images = $images[0];
                }
                foreach ($images as $attachment_id ) {
                    if ( $type == 'image' ) {
                        $thumb = wp_get_attachment_image( $attachment_id );
                    } else {
                        $thumb = get_post_field( 'post_title', $attachment_id );
                    }

                    $full_size = wp_get_attachment_url( $attachment_id );
                    $html .= sprintf( '<a href="%s">%s</a> ', $full_size, $thumb );
                }
                return $html;
            }
        } elseif ( $type == 'repeat' ) {
            return implode( '; ', get_post_meta( $post->ID, $name ) );
        } else {
            return implode( ', ', get_post_meta( $post->ID, $name ) );
        }
    }

    // begin users

    public function fes_user_shortcode( $atts ){

        extract( shortcode_atts( array(
            'name' => '',
            'user_id' => '',
            'type' => 'normal',
            'size' => 'thumbnail',
            'height' => 250,
            'width' => 450,
            'zoom' => 12
        ), $atts ) );

        if ( empty( $name ) || empty( $user_id ) ) {
            return;
        }

        if ( $type == 'image' || $type == 'file' ) {
            $images = get_user_meta( $user_id, $name );
            if ( $images ) {
                $html = '';
                if ( isset( $images[0] ) && is_array( $images[0] ) ){
                    $images = $images[0];
                }
                foreach ($images as $attachment_id ) {
                    if ( $type == 'image' ) {
                        $thumb = wp_get_attachment_image( $attachment_id, $size );
                    } else {
                        $thumb = get_post_field( 'post_title', $attachment_id );
                    }

                    $full_size = wp_get_attachment_url( $attachment_id );
                    $html .= sprintf( '<a href="%s">%s</a> ', $full_size, $thumb );
                }
                return $html;
            }
        } elseif ( $type == 'repeat' ) {
            return implode( '; ', get_user_meta( $user_id, $name ) );
        } else {
            return implode( ', ', get_user_meta( $user_id, $name ) );
        }

    }

    public function get_user_meta( $name, $user_id, $type = 'normal'  ){
        if ( empty( $name ) || empty( $user_id ) ) {
            return;
        }

        if ( $type == 'image' || $type == 'file' ) {
            $images = get_user_meta( $user_id, $name );

            if ( $images ) {
                $html = '';
                if ( isset( $images[0] ) && is_array( $images[0] ) ){
                    $images = $images[0];
                }
                foreach ($images as $attachment_id ) {
                    if ( $type == 'image' ) {
                        $thumb = wp_get_attachment_image( $attachment_id, $size );
                    } else {
                        $thumb = get_post_field( 'post_title', $attachment_id );
                    }

                    $full_size = wp_get_attachment_url( $attachment_id );
                    $html .= sprintf( '<a href="%s">%s</a> ', $full_size, $thumb );
                }
                return $html;
            }
        } elseif ( $type == 'repeat' ) {
            return implode( '; ', get_user_meta( $user_id, $name ) );
        } else {
            return implode( ', ', get_user_meta( $user_id, $name ) );
        }

    }

    // Gets FES setting for the given key. If not set, returns the default
    public function get_option( $key = '', $default = false ) {
        global $fes_settings;
        $value = isset( $fes_settings[ $key ] ) ? $fes_settings[ $key ] : $default;
        $value = apply_filters( 'fes_get_option', $value, $key, $default );
        return apply_filters( 'fes_get_option_' . $key, $value, $key, $default );
    }
}