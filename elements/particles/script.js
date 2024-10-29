"use strict";
(function ($) {
	$(window).on('load', (function () {
		let bg_particle_containers = $('.adv-vis-ele-bg-particles');

		if (bg_particle_containers.length < 1) {
			return;
		}

		bg_particle_containers.each(function (index) {
			var post_id = $(this).closest('.adv-vis-ele-shortcode-render-container').attr('data-post-id');

			if (ave_element_settings[post_id].particle_image == '') {
				ave_element_settings[post_id].particle_image = ave_element_settings[post_id].element_path + '/default.png';
			}

			if (ave_element_settings[post_id].particle_shape == 'star') {
				ave_element_settings[post_id].particle_polygon_sides = 5;
			}

			var particles_config = {
				"particles": {
					"number": {
						"value": ave_element_settings[post_id].number_value,
						"density": {
							"enable": true,
							"value_area": 800
						}
					},
					"color": {
						"value": ave_element_settings[post_id].particle_color
					},
					"shape": {
						"type": ave_element_settings[post_id].particle_shape,
						"stroke": {
							"width": ave_element_settings[post_id].stroke_particle_width,
							"color": ave_element_settings[post_id].stroke_particle_color
						},
						"polygon": {
							"nb_sides": ave_element_settings[post_id].particle_polygon_sides
						},
						"image": {
							"src": ave_element_settings[post_id].particle_image,
							"width": ave_element_settings[post_id].particle_image_width,
							"height": ave_element_settings[post_id].particle_image_height
						}
					},
					"opacity": {
						"value": ave_element_settings[post_id].particle_opacity,
						"random": ave_element_settings[post_id].opacity_random,
						"anim": {
							"enable": ave_element_settings[post_id].animate_particle_opacity,
							"speed": ave_element_settings[post_id].animate_opacity_speed,
							"opacity_min": ave_element_settings[post_id].opacity_animation_min_opacity,
							"sync": ave_element_settings[post_id].sync_opacity_animation
						}
					},
					"size": {
						"value": ave_element_settings[post_id].particle_max_size,
						"random": ave_element_settings[post_id].random_particle_size,
						"anim": {
							"enable": ave_element_settings[post_id].animate_particle_size,
							"speed": ave_element_settings[post_id].animate_size_speed,
							"size_min": ave_element_settings[post_id].size_animation_min_size,
							"sync": ave_element_settings[post_id].sync_size_animation
						}
					},
					"line_linked": {
						"enable": ave_element_settings[post_id].line_linked,
						"distance": ave_element_settings[post_id].linking_distance,
						"color": ave_element_settings[post_id].line_color,
						"opacity": ave_element_settings[post_id].line_opacity,
						"width": ave_element_settings[post_id].line_width,
					},
					"move": {
						"enable": true,
						"speed": ave_element_settings[post_id].move_speed,
						"direction": "none",
						"random": ave_element_settings[post_id].randomize_move_speed,
						"straight": false,
						"out_mode": "out",
						"bounce": ave_element_settings[post_id].bounce_particles,
						"attract": {
							"enable": false,
							"rotateX": 600,
							"rotateY": 1200
						}
					}
				},
				"interactivity": {
					"detect_on": "canvas",
					"events": {
						"onhover": {
							"enable": false,
							"mode": "repulse"
						},
						"onclick": {
							"enable": ave_element_settings[post_id].enable_interactive_mouse,
							"mode": ave_element_settings[post_id].interactive_mouse_mode
						},
						"resize": true
					},
					"modes": {
						"grab": {
							"distance": 400,
							"line_linked": {
								"opacity": 1
							}
						},
						"bubble": {
							"distance": 100,
							"size": 15,
							"duration": 0.3,
							"opacity": 1,
							"speed": 4
						},
						"repulse": {
							"distance": 100,
							"duration": 0.3
						},
						"push": {
							"particles_nb": 1
						},
						"remove": {
							"particles_nb": 1
						}
					}
				},
				"retina_detect": true
			};

			let generated_index = $(this).attr('id') + '-' + index;

			$(this).attr('id', generated_index);

			/* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
			var particles_container = document.getElementById(generated_index);

			if (typeof(particles_container) != 'undefined' && particles_container != null) {
				particlesJS(generated_index, particles_config);
			}
		});
	}));
})(jQuery);