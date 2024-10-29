let images = document.getElementsByClassName("adv-vis-ele-image-magnifier");
for (let i = 0; i < images.length; i++) {
	let id = images[i].getAttribute('data-img-id');

	if (document.getElementById(id)) {
		image_magnifier_magnify(id, images[i].getAttribute('data-zoom-level'));
	}
}