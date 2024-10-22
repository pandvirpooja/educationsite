<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'hogwords_tribe_events_get_css' ) ) {
	add_filter( 'hogwords_filter_get_css', 'hogwords_tribe_events_get_css', 10, 4 );
	function hogwords_tribe_events_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
			
.tribe-events-list .tribe-events-list-event-title {
	{$fonts['h3_font-family']}
}

.tribe-events-calendar-month__header-column-title.tribe-common-b3,
.tribe-common .tribe-common-b3,
.tribe-events .tribe-events-c-ical__link,
.tribe-common .tribe-common-c-btn-border, 
.tribe-common a.tribe-common-c-btn-border,
body .tribe-events .tribe-events-c-top-bar__datepicker-button,
.tribe-common .tribe-common-c-btn,
.tribe-events .tribe-events-c-view-selector__list-item-text,

.tribe-events .tribe-events-c-nav__list-item--today .tribe-events-c-nav__today,
.tribe-events .tribe-events-c-nav__next, .tribe-events .tribe-events-c-nav__prev,
.tribe-events .tribe-events-c-nav__next:disabled, .tribe-events .tribe-events-c-nav__prev:disabled,
#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more {
	{$fonts['button_font-family']}
	{$fonts['button_letter-spacing']}
}
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-calendar thead th,
.tribe-events-schedule, .tribe-events-schedule h2 {
	{$fonts['h5_font-family']}
}
#tribe-bar-form input, #tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title {
	{$fonts['p_font-family']}
}
.tribe-events-loop .tribe-event-schedule-details,
.single-tribe_events #tribe-events-content .tribe-events-event-meta dt,
#tribe-mobile-container .type-tribe_events .tribe-event-date-start {
	{$fonts['info_font-family']};
}

CSS;

			
			$rad = hogwords_get_border_radius();
			$css['fonts'] .= <<<CSS


CSS;
		}


		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Filters bar */

#tribe-events-bar{
	background-color: {$colors['alter_bg_color']};
}
#tribe-bar-form {
	color: {$colors['text_dark']};
}
#tribe-bar-form input[type="text"] {
	color: {$colors['text']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['bg_color']};
}
.tribe-bar-views-open .tribe-bar-views-list {
	background-color: {$colors['text_hover']};
}

.datepicker thead tr:first-child th:hover, .datepicker tfoot tr th:hover {
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}
#tribe-bar-form .tribe-bar-submit input[type="submit"]{
	background: {$colors['text_link']};
}
#tribe-bar-form .tribe-bar-submit input[type="submit"]:hover{
	background: {$colors['text_link2']};
}
.datepicker table tr td.active.active, .datepicker table tr td span.active.active{
	background: {$colors['text_link']};
}
.tribe-events .datepicker .day.focused, .tribe-events .datepicker .day:focus, .tribe-events .datepicker .day:hover, .tribe-events .datepicker .month.focused, .tribe-events .datepicker .month:focus, .tribe-events .datepicker .month:hover, .tribe-events .datepicker .year.focused, .tribe-events .datepicker .year:focus, .tribe-events .datepicker .year:hover,
.datepicker table tr td.active.active:hover, 
.datepicker table tr td span.active.active:hover{
	background: {$colors['text_link']};
}
.datepicker table tr td span:hover{
	background: {$colors['text_hover']};
}
.datepicker .datepicker-switch:hover, .datepicker .next:hover, .datepicker .prev:hover, .datepicker tfoot tr th:hover{
	background: {$colors['text_hover']};
}
.datepicker table tr td span.focused, .datepicker table tr td span:hover{
	background: {$colors['text_link']};
}

/* Content */
.tribe-events-calendar thead th {
	color: {$colors['bg_color']};
	background: {$colors['extra_bg_color']} !important;
	border-color: {$colors['bg_color']} !important;
}
.tribe-events-calendar thead th + th:before {
	background: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td {
	border-color: {$colors['alter_bd_color']} !important;
}

.tribe-events-calendar td.tribe-events-othermonth {
	color: {$colors['alter_light']};
	background: {$colors['alter_bg_color']} !important;
}

.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"]{
	color: {$colors['text_link']}!important;
}
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_link']};
}
.tribe-events-calendar td.tribe-events-present:before {
	border-color: {$colors['text_link']};
}
.tribe-events-calendar .tribe-events-has-events:after {
	background-color: {$colors['text']};
}
.tribe-events-calendar .mobile-active.tribe-events-has-events:after {
	background-color: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active,
#tribe-events-content .tribe-events-calendar td.mobile-active:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']}!important;
}
#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"]{
	background-color: {$colors['text_dark']}!important;
}

