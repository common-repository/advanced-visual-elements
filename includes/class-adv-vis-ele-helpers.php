<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Adv_Vis_Ele_Helpers {
	/**
	 * Just a standard clamp
	 *
	 * @param $current
	 * @param $min
	 * @param $max
	 * @return mixed
	 */
	public static function clamp($current, $min, $max) {
		if (empty($min) || empty($max)) {
			return $current;
		}
		
		return max($min, min($max, $current));
	}
	
	/**
	 * Given a string containing any combination of YouTube and Vimeo video URL in
	 * a variety of formats (iframe, shortened, etc),
	 * parse the video string and determine it's valid embeddable URL for usage in
	 * popular JavaScript lightbox plugins.
	 *
	 * In addition, this handler grabs both the maximize size and thumbnail versions
	 * of video images for your general consumption.
	 *
	 * Data gets returned in the format:
	 *
	 *   array(
	 *     'url' => 'http://path.to/embeddable/video',
	 *     'thumbnail' => 'http://path.to/thumbnail/image.jpg',
	 *     'fullsize' => 'http://path.to/fullsize/image.jpg',
	 *   )
	 *
	 * @param       string $videoString
	 * @return      array   An array of video metadata if found, false on failure
	 *
	 * @author      Corey Ballou http://coreyballou.com
	 * @copyright   (c) 2012 Skookum Digital Works http://skookum.com
	 * @license
	 */
	public static function parseVideos($videoString = null) {
		// return data
		$video = false;
		
		if (!empty($videoString)) {
			$videoString = stripslashes(trim($videoString));
			
			if (strpos($videoString, 'iframe') !== false) {
				$anchorRegex = '/src="(.*)?"/isU';
				$results = [];
				if (preg_match($anchorRegex, $videoString, $results)) {
					$link = trim($results[1]);
				}
			} else {
				$link = $videoString;
			}
			
			if (!empty($link)) {
				// initial values
				$video_id = null;
				$videoIdRegex = null;
				$results = [];
				$type = '';
				
				if (strpos($link, 'youtu') !== false) {
					if (strpos($link, 'youtube.com') !== false) {
						$videoIdRegex = '/youtube.com\/(?:embed|v|watch\?v=){1}\/?([a-zA-Z0-9_]+)\??/i';
					} else if (strpos($link, 'youtu.be') !== false) {
						$videoIdRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
					}
					
					if ($videoIdRegex !== null) {
						if (preg_match($videoIdRegex, $link, $results)) {
							$video_str = 'http://www.youtube.com/v/%s?fs=1&amp;autoplay=1';
							$thumbnail_str = 'http://img.youtube.com/vi/%s/2.jpg';
							$fullsize_str = 'http://img.youtube.com/vi/%s/0.jpg';
							$video_id = $results[1];
							$type = 'youtube';
						}
					}
				} else if (strpos($videoString, 'vimeo') !== false) {
					if (strpos($videoString, 'player.vimeo.com') !== false) {
						$videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
					} else {
						$videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';
					}
					
					if ($videoIdRegex !== null) {
						if (preg_match($videoIdRegex, $link, $results)) {
							$video_id = $results[1];
							
							try {
								$remote_vimeo = wp_safe_remote_get("http://vimeo.com/api/v2/video/$video_id.php");
								$body_vimeo = wp_remote_retrieve_body($remote_vimeo);
								$hash = unserialize($body_vimeo);
								
								if (!empty($hash) && is_array($hash)) {
									$video_str = 'http://vimeo.com/moogaloop.swf?clip_id=%s';
									$thumbnail_str = $hash[0]['thumbnail_small'];
									$fullsize_str = $hash[0]['thumbnail_large'];
									$type = 'vimeo';
								} else {
									unset($video_id);
								}
							} catch (Exception $e) {
								unset($video_id);
							}
						}
					}
				}
				
				if (!empty($video_id)) {
					$video = [
						'type' => $type,
						'id' => $video_id,
						'url' => sprintf($video_str, $video_id),
						'thumbnail' => sprintf($thumbnail_str, $video_id),
						'fullsize' => sprintf($fullsize_str, $video_id)
					];
				}
			}
		}
		
		return $video;
	}
	
	public static function get_wp_filesystem() {
		global $wp_filesystem;
		
		if(empty($wp_filesystem)) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			
			WP_Filesystem();
		}
		
		return $wp_filesystem;
	}
	
	/**
	 * Get all meta keys
	 */
	public static function get_all_meta_keys() {
		global $wpdb;
		
		$sql = "SELECT DISTINCT meta_key
			FROM $wpdb->postmeta
			WHERE meta_key NOT BETWEEN '_' AND '_z'
			HAVING meta_key NOT LIKE %s
			ORDER BY meta_key";
		
		return $wpdb->get_col($wpdb->prepare($sql, $wpdb->esc_like('_') . '%'));
	}
}