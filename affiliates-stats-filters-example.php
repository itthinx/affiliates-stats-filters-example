<?php
/**
 * Plugin Name: Affiliates Stats Filters Example
 * Plugin URI: http://www.itthinx.com/shop/affiliates-pro/
 * Description: Example plugin for the [affiliates_affiliate_stats type="stats-referrals"] shortcode rendering filters.
 * Version: 1.0.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * License: GPLv3
 */

/**
 * Implements various filters used to modify the output of the [affiliates_affiliate_stats type="stats-referrals"] shortcode.
 */
class Affiliates_Stats_Filters_Example {

	/**
	 * Add filters.
	 */
	public static function init() {
		add_filter( 'affiliates_affiliate_stats_renderer_data', array( __CLASS__, 'affiliates_affiliate_stats_renderer_data' ), 10, 2 );
		add_filter( 'affiliates_affiliate_stats_renderer_data_output', array( __CLASS__, 'affiliates_affiliate_stats_renderer_data_output' ), 10, 2 );
		add_filter( 'affiliates_affiliate_stats_renderer_column_display_names', array( __CLASS__, 'affiliates_affiliate_stats_renderer_column_display_names' ), 10, 1 );
		add_filter( 'affiliates_affiliate_stats_renderer_column_output', array( __CLASS__, 'affiliates_affiliate_stats_renderer_column_output' ), 10, 3 );
	}

	/**
	 * Allows to modify or extend the stored data set displayed for a referral.
	 * 
	 * The additional data will only be displayed if you include the field key in the shortcode's data attribute, for example:
	 * [affiliates_affiliate_stats type="stats-referrals" data="custom-data"]
	 * 
	 * @param array $data data set for the referral
	 * @param object $result referral row
	 * @return array
	 */
	public static function affiliates_affiliate_stats_renderer_data( $data, $result ) {
		$data['custom-data'] = array (
			'title' => 'Custom Data',
			'domain' => 'affiliates',
			'value' => sprintf( 'Some custom data could be displayed here for the referral with ID %d', intval( $result->referral_id ) ) 
		);
		return $data;
	}

	/**
	 * Allows to modify the output of the Details column displayed for a referral.
	 * 
	 * Here we simply wrap the data output in a div with a blue border and some added padding.
	 * 
	 * @param string $output
	 * @param unknown $result referral row
	 * @return string
	 */
	public static function affiliates_affiliate_stats_renderer_data_output( $output, $result ) {
		$output = '<div style="border: 1px solid #33f; padding: 4px;">' . $output . '</div>';
		return $output;
	}

	/**
	 * Allows to modify and reorder the columns used to display referrals.
	 * 
	 * @param array $column_display_names array maps keys to column display names
	 */
	public static function affiliates_affiliate_stats_renderer_column_display_names( $column_display_names ) {
		$column_display_names['extra_info'] = 'Extra Info';
		return $column_display_names;
	}

	/**
	 * This filter is used to create the output for additional columns added via the
	 * affiliates_affiliate_stats_renderer_column_display_names filter.
	 * 
	 * @param string $output
	 * @param string $key
	 * @param object $result
	 * @return string
	 */
	public static function affiliates_affiliate_stats_renderer_column_output( $output, $key, $result ) {
		switch( $key ) {
			case 'extra_info' :
				$output .= sprintf( 'This is some extra info for the referral with ID %d', intval( $result->referral_id ) );
				break;
		}
		return $output;
	}
}
Affiliates_Stats_Filters_Example::init();
