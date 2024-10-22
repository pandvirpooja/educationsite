<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.14
 */
$hogwords_header_video = hogwords_get_header_video();
$hogwords_embed_video = '';
if (!empty($hogwords_header_video) && !hogwords_is_from_uploads($hogwords_header_video)) {
	if (hogwords_is_youtube_url($hogwords_header_video) && preg_match('/[=\/]([^=\/]*)$/', $hogwords_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$hogwords_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($hogwords_header_video) . '[/embed]' ));
			$hogwords_embed_video = hogwords_make_video_autoplay($hogwords_embed_video);
		} else {
			$hogwords_header_video = str_replace('/watch?v=', '/embed/', $hogwords_header_video);
			$hogwords_header_video = hogwords_add_to_url($hogwords_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$hogwords_embed_video = '<iframe src="' . esc_url($hogwords_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php hogwords_show_layout($hogwords_embed_video); ?></div><?php
	}
}
?>