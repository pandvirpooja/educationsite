/* global jQuery:false */
/* global HOGWORDS_STORAGE:false */

jQuery(document).ready(function() {
	"use strict";

	// Hide empty options
	jQuery('.postbox > .inside').each(function() {
		if (jQuery(this).html().length < 5) jQuery(this).parent().hide();
	});

	// Hide admin notice
	jQuery('#hogwords_admin_notice .hogwords_hide_notice').on('click', function(e) {
		jQuery('#hogwords_admin_notice').slideUp();
		jQuery.post( HOGWORDS_STORAGE['ajax_url'], {'action': 'hogwords_hide_admin_notice'}, function(response){});
		e.preventDefault();
		return false;
	});
	
	// TGMPA Source selector is changed
	jQuery('.tgmpa_source_file').on('change', function(e) {
		var chk = jQuery(this).parents('tr').find('>th>input[type="checkbox"]');
		if (chk.length == 1) {
			if (jQuery(this).val() != '')
				chk.attr('checked', 'checked');
			else
				chk.removeAttr('checked');
		}
	});


	// jQuery Tabs
	//---------------------------------
	if (jQuery.ui && jQuery.ui.tabs)
		jQuery('.hogwords_tabs:not(.inited)').addClass('inited').tabs();
		
	// jQuery Accordion
	//----------------------------------
	if (jQuery.ui && jQuery.ui.accordion) {
		jQuery('.hogwords_accordion:not(.inited)').addClass('inited').accordion({
			'header': '.hogwords_accordion_title',
			'heightStyle': 'content'
		});
	}

	// Icons selector
	//----------------------------------
	
	// Add icon selector after the menu item classes field
	jQuery('.edit-menu-item-classes')
		.on('change', function() {
			var icon = hogwords_get_icon_class(jQuery(this).val());
			var selector = jQuery(this).next('.hogwords_list_icons_selector');
			selector.attr('class', hogwords_chg_icon_class(selector.attr('class'), icon));
			if (!icon)
				selector.css('background-image', '');
			else if (icon.indexOf('image-') >= 0) {
				var list = jQuery('.hogwords_list_icons');
				if (list.length > 0) {
					var bg = list.find('.'+icon.replace('image-', '')).css('background-image');
					if (bg && bg!='none') selector.css('background-image', bg);
				}
			}
		})
		.each(function() {
			jQuery(this).after('<span class="hogwords_list_icons_selector" title="'+HOGWORDS_STORAGE['icon_selector_msg']+'"></span>');
			jQuery(this).trigger('change');
		})

	jQuery('.hogwords_list_icons_selector').on('click', function(e) {
		var selector = jQuery(this);
		var input_id = selector.prev().attr('id');
		if (input_id === undefined) {
			input_id = ('hogwords_icon_field_'+Math.random()).replace(/\./g, '');
			selector.prev().attr('id', input_id)
		}
		var in_menu = selector.parents('.menu-item-settings').length > 0;
		var list = in_menu ? jQuery('.hogwords_list_icons') : selector.next('.hogwords_list_icons');
		if (list.length > 0) {
			if (list.css('display')=='none') {
				list.find('span.hogwords_list_active').removeClass('hogwords_list_active');
				var icon = hogwords_get_icon_class(selector.attr('class'));
				if (icon != '') list.find('span[class*="'+icon.replace('image-', '')+'"]').addClass('hogwords_list_active');
				var pos = in_menu ? selector.offset() : selector.position();
				list.find('.hogwords_list_icons_search').val('');
				list.find('span').removeClass('hogwords_list_hidden');
				list.data('input_id', input_id)
					.css({
						'left': pos.left-(in_menu ? 0 : list.outerWidth()-selector.width()-1),
						'top': pos.top+(in_menu ? 0 : selector.height()+4)
					})
					.fadeIn(function() {
						list.find('.hogwords_list_icons_search').focus();
					});
				
			} else
				list.fadeOut();
		}
		e.preventDefault();
		return false;
	});

	jQuery('.hogwords_list_icons_search').on('keyup', function(e) {
		var list = jQuery(this).parent(),
			val = jQuery(this).val();
		list.find('span').removeClass('hogwords_list_hidden');
		if (val!='') list.find('span:not([data-icon*="'+val+'"])').addClass('hogwords_list_hidden');
	});

	jQuery('.hogwords_list_icons span').on('click', function(e) {
		var list = jQuery(this).parent().fadeOut();
		var input = jQuery('#'+list.data('input_id'));
		var selector = input.next();
		var icon = hogwords_alltrim(jQuery(this).attr('class').replace(/hogwords_list_active/, ''));
		var bg = jQuery(this).css('background-image');
		if (bg && bg!='none') icon = 'image-'+icon;
		input.val(hogwords_chg_icon_class(input.val(), icon)).trigger('change');
		selector.attr('class', hogwords_chg_icon_class(selector.attr('class'), icon));
		if (bg && bg!='none') selector.css('background-image', bg);
		e.preventDefault();
		return false;
	});

	function hogwords_chg_icon_class(classes, icon) {
		var chg = false;
		classes = hogwords_alltrim(classes).split(' ');
		icon = icon.split('-');
		for (var i=0; i < classes.length; i++) {
			if (classes[i].indexOf(icon[0]+'-') >= 0) {
				classes[i] = icon.join('-');
				chg = true;
				break;
			}
		}
		if (!chg) {
			if (classes.length == 1 && classes[0] == '')
				classes[0] = icon.join('-');
			else
				classes.push(icon.join('-'));
		}
		return classes.join(' ');
	}

	function hogwords_get_icon_class(classes) {
		var classes = hogwords_alltrim(classes).split(' ');
		var icon = '';
		for (var i=0; i < classes.length; i++) {
			if (classes[i].indexOf('icon-') >= 0) {
				icon = classes[i];
				break;
			} else if (classes[i].indexOf('image-') >= 0) {
				icon = classes[i];
				break;
			}
		}
		return icon;
	}

		
	// Checklist
	//------------------------------------------------------
	jQuery('.hogwords_checklist:not(.inited)').addClass('inited')
		.on('change', 'input[type="checkbox"]', function() {
			var choices = '';
			var cont = jQuery(this).parents('.hogwords_checklist');
			cont.find('input[type="checkbox"]').each(function() {
				choices += (choices ? '|' : '') + jQuery(this).data('name') + '=' + (jQuery(this).get(0).checked ? jQuery(this).val() : '0');
			});
			cont.siblings('input[type="hidden"]').eq(0).val(choices).trigger('change');
		})
		.each(function() {
			if (jQuery.ui.sortable && jQuery(this).hasClass('hogwords_sortable')) {
				var id = jQuery(this).attr('id');
				if (id === undefined)
					jQuery(this).attr('id', 'hogwords_sortable_'+(''+Math.random()).replace('.', ''));
				jQuery(this).sortable({
					items: ".hogwords_sortable_item",
					placeholder: ' hogwords_checklist_item_label hogwords_sortable_item hogwords_sortable_placeholder',
					update: function(event, ui) {
						var choices = '';
						ui.item.parent().find('input[type="checkbox"]').each(function() {
							choices += (choices ? '|' : '') 
									+ jQuery(this).data('name') + '=' + (jQuery(this).get(0).checked ? jQuery(this).val() : '0');
						});
						ui.item.parent().siblings('input[type="hidden"]').eq(0).val(choices).trigger('change');
					}
				})
				.disableSelection();
			}
		});



	// Range Slider
	//------------------------------------
	if (jQuery.ui && jQuery.ui.slider) {
		jQuery('.hogwords_range_slider:not(.inited)').addClass('inited')
			.each(function () {
				// Get parameters
				var range_slider = jQuery(this);
				var linked_field = range_slider.data('linked_field');
				if (linked_field===undefined) linked_field = range_slider.siblings('input[type="hidden"],input[type="text"]');
				else linked_field = jQuery('#'+linked_field);
				if (linked_field.length == 0) return;
				linked_field.on('change', function() {
					var minimum = range_slider.data('min');
					if (minimum===undefined) minimum = 0;
					var maximum = range_slider.data('max');
					if (maximum===undefined) maximum = 0;
					var values = jQuery(this).val().split(',');
					for (var i=0; i < values.length; i++) {
						if (isNaN(values[i])) value[i] = minimum;
						values[i] = Math.max(minimum, Math.min(maximum, Number(values[i])));
						if (values.length == 1)
							range_slider.slider('value', values);
						else
							range_slider.slider('values', i, values[i]);
					}
					update_cur_values(values);
					jQuery(this).val(values.join(','));
				});
				var range_slider_cur = range_slider.find('> .hogwords_range_slider_label_cur');
				var range_slider_type = range_slider.data('range');
				if (range_slider_type===undefined) range_slider_type = 'min';
				var values = linked_field.val().split(',');
				var minimum = range_slider.data('min');
				if (minimum===undefined) minimum = 0;
				var maximum = range_slider.data('max');
				if (maximum===undefined) maximum = 0;
				var step = range_slider.data('step');
				if (step===undefined) step = 1;
				// Init range slider
				var init_obj = {
					range: range_slider_type,
					min: minimum,
					max: maximum,
					step: step,
					slide: function(event, ui) {
						var cur_values = range_slider_type === 'min' ? [ui.value] : ui.values;
						linked_field.val(cur_values.join(',')).trigger('change');
						update_cur_values(cur_values);
					},
					create: function(event, ui) {
						update_cur_values(values);
					}
				};
				function update_cur_values(cur_values) {
					for (var i=0; i < cur_values.length; i++) {
						range_slider_cur.eq(i)
								.html(cur_values[i])
								.css('left', Math.max(0, Math.min(100, (cur_values[i]-minimum)*100/(maximum-minimum)))+'%');
					}
				}
				if (range_slider_type === true)
					init_obj.values = values;
				else
					init_obj.value = values[0];
				range_slider.addClass('inited').slider(init_obj);
			});
	}
		

	// Text Editor
	//------------------------------------------------------------------

	// Save editors content to the hidden field
	jQuery( document ).on( 'tinymce-editor-init', function() {
		jQuery('.hogwords_text_editor .wp-editor-area' ).each(function(){
			var tArea = jQuery(this),
				id = tArea.attr( 'id' ),
				input = tArea.parents('.hogwords_text_editor').prev(),
				editor = tinyMCE.get(id),
				content;
			// Duplicate content from TinyMCE editor
			if (editor) {
				editor.on('change', function () {
					this.save();
					content = editor.getContent();
					input.val(content).trigger( 'change' );
				});
			}
			// Duplicate content from HTML editor
			tArea.css({
				visibility: 'visible'
			}).on('keyup', function(){
				content = tArea.val();
				input.val( content ).trigger( 'change' );
			});
		});
	});

		

	// 'Edit layout' link
	//------------------------------------------------------------------

	// Refresh link on the post editor when select with layout is changed in VC editor
	jQuery('.hogwords_post_editor').each(function() {
		var sel = jQuery(this).parent().parent().find('select');
		hogwords_change_post_edit_link(jQuery(this), sel.val());
		sel.on('change', function() {
			hogwords_change_post_edit_link(jQuery(this).parent().parent().find('a.hogwords_post_editor'), jQuery(this).val());
		});
	});
	
	function hogwords_change_post_edit_link(a, val) {
		var id = val.split('-').pop();
		if (a.length > 0 && id > 0)
			a.attr('href', a.attr('href').replace(/post=[0-9]{1,5}/, "post="+id));
	}



		

	// Scheme Editor
	//------------------------------------------------------------------
	
	// Show/Hide colors on change scheme editor type
	jQuery('.hogwords_scheme_editor_type input').on('change', function() {
		var type = jQuery(this).val();
		jQuery(this).parents('.hogwords_scheme_editor').find('.hogwords_scheme_editor_colors .hogwords_scheme_editor_row').each(function() {
			var visible = type != 'simple';
			jQuery(this).find('input').each(function() {
				var color_name = jQuery(this).attr('name'),
					fld_visible = type != 'simple';
				if (!fld_visible) {
					for (var i in hogwords_simple_schemes) {
						if (i == color_name || typeof hogwords_simple_schemes[i][color_name] != 'undefined') {
							fld_visible = true;
							break;
						}
					}
				}
				if (!fld_visible)
					jQuery(this).fadeOut();
				else
					jQuery(this).fadeIn();
				visible = visible || fld_visible;
			});
			if (!visible)
				jQuery(this).slideUp();
			else
				jQuery(this).slideDown();
		});
	});
	jQuery('.hogwords_scheme_editor_type input:checked').trigger('change');

	// Change colors on change color scheme
	jQuery('.hogwords_scheme_editor_selector').on('change', function(e) {
		var scheme = jQuery(this).val();
		for (var opt in hogwords_color_schemes[scheme].colors) {
			var fld = jQuery(this).siblings('.hogwords_scheme_editor_colors').find('input[name="'+opt+'"]');
			if (fld.length == 0) continue;
			fld.val( hogwords_color_schemes[scheme].colors[opt] );
			hogwords_scheme_editor_change_field_colors(fld);
		}
	});

	// Internal ColorPicker
	if (jQuery('.hogwords_scheme_editor_colors .iColorPicker').length > 0) {
		hogwords_color_picker();
		jQuery('.hogwords_scheme_editor_colors .iColorPicker').each(function() {
			hogwords_scheme_editor_change_field_colors(jQuery(this));
		}).on('focus', function (e) {
			hogwords_color_picker_show(null, jQuery(this), function(fld, clr) {
				fld.val(clr).trigger('change');
				hogwords_scheme_editor_change_field_colors(fld);
			});
		}).on('change', function(e) {
			hogwords_scheme_editor_change_field_value(jQuery(this));
		});

	// Tiny ColorPicker
	} else if (jQuery('.hogwords_scheme_editor_colors .tinyColorPicker').length > 0) {
		jQuery('.hogwords_scheme_editor_colors .tinyColorPicker').each(function() {
			jQuery(this).colorPicker({
				animationSpeed: 0,
				opacity: false,
				margin: '1px 0 0 0',
				renderCallback: function($elm, toggled) {
					var colors = this.color.colors,
						rgb = colors.RND.rgb,
						clr = (colors.alpha == 1 
								? '#'+colors.HEX 
								: 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + (Math.round(colors.alpha * 100) / 100) + ')'
								).toLowerCase();
					$elm.val(clr).data('last-color', clr);
					if (toggled === undefined) $elm.trigger('change');
				}
			})
			.on('change', function(e) {
				hogwords_scheme_editor_change_field_value(jQuery(this));
			});
		});
	}
	
	// Change colors of the field
	function hogwords_scheme_editor_change_field_colors(fld) {
		var clr = fld.val(),
			hsb = hogwords_hex2hsb(clr);
		fld.css({
			'backgroundColor': clr,
			'color': hsb['b'] < 70 ? '#fff' : '#000'
		});
	}
	
	// Change value of the field
	function hogwords_scheme_editor_change_field_value(fld) {
		var color_name = fld.attr('name'),
			color_value = fld.val();
		// Change value in the color scheme storage
		hogwords_color_schemes[fld.parents('.hogwords_scheme_editor').find('.hogwords_scheme_editor_selector').val()].colors[color_name] = color_value;
		if (typeof wp.customize != 'undefined')
			wp.customize('scheme_storage').set(hogwords_serialize(hogwords_color_schemes))
		else
			fld.parents('form').find('[data-param="scheme_storage"] > input[type="hidden"]').val(hogwords_serialize(hogwords_color_schemes));
		// Change field colors
		hogwords_scheme_editor_change_field_colors(fld);
		// Change dependent colors
		if (fld.parents('.hogwords_scheme_editor').find('.hogwords_scheme_editor_type input:checked').val() == 'simple') {
			if (typeof hogwords_simple_schemes[color_name] != 'undefined') {
				var scheme_name = jQuery('.hogwords_scheme_editor_selector').val();
				for (var i in hogwords_simple_schemes[color_name]) {
					var chg_fld = fld.parents('.hogwords_scheme_editor_colors').find('input[name="'+i+'"]');
					if (chg_fld.length > 0) {
						var level = hogwords_simple_schemes[color_name][i];
						// Make color_value darkness
						if (level != 1) {
							var hsb = hogwords_hex2hsb(color_value);
							hsb['b'] = Math.min(100, Math.max(0, hsb['b'] * (hsb['b'] < 70 ? 2-level : level)));
							color_value = hogwords_hsb2hex(hsb).toLowerCase();
						}
						chg_fld.val(color_value);
						hogwords_scheme_editor_change_field_value(chg_fld);
					}
				}
			}
		}
	}


	// Standard WP Color Picker
	//-------------------------------------------------
	if (jQuery('.hogwords_color_selector').length > 0) {
		jQuery('.hogwords_color_selector').wpColorPicker({
	
			// a callback to fire whenever the color changes to a valid color
			change: function(e, ui){
				jQuery(e.target).val(ui.color).trigger('change');
			},
	
			// a callback to fire when the input is emptied or an invalid color
			clear: function(e) {
				jQuery(e.target).prev().trigger('change')
			}
		});
	}




	// Media selector
	//--------------------------------------------
	HOGWORDS_STORAGE['media_id'] = '';
	HOGWORDS_STORAGE['media_frame'] = [];
	HOGWORDS_STORAGE['media_link'] = [];
	jQuery('.hogwords_media_selector').on('click', function(e) {
		hogwords_show_media_manager(this);
		e.preventDefault();
		return false;
	});
	jQuery('.hogwords_options_field_preview').on('click', '> span', function(e) {
		var image = jQuery(this);
		var button = image.parent().prev('.hogwords_media_selector');
		var field = jQuery('#'+button.data('linked-field'));
		if (field.length == 0) return;
		if (button.data('multiple')==1) {
			var val = field.val().split('|');
			val.splice(image.index(), 1);
			field.val(val.join('|'));
			image.remove();
		} else {
			field.val('');
			image.remove();
		}
		e.preventDefault();
		return false;
	});

	function hogwords_show_media_manager(el) {
		HOGWORDS_STORAGE['media_id'] = jQuery(el).attr('id');
		HOGWORDS_STORAGE['media_link'][HOGWORDS_STORAGE['media_id']] = jQuery(el);
		// If the media frame already exists, reopen it.
		if ( HOGWORDS_STORAGE['media_frame'][HOGWORDS_STORAGE['media_id']] ) {
			HOGWORDS_STORAGE['media_frame'][HOGWORDS_STORAGE['media_id']].open();
			return false;
		}
		var type = HOGWORDS_STORAGE['media_link'][HOGWORDS_STORAGE['media_id']].data('type') 
						? HOGWORDS_STORAGE['media_link'][HOGWORDS_STORAGE['media_id']].data('type') 
						: 'image';
		var args = {
			// Set the title of the modal.
			title: HOGWORDS_STORAGE['media_link'][HOGWORDS_STORAGE['media_id']].data('choose'),
			// Multiple choise
			multiple: HOGWORDS_STORAGE['media_link'][HOGWORDS_STORAGE['media_id']].data('multiple')==1 
						? 'add' 
						: false,
			// Customize the submit button.
			button: {
				// Set the text of the button.
				text: HOGWORDS_STORAGE['media_link'][HOGWORDS_STORAGE['media_id']].data('update'),
				// Tell the button not to close the modal, since we're
				// going to refresh the page when the image is selected.
				close: true
			}
		};
		// Allow sizes and filters for the images
		if (type == 'image') {
			args['frame'] = 'post';
		}
		// Tell the modal to show only selected post types
		if (type == 'image' || type == 'audio' || type == 'video') {
			args['library'] = {
				type: type
			};
		}
		HOGWORDS_STORAGE['media_frame'][HOGWORDS_STORAGE['media_id']] = wp.media(args);

		// When an image is selected, run a callback.
		HOGWORDS_STORAGE['media_frame'][HOGWORDS_STORAGE['media_id']].on( 'insert select', function(selection) {
			// Grab the selected attachment.
			var field = jQuery("#"+HOGWORDS_STORAGE['media_link'][HOGWORDS_STORAGE['media_id']].data('linked-field')).eq(0);
			var attachment = null, attachment_url = '';
			if (HOGWORDS_STORAGE['media_link'][HOGWORDS_STORAGE['media_id']].data('multiple')===1) {
				HOGWORDS_STORAGE['media_frame'][HOGWORDS_STORAGE['media_id']].state().get('selection').map( function( att ) {
					attachment_url += (attachment_url ? "|" : "") + att.toJSON().url;
				});
				var val = field.val();
				attachment_url = val + (val ? "|" : '') + attachment_url;
			} else {
				attachment = HOGWORDS_STORAGE['media_frame'][HOGWORDS_STORAGE['media_id']].state().get('selection').first().toJSON();
				attachment_url = attachment.url;
				var sizes_selector = jQuery('.media-modal-content .attachment-display-settings select.size');
				if (sizes_selector.length > 0) {
					var size = hogwords_get_listbox_selected_value(sizes_selector.get(0));
					if (size != '') attachment_url = attachment.sizes[size].url;
				}
			}
			// Display images in the preview area
			var preview = field.siblings('.hogwords_options_field_preview');
			if (preview.length == 0) {
				jQuery('<span class="hogwords_options_field_preview"></span>').insertAfter(field);
				preview = field.siblings('.hogwords_options_field_preview');
			}
			if (preview.length != 0) preview.empty();
			var images = attachment_url.split("|");
			for (var i=0; i < images.length; i++) {
				if (preview.length != 0) {
					var ext = hogwords_get_file_ext(images[i]);
					preview.append('<span>'
									+ (ext=='gif' || ext=='jpg' || ext=='jpeg' || ext=='png' 
											? '<img src="'+images[i]+'">'
											: '<a href="'+images[i]+'">'+hogwords_get_file_name(images[i])+'</a>'
										)
									+ '</span>');
				}
			}
			// Update field
			field.val(attachment_url).trigger('change');
		});

		// Finally, open the modal.
		HOGWORDS_STORAGE['media_frame'][HOGWORDS_STORAGE['media_id']].open();
		return false;
	}

});