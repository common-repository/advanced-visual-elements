<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$data_rotate = [];
for ($i = 1; $i <= 10; $i++) {
	$index = 'changing-text-' . $i;
	if (!empty($settings[$index])) {
		$data_rotate[] = $settings[$index];
	}
}

$data_rotate_string = '[';
foreach ($data_rotate as $word) {
	$data_rotate_string .= '"' . $word . '", ';
}
$data_rotate_string = rtrim($data_rotate_string, ', ');
$data_rotate_string .= ']';

$border_width = ceil((float)$settings['text-size'] / 16);
$border_width_mobile = ceil((float)$settings['text-size-mobile'] / 14);

?>

<style>
	#ave-auto-typing-text-<?php echo $post_id; ?> .adv-vis-ele-auto-typing-text-inner {
		color: <?php echo $settings['static-text-color']; ?>;
		font-size: <?php echo $settings['text-size']; ?>px;
	}
	#ave-auto-typing-text-<?php echo $post_id; ?> .adv-vis-ele-auto-typing-text-rotate {
		color: <?php echo $settings['dynamic-text-color']; ?>;
		<?php echo $settings['use-caret'] ? 'border-right: ' . $border_width . 'px solid #000; padding-right: 3px;' : ''; ?>
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-auto-typing-text-<?php echo $post_id; ?> .adv-vis-ele-auto-typing-text-inner {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
		#ave-auto-typing-text-<?php echo $post_id; ?> .adv-vis-ele-auto-typing-text-rotate {
			<?php echo $settings['use-caret'] ? 'border-right: ' . $border_width_mobile . 'px solid #000;' : ''; ?>
		}
	}
</style>

<div id="ave-auto-typing-text-<?php echo $post_id; ?>" class="adv-vis-ele-auto-typing-text">
	<div class="adv-vis-ele-auto-typing-text-c">
		<div class="adv-vis-ele-auto-typing-text-inner">
			<?php echo $settings['static-text']; ?>
			<span class="adv-vis-ele-auto-typing-text-rotate"
			      data-period="<?php echo $settings['period']; ?>"
			      data-rotate='<?php echo $data_rotate_string; ?>'
			      data-caret="<?php echo $settings['use-caret']; ?>"></span>
		</div>
	</div>
</div>