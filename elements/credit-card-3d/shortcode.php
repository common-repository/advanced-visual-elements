<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$card_number_groups = str_split($settings['digits'], 4);

?>

<div id="ave-credit-card-3d-<?php echo $post_id; ?>" class="adv-vis-ele-credit-card-3d">
	<div class="adv-vis-ele-credit-card-3d">
		<div class="adv-vis-ele-credit-card-3d-info">
			<div class="adv-vis-ele-credit-card-3d-logo"><?php echo $settings['bank-name']; ?></div>
			<div class="adv-vis-ele-credit-card-3d-chip">
				<svg class="adv-vis-ele-credit-card-3d-chip-lines" role="img" width="20px" height="20px" viewBox="0 0 100 100" aria-label="Chip">
					<g opacity="0.8">
						<polyline points="0,50 35,50" fill="none" stroke="#000" stroke-width="2"/>
						<polyline points="0,20 20,20 35,35" fill="none" stroke="#000" stroke-width="2"/>
						<polyline points="50,0 50,35" fill="none" stroke="#000" stroke-width="2"/>
						<polyline points="65,35 80,20 100,20" fill="none" stroke="#000" stroke-width="2"/>
						<polyline points="100,50 65,50" fill="none" stroke="#000" stroke-width="2"/>
						<polyline points="35,35 65,35 65,65 35,65 35,35" fill="none" stroke="#000" stroke-width="2"/>
						<polyline points="0,80 20,80 35,65" fill="none" stroke="#000" stroke-width="2"/>
						<polyline points="50,100 50,65" fill="none" stroke="#000" stroke-width="2"/>
						<polyline points="65,65 80,80 100,80" fill="none" stroke="#000" stroke-width="2"/>
					</g>
				</svg>
				<div class="adv-vis-ele-credit-card-3d-chip-texture"></div>
			</div>
			<div class="adv-vis-ele-credit-card-3d-type"><?php echo $settings['card-type']; ?></div>
			<div class="adv-vis-ele-credit-card-3d-number">
				<?php
				for ($i = 0; $i < 4; $i++) {
					if (isset($card_number_groups[$i])) {
						echo '<span class="adv-vis-ele-credit-card-3d-digit-group">' . $card_number_groups[$i] . '</span>';
					}
				}
				?>
			</div>
			<div class="adv-vis-ele-credit-card-3d-valid-thru" aria-label="Valid thru"><?php echo $settings['expires-text']; ?></div>
			<div class="adv-vis-ele-credit-card-3d-exp-date">
				<time><?php echo $settings['expires-date']; ?></time>
			</div>
			<div class="adv-vis-ele-credit-card-3d-name" aria-label="Dee Stroyer"><?php echo $settings['cardholder-name']; ?></div>
			<div class="adv-vis-ele-credit-card-3d-vendor" role="img" aria-labelledby="adv-vis-ele-credit-card-3d-vendor">
				<span id="adv-vis-ele-credit-card-3d-vendor" class="adv-vis-ele-credit-card-3d-vendor-sr"></span>
			</div>
		</div>
		<div class="adv-vis-ele-credit-card-3d-texture"></div>
	</div>
</div>