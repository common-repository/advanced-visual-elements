<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$library_limit = 8;
$library_page = 1;

$library = new Adv_Vis_Ele_Library();

$elements_array = $library->get_library_info($library_limit, $library_page);

$ordering = get_user_meta(get_current_user_id(), 'adv_vis_ele_library_ordering', true);

if (empty($ordering)) {
	$ordering = 'asc';
}

?>
<div class="adv-vis-ele-admin adv-vis-ele-admin-library">
	<h3><?php _e('Elements Library', 'adv-vis-ele'); ?></h3>
	<div class="adv-vis-ele-library-container">
		<div class="adv-vis-ele-notifications"></div>

		<div class="adv-vis-ele-library-top-controls">
			<div class="adv-vis-ele-library-ordering">
				<select name="adv-vis-ele-library-ordering" id="adv-vis-ele-library-ordering">
					<option value="asc"<?php selected($ordering, 'asc'); ?>>Ascending</option>
					<option value="desc"<?php selected($ordering, 'desc'); ?>>Descending</option>
				</select>
			</div>

			<form class="adv-vis-ele-library-search-form" action="" method="post">
				<div class="adv-vis-ele-library-search">
					<input type="text" placeholder="<?php _e('Search elements', 'adv-vis-ele'); ?>">
					<button type="submit" class="adv-vis-ele-btn"><?php _e('Go', 'adv-vis-ele'); ?></button>
				</div>
			</form>

			<div class="adv-vis-ele-library-full-import">
				<button class="adv-vis-ele-btn"><?php _e('Import settings', 'adv-vis-ele'); ?></button>
			</div>
		</div>

		<div class="adv-vis-ele-library-top-new-elements">
			<?php
			
			if (!empty(ADV_VIS_ELE_NEW_ELEMENTS)) {
				$c = count(ADV_VIS_ELE_NEW_ELEMENTS);
				
				echo $c > 1 ? __('There are <b>' . $c . '</b> new Elements ') : __('There is <b>1</b> new Element ');
				
				$html = '';
				
				foreach (ADV_VIS_ELE_NEW_ELEMENTS as $new_element) {
					$new = $library->get_element($new_element);
					
					if ($new !== false) {
						$html .= '<a href="#">' . $new->name . '</a>, ';
					}
				}
				
				$html = rtrim($html, ', ');
				
				echo wp_kses_post($html);
			}
			
			?>
		</div>

		<div class="adv-vis-ele-library-top-categories">
			<a href="#" data-category="button" class="adv-vis-ele-btn">Buttons</a>
			<a href="#" data-category="text" class="adv-vis-ele-btn">Text</a>
			<a href="#" data-category="image" class="adv-vis-ele-btn">Image</a>
			<a href="#" data-category="animated" class="adv-vis-ele-btn">Animated</a>
			<a href="#" data-category="card" class="adv-vis-ele-btn">Cards</a>
		</div>

		<div class="adv-vis-ele-library" data-limit="<?php echo $library_limit; ?>" data-page="<?php echo $library_page + 1; ?>">
			<?php
			
			if (!empty($elements_array)) {
				foreach ($elements_array as $element) {
					$element->new_element = in_array($element->id, ADV_VIS_ELE_NEW_ELEMENTS);
					
					echo $library->get_element_html($element); ?>
				<?php }
			} else { ?>
				<h5 class="adv-vis-ele-error">
					<i class="fas fa-exclamation-triangle"></i><?php _e('Error [code: 001].', 'adv-vis-ele'); ?>
				</h5>
			<?php } ?>
		</div>
		<?php
		if (count($library->get_library_info()) > $library_limit) { ?>
			<div class="adv-vis-ele-library-load-more">
				<button class="adv-vis-ele-btn"><?php _e('Load more', 'adv-vis-ele'); ?></button>
			</div>
		<?php } ?>
	</div>
	<?php
	if (isset($library)) {
		echo '<div class="adv-vis-ele-total-elements">';
		_e('Total library elements ', 'adv-vis-ele');
		echo '<b>';
		echo count($library->get_library_info());
		echo '</b>';
		echo ' (plugin ver. ' . wp_kses_post(ADV_VIS_ELE_VERSION) . ')';
		echo '<span class="adv-vis-ele-abbr" data-title="' . __("That's not all! We're frequently updating the library and adding more Elements.", 'adv-vis-ele') . '">?</span>';
		echo '&nbsp;';
		echo '<a href="' . esc_url(add_query_arg(['page' => 'adv-vis-ele', 'adv-vis-ele-library-reset' => 'true']), admin_url()) . '">Reset Library</a>';
		echo '</div>';
	}
	?>
	<?php include('adv-vis-ele-admin-footer.php'); ?>
</div>