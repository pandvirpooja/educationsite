<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.10
 */

// Copyright area
$hogwords_footer_scheme =  hogwords_is_inherit(hogwords_get_theme_option('footer_scheme')) ? hogwords_get_theme_option('color_scheme') : hogwords_get_theme_option('footer_scheme');
$hogwords_copyright_scheme = hogwords_is_inherit(hogwords_get_theme_option('copyright_scheme')) ? $hogwords_footer_scheme : hogwords_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($hogwords_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$hogwords_copyright = hogwords_prepare_macros(hogwords_get_theme_option('copyright'));
				if (!empty($hogwords_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $hogwords_copyright, $hogwords_matches)) {
						$hogwords_copyright = str_replace($hogwords_matches[1], date_i18n(str_replace(array('{', '}'), '', $hogwords_matches[1])), $hogwords_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($hogwords_copyright));
				}
			?></div>
		</div>
	</div>
</div>
