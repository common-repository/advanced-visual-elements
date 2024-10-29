"use strict";
jQuery(document).ready(function ($) {
	var wp_mobile_breakpoint = 850;
	var is_mobile = $(window).width() <= wp_mobile_breakpoint;

	$(window).on('resize', function () {
		is_mobile = $(window).width() <= wp_mobile_breakpoint;
	});

	var default_transition_time = 150;

	var doing_ajax = false;

	/**
	 * Get element ID
	 */
	function adv_vis_ele_get_element_id(element) {
		return $(element).closest('.adv-vis-ele-library-element').attr('data-id');
	}

	var adv_vis_ele_notifications = $('.adv-vis-ele-notifications');
	if (adv_vis_ele_notifications.length < 1) {
		$('body').append('<div class="adv-vis-ele-notifications"></div>');

		adv_vis_ele_notifications = $('.adv-vis-ele-notifications');
	}

	var adv_vis_ele_library = $('.adv-vis-ele-library');

	/**
	 * Create button
	 */
	adv_vis_ele_library.on('click', '.adv-vis-ele-use-btn', function (e) {
		e.preventDefault();

		var redirect_url = adv_vis_ele_admin_vars.site_url + '/wp-admin/post-new.php?post_type=adv-vis-element&element-id=' + adv_vis_ele_get_element_id($(this));

		window.open(redirect_url, "_self");
	});

	/**
	 * Display notification
	 *
	 * @param type bool - true = success, false = error
	 */
	function adv_vis_ele_display_notification(type, text) {
		adv_vis_ele_notifications.empty();

		var html = '<h5 class="adv-vis-ele-notification adv-vis-ele-' + (type === true ? 'success' : 'error') + '">';

		if (type) {
			html += '<i class="fas fa-smile-beam"></i>';
		} else {
			html += '<i class="fas fa-exclamation-triangle"></i>';
		}

		if (typeof text === 'string') {
			html += text;
		} else {
			if (type) {
				html += 'Operation successfully done.';
			} else {
				html += 'There was an error.';
			}
		}

		html += '<span class="adv-vis-ele-dismiss-notification"></span>';
		html += '</h5>';

		var reference = $(html);

		adv_vis_ele_notifications.prepend(reference);

		setTimeout(function () {
			adv_vis_ele_dismiss_notification(reference.find('.adv-vis-ele-dismiss-notification'));
		}, 5000);
	}

	/**
	 * Dismiss notification
	 */
	$('body').on('click', '.adv-vis-ele-dismiss-notification', function (e) {
		e.preventDefault();

		adv_vis_ele_dismiss_notification($(this));
	});

	function adv_vis_ele_dismiss_notification(element) {
		element.parent().fadeOut(250);
	}

	/**
	 * Element editor settings
	 */
	var adv_vis_ele_element_editor = $('.adv-vis-ele-element-editor');
	if (adv_vis_ele_element_editor.length > 0) {
		$('.color-field').each(function () {
			$(this).wpColorPicker();
		});
	}

	/**
	 * Custom CSS field code highlighter
	 */
	var adv_vis_ele_editor_custom_css = $('#adv-vis-ele-editor-custom-css');
	if (adv_vis_ele_editor_custom_css.length > 0) {
		wp.codeEditor.initialize(adv_vis_ele_editor_custom_css, adv_vis_ele_admin_vars.cm_settings);
	}

	/**
	 * Make publish box on Element editor fixed on scroll
	 */
	$(window).on('scroll resize', function () {
		if (adv_vis_ele_element_editor.length > 0 && !is_mobile) {
			if ($(window).scrollTop() > $('#poststuff').offset().top - 22) {
				$('#postbox-container-1 > #side-sortables').addClass('adv-vis-ele-side-sortables-fixed');
			} else {
				$('#postbox-container-1 > #side-sortables').removeClass('adv-vis-ele-side-sortables-fixed');
			}
		}
	});

	/**
	 * Load more elements in library on scroll
	 */
	var load_more_stopped = false;
	var loaded_all = false;
	if ($('.adv-vis-ele-admin-library').length > 0) {
		$(window).on('scroll', function () {
			var position = $(window).scrollTop();
			var bottom = $(document).height() - $(window).height();

			if (position >= bottom) {
				if (loaded_all) {
					adv_vis_ele_display_notification(true, adv_vis_ele_admin_vars.translations[2]);

					return;
				}

				adv_vis_ele_load_more_elements();
			}
		});
	}

	var load_more_btn = $('.adv-vis-ele-library-load-more button');
	load_more_btn.on('click', function (e) {
		e.preventDefault();

		if (load_more_stopped) {
			return;
		}

		if (loaded_all) {
			adv_vis_ele_display_notification(true, adv_vis_ele_admin_vars.translations[2]);

			return;
		}

		adv_vis_ele_load_more_elements();
	});

	function adv_vis_ele_load_more_elements() {
		if (element_search_string !== element_last_search_string) {
			element_last_search_string = element_search_string;

			adv_vis_ele_library.empty();

			adv_vis_ele_library.attr('data-page', 1);

			loaded_all = false;
			load_more_stopped = false;
		}

		if (load_more_stopped) {
			return;
		}

		$.ajax({
			url: adv_vis_ele_admin_vars.ajax_url,
			type: 'post',
			data: {
				'action': 'adv_vis_ele_ajax_load_more_elements',
				'page': adv_vis_ele_library.attr('data-page'),
				'limit': adv_vis_ele_library.attr('data-limit'),
				'search': element_search_string
			},
			success: function (response) {
				if (response.data.message === 'Loaded all elements.') {
					loaded_all = true;

					adv_vis_ele_display_notification(true, adv_vis_ele_admin_vars.translations[2]);
				} else if (response.data.message === 'No search results.') {
					adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[8]);
				} else {
					adv_vis_ele_library.append(response.data.message);
					adv_vis_ele_library.find('.adv-vis-ele-btn').css('pointer-events', 'all');
					adv_vis_ele_library.attr('data-page', parseInt(adv_vis_ele_library.attr('data-page')) + 1);

					onYouTubeIframeAPIReady();

					adv_initialize_tippy();

					loaded_all = response.data.hide;
				}

				if (response.data.hide) {
					load_more_btn.addClass('adv-vis-ele-library-load-more-hidden');
				} else {
					load_more_btn.removeClass('adv-vis-ele-library-load-more-hidden');
				}

				load_more_stopped = response.data.hide;
			}
		});
	}

	/**
	 * Copy shortcode to clipboard
	 */
	$('#adv-vis-ele-shortcode-code-copy').on('click', function () {
		adv_vis_ele_clipboard_copy($('#adv-vis-ele-shortcode-code-val').text());
	});

	$('#adv-vis-ele-shortcode-code-copy-2').on('click', function () {
		adv_vis_ele_clipboard_copy($('#adv-vis-ele-shortcode-code-val-2').text());
	});

	$('.adv-vis-ele-elements-list-clipboard').on('click', function (e) {
		e.preventDefault();

		var t = $(this).parent().find('code').text();

		adv_vis_ele_clipboard_copy(t);
	});

	function adv_vis_ele_clipboard_copy(value) {
		var tempInput = document.createElement("input");
		tempInput.value = value;
		document.body.appendChild(tempInput);
		tempInput.select();
		document.execCommand("copy");
		document.body.removeChild(tempInput);

		adv_vis_ele_display_notification(true, adv_vis_ele_admin_vars.translations[3]);
	}

	/**
	 * Stop pulsating abbr
	 */
	$('.adv-vis-ele-abbr-important').on('click', function (e) {
		e.preventDefault();

		$(this).removeClass('adv-vis-ele-abbr-important').css('transform', 'scale(1)');
	});

	/**
	 * Web preview link
	 */
	adv_vis_ele_library.on('click', '.adv-vis-ele-span-web-preview', function (e) {
		e.preventDefault();

		window.open($(this).attr('data-web-preview-url'), '_blank');
	});

	/**
	 * Image upload buttons
	 */
	$('.adv-vis-ele-editor-setting-image').each(function () {
		var mediaUploader;

		var $t = $(this);

		$t.on('click', 'a.button', (function (e) {
			e.preventDefault();

			if (mediaUploader) {
				mediaUploader.open();
				return;
			}

			mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				library: {
					type: ['image']
				},
				button: {
					text: 'Choose Image'
				}, multiple: false
			});

			mediaUploader.on('select', function () {
				var attachment = mediaUploader.state().get('selection').first().toJSON();

				$t.find('input').val(attachment.url);
			});

			mediaUploader.open();
		}));
	});

	/**
	 * Video upload buttons
	 */
	$('.adv-vis-ele-editor-setting-video').each(function () {
		var mediaUploader;

		var $t = $(this);

		$t.on('click', 'a.button', (function (e) {
			e.preventDefault();

			if (mediaUploader) {
				mediaUploader.open();
				return;
			}

			mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Video',
				library: {
					type: ['video']
				},
				button: {
					text: 'Choose Video'
				}, multiple: false
			});
			mediaUploader.on('select', function () {
				var attachment = mediaUploader.state().get('selection').first().toJSON();

				$t.find('input').val(attachment.url);
			});
			mediaUploader.open();
		}));
	});

	/**
	 * Confirm button clicks
	 */
	$('.adv-vis-ele-confirm').on('click', function (e) {
		var confirmation_message = confirm(adv_vis_ele_admin_vars.translations[4]);

		if (confirmation_message) {
			return true;
		}

		e.preventDefault();
	});

	/**
	 * Tooltips
	 */
	function adv_initialize_tippy() {
		$('.adv-vis-ele-abbr').each(function () {
			var $t = $(this);

			if ($t.attr('data-tippy-initialized') != true) {
				tippy($(this)[0], {
					content: function () {
						var tippy_content = $t.find('.adv-vis-ele-abbr-tippy-content');

						if (tippy_content.length > 0) {
							return tippy_content.html();
						} else {
							return $t.attr('data-title');
						}
					},
					maxWidth: 300,
					allowHTML: true,
					theme: 'adv',
					interactive: true,
					placement: 'bottom',
					appendTo: document.body,
					zIndex: 999999
				});

				$t.attr('data-tippy-initialized', true);
			}
		});
	}

	adv_initialize_tippy();

	/**
	 * Change Add New Element button to point to library
	 */
	if (adv_vis_ele_admin_vars.is_add_new_btn === '1') {
		if ($('.adv-vis-ele-element-editor').length > 0) {
			var btn = $('.page-title-action');

			btn.addClass('adv-vis-ele-btn');

			var element_btn = btn.clone().addClass('adv-vis-ele-btn').insertBefore(btn);

			element_btn.attr('href', adv_vis_ele_admin_vars.wp_admin_url + 'post-new.php?post_type=adv-vis-element&element-id=' + $('input[name="element-id"]').val()).text(btn.text() + ' - ' + $('.adv-vis-ele-editor-element-name b').text());

			btn.attr('href', adv_vis_ele_admin_vars.admin_url + '?page=adv-vis-ele');
		} else {
			$('.page-title-action').attr('href', adv_vis_ele_admin_vars.admin_url + '?page=adv-vis-ele');
		}
	}

	/**
	 * Element editor - Import settings
	 */
	$('.adv-vis-ele-editor-import-container button').on('click', function (e) {
		e.preventDefault();

		var textarea = $('#adv-vis-ele-import-settings');

		if (textarea.val().trim() == '') {
			adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[5]);

			return;
		}

		if (doing_ajax) {
			return;
		}

		doing_ajax = true;

		$.ajax({
			url: adv_vis_ele_admin_vars.ajax_url,
			type: 'post',
			data: {
				'nonce': adv_vis_ele_admin_vars.nonce,
				'action': 'adv_vis_ele_ajax_import_settings',
				'id': $(this).attr('data-post-id'),
				'element-id': $(this).attr('data-element-id'),
				'settings': JSON.parse(textarea.val().trim())
			},
			success: function (response) {
				adv_vis_ele_display_notification(response.success, response.data.message);

				if (response.success) {
					setTimeout(function () {
						if (response.data.redirection_url.length > 0) {
							window.location = response.data.redirection_url;
						} else {
							location.reload();
						}
					}, 2000);
				} else {
					adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[7]);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[7]);
			},
			complete: function () {
				doing_ajax = false;
			}
		});
	});

	/**
	 * Copy options button
	 */
	$('.adv-vis-ele-editor-export-container button').on('click', function () {
		adv_vis_ele_clipboard_copy($('#adv-vis-ele-export-settings').val());
	});

	/**
	 * Elements search
	 */
	var library_category_top_links = $('.adv-vis-ele-library-top-categories a');
	var library_top_search_input = $('.adv-vis-ele-library-search input');
	var element_search_string = '';
	var element_last_search_string = '';
	$('.adv-vis-ele-library-search').on('submit', function (e) {
		e.preventDefault();
	});

	$('.adv-vis-ele-library-search button').on('click', function (e) {
		e.preventDefault();

		element_search_string = library_top_search_input.val().trim();

		if (element_search_string === element_last_search_string) {
			return;
		}

		library_category_top_links.removeClass('adv-vis-ele-btn-active');

		adv_vis_ele_load_more_elements();
	});

	/**
	 * FAQ accordion
	 */
	$('.adv-vis-ele-admin-support-faq i').on('click', function () {
		$(this).next().slideToggle(default_transition_time, 'linear');
	});

	/**
	 * Library ordering
	 */
	$('.adv-vis-ele-library-ordering select').on('change', function () {
		var ordering = $(this).val();

		$.ajax({
			url: adv_vis_ele_admin_vars.ajax_url,
			type: 'post',
			data: {
				'nonce': adv_vis_ele_admin_vars.nonce,
				'action': 'adv_vis_ele_ajax_save_ordering',
				'ordering': ordering
			},
			success: function (response) {

			},
			error: function () {

			},
			complete: function () {
				location.reload();
			}
		});
	});

	/**
	 * Copy CSS selector
	 */
	$('.adv-vis-ele-shortcode-css-parent-selector-copy').on('click', function () {
		adv_vis_ele_clipboard_copy($('.adv-vis-ele-shortcode-css-parent-selector code').text());
	});

	/**
	 * Library Import button popup
	 */
	tippy($('.adv-vis-ele-library-full-import button')[0], {
		content: function () {
			return '<textarea class="adv-vis-ele-library-full-import-textarea" placeholder="' + adv_vis_ele_admin_vars.translations[10] + '"></textarea><button class="adv-vis-ele-btn adv-vis-ele-library-full-import-btn">GO</button>';
		},
		trigger: 'click',
		maxWidth: 450,
		allowHTML: true,
		theme: 'adv',
		interactive: true,
		placement: 'bottom',
		zIndex: 9999
	});

	/**
	 * Full settings import
	 */
	$('.adv-vis-ele-library-full-import').on('click', '.adv-vis-ele-library-full-import-btn', function (e) {
		e.preventDefault();

		var settings = $('.adv-vis-ele-library-full-import-textarea').val().trim();

		if (!settings) {
			return;
		}

		$.ajax({
			url: adv_vis_ele_admin_vars.ajax_url,
			type: 'post',
			data: {
				'nonce': adv_vis_ele_admin_vars.nonce,
				'action': 'adv_vis_ele_ajax_full_import',
				'settings': JSON.parse(settings)
			},
			success: function (response) {
				if (response.success) {
					window.location = response.data.redirection_url;
				} else {
					adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[7]);
				}
			},
			error: function () {
				adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[7]);
			}
		});
	});

	/**
	 * Toggle DEV dashboard
	 */
	var adv_vis_ele_dev_dashboard = $('.adv-vis-ele-dev-dashboard');
	$('.adv-vis-ele-dev-dashboard-toggle').on('click', function (e) {
		e.preventDefault();

		adv_vis_ele_dev_dashboard.toggleClass('adv-vis-ele-dev-dashboard-on');
	});

	/**
	 * Previewer theme switcher
	 */
	var previewerThemeSwitcher = $('.adv-vis-ele-element-previewer-theme');
	previewerThemeSwitcher.on('click', function (e) {
		e.preventDefault();

		var oldTheme = previewerThemeSwitcher.attr('data-theme');
		var newTheme = oldTheme === 'light' ? 'dark' : 'light';

		previewerThemeSwitcher.attr('data-theme', newTheme);

		localStorage.setItem('adv-vis-ele-previewer-theme', newTheme);

		document.getElementsByClassName('adv-vis-ele-element-previewer-container')[0].scrollIntoView({behavior: 'smooth'});

		refresh_quick_preview();
	});

	/**
	 * Refresh Quick preview and scroll to it
	 */
	var enabled_settings = $('.adv-vis-ele-editor-setting[data-license="enabled"]');
	var option_inputs = enabled_settings.find('input:not([type="hidden"]):not([type="button"]), select');
	var tinymce_inputs = enabled_settings.find('.wp-editor-area');
	$('.adv-vis-ele-preview-link > a').on('click', function (e) {
		e.preventDefault();

		refresh_quick_preview();

		document.getElementsByClassName('adv-vis-ele-element-previewer-container')[0].scrollIntoView({behavior: 'smooth'});
	});

	var quick_preview_iframe = $('.adv-vis-ele-element-previewer > iframe');
	var quick_preview_original_src = quick_preview_iframe.attr('src');
	var refresh_quick_preview = function () {
		var new_src = quick_preview_original_src;

		var settings = {};

		option_inputs.each(function (index, element) {
			var val;

			if ($(element).attr('type') === 'checkbox') {
				val = $(element).prop('checked') === true ? 'on' : '';
			} else {
				val = $(element).val();
			}

			settings[$(element).attr('id')] = val;
		});

		tinymce_inputs.each(function (index, element) {
			var id = $(this).attr('id');

			var editor = tinymce.editors[id];

			if (id && editor) {
				settings[id] = editor.getContent();
			}
		});

		if (doing_ajax) {
			return;
		}

		doing_ajax = true;

		var ed = $('.adv-vis-ele-admin-editor');

		var data = {
			'nonce': adv_vis_ele_admin_vars.nonce,
			'action': 'adv_vis_ele_ajax_quick_save',
			'id': ed.attr('data-post-id'),
			'element-id': ed.attr('data-element-id'),
			'settings': settings
		};

		$.ajax({
			url: adv_vis_ele_admin_vars.ajax_url,
			type: 'post',
			data: data,
			success: function (response) {
				if (response.success) {
					var theme = previewerThemeSwitcher.attr('data-theme');

					quick_preview_iframe.attr('src', new_src + '&ave-preview-theme=' + theme + '&ave-preview-settings=true');

					$('#adv-vis-ele-export-settings').val(response.data.export);
				} else {
					adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[14]);
				}
			},
			error: function () {
				adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[14]);
			},
			complete: function () {
				doing_ajax = false;
			}
		});
	};

	if ($('.adv-vis-ele-element-previewer-container').length > 0) {
		var previewerTheme = localStorage.getItem('adv-vis-ele-previewer-theme');

		if (previewerTheme) {
			previewerThemeSwitcher.attr('data-theme', previewerTheme);

			if (previewerTheme !== 'light') {
				refresh_quick_preview();
			}
		}
	}

	/**
	 * Dynamic post settings
	 */
	var dynamic_settings_modal = $('#adv-vis-ele-element-dynamic-settings-modal');
	var dynamic_settings_modal_close = $('.adv-vis-ele-element-dynamic-settings-modal-close');
	var selected_setting_input = false;
	var delimiter_s = adv_vis_ele_admin_vars.dynamic_setting_delimiter_start;
	var delimiter_e = adv_vis_ele_admin_vars.dynamic_setting_delimiter_end;
	$('.adv-vis-ele-setting-dynamic-add').on('click', function (e) {
		e.preventDefault();

		selected_setting_input = $(this).closest('.adv-vis-ele-editor-setting').find('input[name^="adv-vis-ele-editor-settings"], textarea.wp-editor-area');

		var setting_divs = dynamic_settings_modal.find('.adv-vis-ele-element-dynamic-settings-modal-add > div');

		setting_divs.find('a').hide();

		var type = $(this).attr('data-type');

		dynamic_settings_modal.find('.adv-vis-ele-element-dynamic-settings-type').text(type);

		if (type === 'text' || type === 'content') {
			setting_divs.find('a').show();
		} else if (type === 'image') {
			setting_divs.find('a[data-setting="' + delimiter_s + 'POST_FEATURED_IMAGE' + delimiter_e + '"]').show();
			setting_divs.find('a[data-setting="' + delimiter_s + 'WOO_PRODUCT_IMAGE' + delimiter_e + '"]').show();
		}

		if (type === 'image') {
			setting_divs.find('a[data-setting="' + delimiter_s + 'META_FIELD' + delimiter_e + '"]').hide();
			setting_divs.find('.adv-vis-ele-element-dynamic-settings-meta-key').parent().hide();
		} else {
			setting_divs.find('a[data-setting="' + delimiter_s + 'META_FIELD' + delimiter_e + '"]').show();
			setting_divs.find('.adv-vis-ele-element-dynamic-settings-meta-key').parent().show();
		}

		dynamic_settings_modal.fadeIn(default_transition_time);
	});

	$('.adv-vis-ele-element-dynamic-settings-modal-add a').on('click', function (e) {
		e.preventDefault();

		if (!adv_vis_ele_admin_vars.is_pro) {
			adv_vis_ele_display_notification(false, adv_vis_ele_admin_vars.translations[13]);

			return false;
		}

		if (selected_setting_input) {
			if ($(this).attr('data-setting') === '' + delimiter_s + 'META_FIELD' + delimiter_e + '') {
				var key = $('.adv-vis-ele-element-dynamic-settings-meta-key').val();

				if (key) {
					if (tinymce.activeEditor) {
						selected_setting_input.val(tinymce.activeEditor.getContent() + delimiter_s + 'META_FIELD_' + key + delimiter_e);
					} else {
						selected_setting_input.val(selected_setting_input.val() + delimiter_s + 'META_FIELD_' + key + delimiter_e);
					}
				}
			} else {
				if (selected_setting_input.closest('.adv-vis-ele-editor-setting').hasClass('adv-vis-ele-editor-setting-image')) {
					selected_setting_input.val($(this).attr('data-setting'));
				} else if (selected_setting_input.closest('.adv-vis-ele-editor-setting').hasClass('adv-vis-ele-editor-setting-content')) {
					if (tinymce.activeEditor && selected_setting_input.closest('.wp-editor-wrap').hasClass('tmce-active')) {
						tinymce.activeEditor.setContent(tinymce.activeEditor.getContent() + $(this).attr('data-setting'));
					} else {
						selected_setting_input.val(selected_setting_input.val() + $(this).attr('data-setting'));
					}
				} else {
					selected_setting_input.val(selected_setting_input.val() + $(this).attr('data-setting'));
				}
			}

			dynamic_settings_modal.fadeOut(default_transition_time);

			selected_setting_input = false;
		}
	});

	$('.adv-vis-ele-element-dynamic-settings-meta-select').on('change', function (e) {
		e.preventDefault();

		$('.adv-vis-ele-element-dynamic-settings-meta-key').val($(this).val());
	});

	dynamic_settings_modal_close.on('click', function (e) {
		e.preventDefault();

		dynamic_settings_modal.fadeOut(default_transition_time);

		selected_setting_input = false;
	});

	$(document).keyup(function (e) {
		if (!selected_setting_input) {
			return;
		}

		if (e.key === "Escape") {
			dynamic_settings_modal.fadeOut(default_transition_time);

			selected_setting_input = false;
		}
	});

	/**
	 * Show new Elements on click
	 */
	$('.adv-vis-ele-library-top-new-elements a').on('click', function (e) {
		e.preventDefault();

		if ($(this).text() === element_last_search_string) {
			return;
		}

		if ($('.adv-vis-ele-library-top-new-elements-x').length < 1) {
			$(this).parent().append('<a href="#" class="adv-vis-ele-library-top-new-elements-x">X</a>');

			$('.adv-vis-ele-library-top-new-elements-x').on('click', function (x) {
				x.preventDefault();

				element_search_string = '';

				adv_vis_ele_load_more_elements();

				$(this).remove();
			});
		}

		element_search_string = $(this).text();

		adv_vis_ele_load_more_elements();
	});

	/**
	 * Element categories in Library
	 */
	library_category_top_links.on('click', function (e) {
		e.preventDefault();

		if ($(this).hasClass('adv-vis-ele-btn-active')) {
			$(this).removeClass('adv-vis-ele-btn-active');

			element_search_string = '';

			adv_vis_ele_load_more_elements();
		} else {
			if ($(this).attr('data-category') === element_last_search_string) {
				return;
			}

			library_category_top_links.removeClass('adv-vis-ele-btn-active');

			$(this).addClass('adv-vis-ele-btn-active');

			element_search_string = $(this).attr('data-category');

			adv_vis_ele_load_more_elements();
		}

		library_top_search_input.val(element_last_search_string);
	});

	/**
	 * Editor container styles dropdown
	 */
	var containerStyles = $('#adv-vis-ele-editor-container-styles');
	containerStyles.on('change', function () {
		var v = $(this).val();

		var d = $('#adv-vis-ele-editor-container-styles-vertical');

		if (v.substring(0, 4) === 'flex' || v === 'center') {
			d.show();
		} else {
			d.hide();
		}
	});
	containerStyles.change();
});

