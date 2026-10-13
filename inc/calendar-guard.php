<?php
/**
 * Calendar crawl guard.
 *
 * Bots walk the pantry calendar (The Events Calendar, slugs /pantries/ and
 * /pantry/) through endless page numbers and dates years away from today.
 * Every one of those URLs is unique, so none are cached and each runs a full
 * calendar query. Answer them with a 410 before WordPress does any of that work.
 *
 * @package bellaworks
 */

/**
 * Whether a request is a calendar URL no visitor needs.
 *
 * @param string $uri Request URI, including any query string.
 * @return bool
 */
function bellaworks_is_calendar_crawl( $uri ) {
	$max_page = 5;
	$window   = YEAR_IN_SECONDS;

	$path = (string) parse_url( $uri, PHP_URL_PATH );
	if ( ! preg_match( '#/(pantries|pantry)/#', $path ) ) {
		return false;
	}

	if ( preg_match( '#/page/(\d+)#', $path, $m ) && (int) $m[1] > $max_page ) {
		return true;
	}

	// Dates in the path (/2029-01/, /2031-05-30/) and in ?tribe-bar-date=.
	preg_match_all( '#/(\d{4})-(\d{2})(?:-(\d{2}))?(?=/|$)#', $path, $dates, PREG_SET_ORDER );
	$query = (string) parse_url( $uri, PHP_URL_QUERY );
	if ( preg_match( '#(?:^|&)tribe-bar-date=(\d{4})-(\d{2})(?:-(\d{2}))?#', $query, $m ) ) {
		$dates[] = $m;
	}

	$now = time();
	foreach ( $dates as $d ) {
		$day = empty( $d[3] ) ? 1 : (int) $d[3];
		if ( ! checkdate( (int) $d[2], $day, (int) $d[1] ) ) {
			return true;
		}
		$ts = gmmktime( 0, 0, 0, (int) $d[2], $day, (int) $d[1] );
		if ( abs( $ts - $now ) > $window ) {
			return true;
		}
	}

	return false;
}

if ( ! is_admin() && ! wp_doing_ajax() && ! wp_doing_cron() && ! ( defined( 'WP_CLI' ) && WP_CLI )
	&& isset( $_SERVER['REQUEST_URI'] ) && bellaworks_is_calendar_crawl( $_SERVER['REQUEST_URI'] ) ) {
	status_header( 410 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'X-Robots-Tag: noindex' );
	echo 'Gone';
	exit;
}