#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"] {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*="tribe-events-daynum-"] a,
.tribe-events-calendar .mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: transparent;
	color: {$colors['bg_color']};
}
table.tribe-events-calendar > tbody > tr:first-child > td{
	background-color: {$colors['alter_bg_color']};
}
table.tribe-events-calendar > tbody > tr:nth-child(odd) > td{
	background-color: {$colors['alter_bg_color']};
}
table.tribe-events-calendar > tbody > tr:nth-child(even) > td{
	background-color: {$colors['alter_bg_hover']};
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-othermonth.tribe-events-future div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-othermonth.tribe-events-future div[id*="tribe-events-daynum-"] a{
	color: {$colors['text_light']}!important;
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"] a{
	color: {$colors['text_light']};
}

/* Tooltip */
.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip,
.tribe-events-tooltip .tribe-events-arrow {
	color: {$colors['alter_text']};
	background: {$colors['alter_bg_color']};
}
#tribe-events-content .tribe-events-tooltip h3,
#tribe-events-content .tribe-events-tooltip h4 { 
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}
.tribe-events-tooltip .tribe-event-duration {
	color: {$colors['text_light']};
}

/* Events list */
.tribe-events-list-separator-month {
	color: {$colors['text_dark']};
}
.tribe-events-list-separator-month:after {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .type-tribe_events + .type-tribe_events,
.tribe-events-day .tribe-events-day-time-slot + .tribe-events-day-time-slot + .tribe-events-day-time-slot {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .tribe-events-event-cost span {
	color: {$colors['bg_color']};
	border-color: {$colors['text_dark']};
	background: {$colors['text_dark']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta {
	color: {$colors['alter_text']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a {
	color: {$colors['alter_link']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a:hover {
	color: {$colors['alter_hover']};
}
.tribe-mobile .tribe-events-list .tribe-events-venue-details {
	border-color: {$colors['alter_bd_color']};
}

/* Events day */
.tribe-events-day .tribe-events-day-time-slot h5 {
	color: {$colors['bg_color']};
	background: {$colors['text_dark']};
}

/* Single Event */
.single-tribe_events .tribe-events-venue-map {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_hover']};
	background: {$colors['alter_bg_hover']};
}
.single-tribe_events .tribe-events-schedule .tribe-events-cost {
	color: {$colors['text_dark']};
}
.single-tribe_events .type-tribe_events {
	border-color: {$colors['bd_color']};
}

.tribe-events-meta-group .tribe-events-single-section-title,
.tribe-events .datepicker .month, .tribe-events .datepicker .year,
.tribe-events .tribe-events-calendar-month__day-date-link,
.tribe-events .tribe-events-calendar-month__day-date-link:focus, .tribe-events .tribe-events-calendar-month__day-date-link:hover,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-datetime,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-title-link,
.tribe-events .datepicker .day, .tribe-events .datepicker .dow,
.tribe-common .tribe-events-calendar-list__event-date-tag-weekday,
.tribe-common .tribe-events-calendar-list__event-date-tag-daynum,
.tribe-events .tribe-events-calendar-list__event-datetime,
.tribe-events .tribe-events-calendar-list__event-title-link,
.tribe-events .tribe-events-calendar-day__event-datetime,
.tribe-common .tribe-events-calendar-day__event-venue-title,
.tribe-events .tribe-events-calendar-day__event-title-link,
.tribe-common .tribe-common-anchor-thina {
	color: {$colors['text_dark']};
}

.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-title-link:hover,
.tribe-events .tribe-events-calendar-list__event-title-link:hover,
.tribe-events .tribe-events-calendar-day__event-title-link:hover,
.tribe-common .tribe-common-anchor-thin:hover {
	color: {$colors['text_link']};
}

.tribe-events .tribe-events-calendar-month__day-date-daynum,
.tribe-events-calendar-month__calendar-event-tooltip-description > p,
.tribe-events .datepicker .past,
.tribe-common .tribe-events-calendar-list__event-description,
.tribe-common .tribe-events-calendar-day__event-description{
	color: {$colors['text']};
}

.tribe-events .tribe-events-c-messages__message-list-item-link {
	color: {$colors['text_link']};
}
.tribe-common .tribe-common-c-svgicon--messages-not-found .tribe-common-c-svgicon__svg-stroke {
	stroke: {$colors['text_link']};
}
.tribe-common .tribe-common-anchor-thin-alt {
	border-color: {$colors['text_link']};
}
.tribe-common .tribe-common-anchor-thin-alt:active, .tribe-common .tribe-common-anchor-thin-alt:focus, .tribe-common .tribe-common-anchor-thin-alt:hover {
	border-color: {$colors['text_hover']};
}

.tribe-events button.tribe-events-c-top-bar__datepicker-button {
	color: {$colors['text_dark']};
}
.tribe-common .tribe-common-c-svgicon__svg-fill {
	fill: {$colors['text_dark']};
}

.tribe-events-c-messages__message-list-item {
	color: {$colors['text_dark']};
}

.tribe-common .tribe-common-c-svgicon--messages-not-found path {
	stroke: {$colors['text_dark']};
}

CSS;
		}
		
		return $css;
	}
}
?>