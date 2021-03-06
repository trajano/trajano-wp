<?php
/**
 * Template file used to render a Category Archive Index page
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$category_description = category_description();
?>
<?php get_header(); ?>
<div class="container">
	<!-- container start -->
	<div id="content">
		<div class="row">
			<?php shprinkone_get_sidebar('left'); ?>
			<div class="<?php echo shprinkone_get_contentspan(); ?>">
				<div class="page-header">
					<h1 class="page-title">
						<?php echo __('Category', 'shprinkone') . ': ' . single_cat_title('', false); ?>
					</h1>
				</div>
				<?php if (!empty($category_description)): ?>
				<p>
					<?php echo $category_description; ?>
				</p>
				<?php endif; ?>
				<?php get_template_part('loop'); ?>
			</div>
			<?php shprinkone_get_sidebar('right'); ?>
		</div>
	</div>
</div>
<!-- container end -->
<?php get_footer(); ?>