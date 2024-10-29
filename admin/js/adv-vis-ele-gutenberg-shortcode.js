(function (blocks, element, components) {
	var el = element.createElement;
	var SelectControl = components.SelectControl;

	blocks.registerBlockType('adv-vis-ele/gutenberg-shortcode', {
		title: 'AVE Shortcode',
		attributes: {
			shortcode: {
				type: 'string',
				default: aveVars.shortcodes[0].value
			}
		},
		edit: function (props) {
			return el(SelectControl, {
				label: 'Select an Advanced Visual Elements shortcode',
				value: props.attributes.shortcode,
				options: aveVars.shortcodes,
				onChange: function (value) {
					props.setAttributes({shortcode: value});
				},
			});
		},
		save: function (props) {
			console.log(props.attributes.shortcode);
			if (props.attributes.shortcode !== '') {
				return el('div', {}, '[ave-element id="' + props.attributes.shortcode + '"]');
			} else {
				return el('div', {}, '[ave-element]');
			}
		},
	});
})(window.wp.blocks, window.wp.element, window.wp.components);