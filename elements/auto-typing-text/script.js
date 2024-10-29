let AdvVisEleTxtRotate = function (el, toRotate, period, caret) {
	this.toRotate = toRotate;
	this.el = el;
	this.loopNum = 0;
	this.period = parseInt(period, 10) || 2000;
	this.caret = caret;
	this.txt = '';
	this.intervalID = false;
	this.tick();
	this.isDeleting = false;
};

AdvVisEleTxtRotate.prototype.tick = function () {
	let i = this.loopNum % this.toRotate.length;
	let fullTxt = this.toRotate[i];

	if (this.isDeleting) {
		this.txt = fullTxt.substring(0, this.txt.length - 1);
	} else {
		this.txt = fullTxt.substring(0, this.txt.length + 1);
	}

	this.el.innerHTML = '<span class="adv-vis-ele-auto-typing-text-wrap">' + this.txt + '</span>';

	let that = this;
	let delta = 200 - Math.random() * 100;

	if (this.isDeleting) {
		delta /= 2;

		clearInterval(that.intervalID);

		that.el.style.borderRightColor = '#000';
	}

	if (!this.isDeleting && this.txt === fullTxt) {
		delta = this.period;
		this.isDeleting = true;

		if (that.caret === '1') {
			that.intervalID = setInterval(function () {
				if (that.el.style.borderRightColor === 'transparent') {
					that.el.style.borderRightColor = '#000';
				} else {
					that.el.style.borderRightColor = 'transparent';
				}
			}, 500);
		}
	} else if (this.isDeleting && this.txt === '') {
		this.isDeleting = false;
		this.loopNum++;
		delta = 500;
	}

	setTimeout(function () {
		that.tick();
	}, delta);
};

window.onload = function () {
	let elements = document.getElementsByClassName('adv-vis-ele-auto-typing-text-rotate');

	for (let i = 0; i < elements.length; i++) {
		let toRotate = elements[i].getAttribute('data-rotate');
		let period = elements[i].getAttribute('data-period');
		let caret = elements[i].getAttribute('data-caret');

		if (toRotate) {
			new AdvVisEleTxtRotate(elements[i], JSON.parse(toRotate), period, caret);
		}
	}
};