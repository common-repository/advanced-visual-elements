var adv_vis_ele_copy_to_clipboard_t = Array.from(document.getElementsByClassName('adv-vis-ele-copy-to-clipboard-t'));

adv_vis_ele_copy_to_clipboard_t.forEach(box => {
	box.addEventListener('click', function handleClick(event) {
		var toCopy = '';

		if (event.target.tagName.toLowerCase() === 'div') {
			toCopy = event.target.textContent.trim();
		} else if (event.target.tagName.toLowerCase() === 'input') {
			toCopy = event.target.value;
		}

		adv_vis_ele_copy_to_clipboard(toCopy);

		if (event.target.tagName.toLowerCase() === 'input') {
			event.target.focus()
		}
	});
});

function adv_vis_ele_copy_to_clipboard(value) {
	var tempInput = document.createElement("input");
	tempInput.value = value;
	document.body.appendChild(tempInput);
	tempInput.select();
	document.execCommand("copy");
	document.body.removeChild(tempInput);
}