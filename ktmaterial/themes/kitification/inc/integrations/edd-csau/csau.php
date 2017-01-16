<?php
/**
 * Cross-sell and Upsell
 *
 * @package Kitification
 */

/**
 * Cross Sell/Up Sell
 *
 * @since Kitification 1.0
 */
add_filter( 'edd_csau_show_excerpt', '__return_false' );
add_filter( 'edd_csau_show_price', '__return_false' );