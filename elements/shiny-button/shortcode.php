<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$padding = '15px 30px';

if ($settings['button-size'] === 'small') {
	$padding = '7px 15px';
} else if ($settings['button-size'] === 'medium') {
	$padding = '15px 30px';
} else if ($settings['button-size'] === 'big') {
	$padding = '30px 60px';
} else if ($settings['button-size'] === 'huge') {
	$padding = '50px 100px';
}

?>

<style>
	.adv-vis-ele-adv-vis-ele-shiny-button-link {
		user-select: none;
		display: inline-block;
		border: 0.2em solid <?php echo $settings['primary-color']; ?>;
		position: relative;
		cursor: pointer;
		overflow: hidden;
		color: <?php echo $settings['primary-color']; ?>;
		font-size: <?php echo $settings['text-size']; ?>px;
		white-space: nowrap;
		letter-spacing: <?php echo $settings['letter-spacing']; ?>px;
	}
	.adv-vis-ele-adv-vis-ele-shiny-button-text {
		display: block;
		padding: <?php echo $padding; ?>;
		font-weight: bold;
	}
	.adv-vis-ele-adv-vis-ele-shiny-button-text2 {
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		transform: translateX(-1em);
		opacity: 0;
		color: <?php echo $settings['secondary-color']; ?>;
	}
	.adv-vis-ele-adv-vis-ele-shiny-button-mask {
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: <?php echo $settings['shine-color']; ?>;
		transform: translateX(-101%) rotate(45deg);
		transition: all 0.3s;
		width: 110%;
		transform-origin: center;
	}
	.adv-vis-ele-adv-vis-ele-shiny-button-link:hover,
	.adv-vis-ele-adv-vis-ele-shiny-button-link:active,
	.adv-vis-ele-adv-vis-ele-shiny-button-link:focus {
		opacity: 1;
		border-color: <?php echo $settings['secondary-color']; ?>;
		color: <?php echo $settings['secondary-color']; ?>;
	}
	.adv-vis-ele-adv-vis-ele-shiny-button-link:hover .adv-vis-ele-adv-vis-ele-shiny-button-text {
		animation: adv-vis-ele-adv-vis-ele-shiny-button-fx-text 0.3s ease-out;
	}
	.adv-vis-ele-adv-vis-ele-shiny-button-link:hover .adv-vis-ele-adv-vis-ele-shiny-button-text2 {
		animation: adv-vis-ele-adv-vis-ele-shiny-button-fx-text2 0.3s ease-out;
	}
	.adv-vis-ele-adv-vis-ele-shiny-button-link:hover .adv-vis-ele-adv-vis-ele-shiny-button-mask {
		animation: adv-vis-ele-adv-vis-ele-shiny-button-fx-mask 0.3s ease-out;
	}
	@keyframes adv-vis-ele-adv-vis-ele-shiny-button-fx-mask {
		0% {
			transform: translateX(-100%) rotate(45deg);
		}
		100% {
			transform: translateX(100%) rotate(45deg);
		}
	}
	@keyframes adv-vis-ele-adv-vis-ele-shiny-button-fx-text {
		0% {
			transform: translateX(0);
			opacity: 1;
		}
		100% {
			transform: translateX(1em);
			opacity: 0;
		}
	}
	@keyframes adv-vis-ele-adv-vis-ele-shiny-button-fx-text2 {
		0% {
			transform: translateX(-1em);
			opacity: 0;
		}
		100% {
			transform: translateX(0);
			opacity: 1;
		}
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		.adv-vis-ele-adv-vis-ele-shiny-button-link {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
	}
</style>

<div id="ave-shiny-button-<?php echo $post_id; ?>" class="adv-vis-ele-shiny-button">
	<a<?php echo $settings['open-in-new-tab'] ? ' target="_blank"' : ''; ?> href="<?php echo $settings['button-link']; ?>" class="adv-vis-ele-adv-vis-ele-shiny-button-link">
		<span class="adv-vis-ele-adv-vis-ele-shiny-button-mask"></span>
		<span class="adv-vis-ele-adv-vis-ele-shiny-button-text"><?php echo $settings['button-text']; ?></span>
		<span class="adv-vis-ele-adv-vis-ele-shiny-button-text adv-vis-ele-adv-vis-ele-shiny-button-text2"><?php echo $settings['button-text']; ?></span>
	</a>
</div>