/**
 * Initialize YT API for each video
 */
function adv_load_yt_api() {
	var tag = document.createElement('script');

	tag.src = 'https://www.youtube.com/iframe_api';
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

adv_load_yt_api();

function onYouTubeIframeAPIReady() {
	Array.from(document.getElementsByClassName("adv-vis-ele-api-video-not-started")).forEach(
		function (element, index, array) {
			if (typeof YT == 'undefined') {
				return;
			}

			var id = element.getAttribute('data-src');

			if (id === '') {
				element.classList.add("adv-vis-ele-api-video-missing-id");

				return;
			}

			var iframe;

			element.classList.remove("adv-vis-ele-api-video-not-started");

			var autoplay_videos_in_library = adv_vis_ele_admin_vars.auto_play_library_videos;

			new YT.Player(element.getAttribute('id'), {
				videoId: id,            // YouTube Video ID
				width: 534,             // Player width (in px)
				height: 300,            // Player height (in px)
				playerVars: {
					autoplay: autoplay_videos_in_library, // Auto-play the video on load
					controls: 0,        // Show pause/play buttons in player
					showinfo: 0,        // Hide the video title
					modestbranding: 1,  // Hide the Youtube Logo
					loop: 1,            // Run the video in a loop
					fs: 1,              // Hide the full screen button
					cc_load_policy: 0,  // Hide closed captions
					iv_load_policy: 3,  // Hide the Video Annotations
					autohide: 0,        // Hide video controls when playing
					mute: 1,
					rel: 0,
					origin: adv_vis_ele_admin_vars.site_url
				},
				events: {
					'onReady': onPlayerReady
				}
			});

			function onPlayerReady(event) {
				if (autoplay_videos_in_library === 1) {
					event.target.playVideo();
				}

				iframe = document.getElementById('adv-vis-ele-video-id-' + id);

				document.getElementById('adv-vis-ele-span-fullscreen-' + id).addEventListener('click', function () {
					var requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;

					if (requestFullScreen) {
						requestFullScreen.bind(iframe)();
					}
				});

				setInterval(function () {
					if (event.data == YT.PlayerState.playing) {
						if (event.target.getDuration() - event.target.getCurrentTime() < 1) {
							event.target.seekTo(0);
						}
					}
				}, 500);
			}
		}
	);
}