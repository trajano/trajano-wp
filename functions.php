<?php
/**
 * This file basically acts like a plugin, and if it is present in the theme you are using,
 * it is automatically loaded during WordPress initialization (both for admin pages and external pages).
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */

/**
 * Register widget location within the template
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_widgets_init() {
	register_sidebar(array(
	'name' => __('Sidebar Widget Top', 'shprinkone'),
	'id' => 'sidebar-widget-top',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>\n",
	'description' => __('Sidebar Widget Top', 'shprinkone'),
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
	));
	register_sidebar(array(
	'name' => __('Sidebar Widget Middle', 'shprinkone'),
	'id' => 'sidebar-widget-middle',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>\n",
	'description' => __('Sidebar Widget Middle', 'shprinkone'),
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
	));
	register_sidebar(array(
	'name' => __('Sidebar Widget Bottom', 'shprinkone'),
	'id' => 'sidebar-widget-bottom',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>\n",
	'description' => __('Sidebar Widget Bottom', 'shprinkone'),
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
	));
	register_sidebar(array(
	'name' => __('Footer Widget Left', 'shprinkone'),
	'id' => 'footer-widget-left',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>\n",
	'description' => __('Footer Widget Left', 'shprinkone'),
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
	));
	register_sidebar(array(
	'name' => __('Footer Widget Middle Left', 'shprinkone'),
	'id' => 'footer-widget-middle-left',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>\n",
	'description' => __('Footer Widget Middle Left', 'shprinkone'),
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
	));
	register_sidebar(array(
	'name' => __('Footer Widget Middle Right', 'shprinkone'),
	'id' => 'footer-widget-middle-right',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>\n",
	'description' => __('Footer Widget Middle Right', 'shprinkone'),
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
	));
	register_sidebar(array(
	'name' => __('Footer Widget Right', 'shprinkone'),
	'id' => 'footer-widget-right',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>\n",
	'description' => __('Footer Widget Right', 'shprinkone'),
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
	));
	register_sidebar(array(
	'name' => __('Footer Widget Bottom', 'shprinkone'),
	'id' => 'footer-widget-bottom',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>\n",
	'description' => __('Footer Widget Bottom', 'shprinkone'),
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
	));
}

add_action('widgets_init', 'shprinkone_widgets_init');

/**
 * Register menus location within the template
 *
 * @return  void
 * @since   1.0
*/
function shprinkone_menus_init() {
	register_nav_menus(
	array(
	'header-menu-right' => __('Header Menu Right', 'shprinkone'),
	'sidebar-menu-top' => __('Sidebar Menu Top', 'shprinkone'),
	'sidebar-menu-middle' => __('Sidebar Menu Middle', 'shprinkone'),
	'sidebar-menu-bottom' => __('Sidebar Menu Bottom', 'shprinkone')
	)
	);
}

add_action('init', 'shprinkone_menus_init');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return  void
 * @since   1.0
*/
function shprinkone_setup() {

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support('post-formats', array('aside', 'gallery', 'image', 'quote', 'status', 'video'));

	// This theme uses post thumbnails
	add_theme_support('post-thumbnails');

	// Add default posts and comments RSS feed links to head
	add_theme_support('automatic-feed-links');

	// Image size
	add_image_size('post-image-mansory', 268, 268, true);
	add_image_size('post-image-width9', 860, 200, true);
	add_image_size('post-image-width12', 1170, 200, true);

	// Translation
	load_theme_textdomain('shprinkone', get_template_directory() . '/lang');

	// https://gist.github.com/1597994
	class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {

		function start_lvl(&$output, $depth) {

			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
		}

		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

			$indent = ( $depth ) ? str_repeat("\t", $depth) : '';

			$li_attributes = '';
			$class_names = $value = '';

			$classes = empty($item->classes) ? array() : (array) $item->classes;
			$classes[] = ($args->has_children) ? 'dropdown' : '';
			$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
			$classes[] = 'menu-item-' . $item->ID;


			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
			$class_names = ' class="' . esc_attr($class_names) . '"';

			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
			$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

			$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
			$attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
			$attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
			$attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
			$attributes .= ($args->has_children) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
			$item_output .= ($args->has_children) ? ' <b class="caret"></b></a>' : '</a>';
			$item_output .= $args->after;

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}

		function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {

			if (!$element)
				return;

			$id_field = $this->db_fields['id'];

			//display this element
			if (is_array($args[0]))
				$args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
			else if (is_object($args[0]))
				$args[0]->has_children = !empty($children_elements[$element->$id_field]);
			$cb_args = array_merge(array(&$output, $element, $depth), $args);
			call_user_func_array(array(&$this, 'start_el'), $cb_args);

			$id = $element->$id_field;

			// descend only when the depth is right and there are childrens for this element
			if (($max_depth == 0 || $max_depth > $depth + 1 ) && isset($children_elements[$id])) {

				foreach ($children_elements[$id] as $child) {

					if (!isset($newlevel)) {
						$newlevel = true;
						//start the child delimiter
						$cb_args = array_merge(array(&$output, $depth), $args);
						call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
					}
					$this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
				}
				unset($children_elements[$id]);
			}

			if (isset($newlevel) && $newlevel) {
				//end the child delimiter
				$cb_args = array_merge(array(&$output, $depth), $args);
				call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
			}

			//end this element
			$cb_args = array_merge(array(&$output, $element, $depth), $args);
			call_user_func_array(array(&$this, 'end_el'), $cb_args);
		}

	}

	class ShprinkOne_Walker_Comment extends Walker_Comment {

		/**
		 * @see Walker::start_lvl()
		 * @since 2.7.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of comment.
		 * @param array $args Uses 'style' argument for type of HTML list.
		 */
		function start_lvl(&$output, $depth = 0, $args = array()) {
			$GLOBALS['comment_depth'] = $depth + 1;
		}

		/**
		 * @see Walker::end_lvl()
		 * @since 2.7.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of comment.
		 * @param array $args Will only append content if style argument value is 'ol' or 'ul'.
		 */
		function end_lvl(&$output, $depth = 0, $args = array()) {
			$GLOBALS['comment_depth'] = $depth + 1;
		}

		/**
		 * @see Walker::start_el()
		 * @since 2.7.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $comment Comment data object.
		 * @param int $depth Depth of comment in reference to parents.
		 * @param array $args
		 */
		function start_el(&$output, $comment, $depth, $args, $id = 0) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;

			extract($args, EXTR_SKIP);
			?>
<div class="media <?php echo join(' ', get_comment_class()); ?>"
	id="comment-<?php comment_ID(); ?>">
	<a class="pull-left" href="#"> <?php echo get_avatar($comment, 40); ?>
	</a>
	<div class="media-body">
		<h4 class="media-heading">
			<?php printf(__('%s <span class="says">says:</span>', 'shprinkone'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
		</h4>
		<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'shprinkone'); ?>
		</em> <br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
			<a
				href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
				<?php
				/* translators: 1: date, 2: time */
				printf(__('%1$s at %2$s', 'twentyten'), get_comment_date(), get_comment_time());
				?>
			</a>
			<?php edit_comment_link(__('(Edit)', 'twentyten'), ' ');
			?>
		</div>
		<!-- .comment-meta .commentmetadata -->

		<div class="comment-body">
			<?php comment_text(); ?>
		</div>

		<div class="reply">
			<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
		</div>
		<?php
		}

		/**
		 * @see Walker::end_el()
		 * @since 2.7.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $comment
		 * @param int $depth Depth of comment.
		 * @param array $args
		 */
		function end_el(&$output, $comment, $depth = 0, $args = array()) {
			echo "</div></div>\n";
			if ($depth == 0)
				echo "\n";
		}

	}

}

add_action('after_setup_theme', 'shprinkone_setup');

/**
 * Get Calendar for masonry items
 *
 * @return  void
 * @since   1.0
*/
function shprinkone_get_calendar() {
	$format = '<div class="calendar-outer btn-inverse"><div class="calendar-inner"><div class="calendar-date"><i class="icon-calendar icon-white"></i> %s</div></div></div>';
	$arg = get_the_date(__('M d, Y', 'shprinkone'));
	printf($format, $arg);
}

/**
 * Get the author post link
 *
 * @return  string
 * @since   1.0
 */
function shprinkone_get_the_author_posts_link() {
$format = '<a href="%1$s" title="%2$s" rel="author">%3$s</a>';
$link = sprintf($format, get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nicename')), esc_attr(sprintf(__('Posts by %s'), get_the_author())), get_the_author());

return sprintf(__('By: %s', 'shprinkone'), $link);
}

/**
 * Get the comment number
 *
 * @return  string
 * @since   1.0
 */
function shprinkone_get_comments_number() {
	$number = get_comments_number();
	if ($number > 1) {
		return sprintf(__('%d Comments', 'shprinkone'), $number);
	} else {
		return sprintf(__('%d Comment', 'shprinkone'), $number);
	}
}

/**
 * Get post meta(date, categories, tags etc.)
 *
 * @return  string
 * @since   1.0
 */
function shprinkone_get_post_meta($inline = false, $white = false, $author = true, $date = false) {
	$iconClass = ($white) ? 'icon-white' : '';
	$postClass = ($white) ? 'post-meta-white' : '';
	$inline = ($inline) ? "inline" : "unstyled";
	$html = '<div class = "post-meta ' . $postClass . '">';
	$html .= '<ul class = "' . $inline . '">';
	if ($date) {
		$html .= '<li class = "post-date"><i class = "icon-calendar ' . $iconClass . '"></i> ' . get_the_date(__('M d, Y', 'shprinkone')) . '</li>';
	}
	if ($author) {
		$html .= '<li class = "post-author"><i class = "icon-user ' . $iconClass . '"></i> ' . shprinkone_get_the_author_posts_link() . '</li>';
	}
	if (has_category()):
	$html .= '<li class="post-category"><i class="icon-folder-open ' . $iconClass . '"></i> ' . sprintf(__('Category: %s', 'shprinkone'), get_the_category_list(' ', '', false)) . '</li>';
	endif;
	if (has_tag()):
	$html .= '<li class="post-tags"><i class="icon-tags ' . $iconClass . '"></i> ' . get_the_tag_list(__('Tag: ', 'shprinkone'), ' ') . '</li>';
	endif;
	$html .= '</ul>';
	$html .= '</div>';
	return $html;
}

/**
 * Get menu title
 *
 * @return  string
 * @since   1.0
 */
function shprinkone_get_menu_title($theme_location) {

	$locations = (array) get_nav_menu_locations();

	$menu = wp_get_nav_menu_object($locations[$theme_location]);

	return $menu->slug;
}

/**
 * Display sidebar
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_get_sidebar($side) {
	$options = shprinkone_get_theme_options();
	$layout = $options['theme_layout'];
	$condition1 = ($side == 'left' && $layout == 'sidebar-content');
	$condition2 = ($side == 'right' && $layout == 'content-sidebar');
	if ($condition1 || $condition2) {
		echo '<div id="sidebar" class="span3"><div class="sidebar-inner">';
		get_sidebar();
		echo '</div></div>';
	}
}

/**
 * Is sidebar active
 *
 * @return  string
 * @since   1.0
 */
function shprinkone_is_sidebar_active(){
	$bool = has_nav_menu('sidebar-menu-top') ||
	is_active_sidebar('sidebar-widget-top') ||
	has_nav_menu('sidebar-menu-middle') ||
	is_active_sidebar('sidebar-widget-middle') ||
	has_nav_menu('sidebar-menu-bottom') ||
	is_active_sidebar('sidebar-widget-bottom');
	return $bool;
}

/**
 * Get the columns width
 *
 * @return  string
 * @since   1.0
 */
function shprinkone_get_contentspan() {
	if(!shprinkone_is_sidebar_active()){
		return 'span12';
	}
	$options = shprinkone_get_theme_options();
	return ($options['theme_layout'] == 'content') ? 'span12' : 'span9';
}

/**
 * Get the image width
 *
 * @return  string
 * @since   1.0
 */
function shprinkone_get_imagespan() {
	if(!shprinkone_is_sidebar_active()){
		return 'width12';
	}
	$options = shprinkone_get_theme_options();
	return ($options['theme_layout'] == 'content') ? 'width12' : 'width9';
}

/**
 * Get the no result string
 *
 * @return  string
 * @since   1.0
 */
function shprinkone_get_no_result() {
	$span = shprinkone_get_contentspan();
	$html = '<section class="no-result ' . $span . '">';
	$html .='<p>' . __('Sorry, no posts matched your criteria.', 'shprinkone') . '</p>';
	$html .='</section>';
	return $html;
}

/**
 * Outputs a complete commenting form for use within a template.
 *
 * @since  1.0
 * @param  array $args Options for strings, fields etc in the form
 * @param  mixed $post_id Post ID to generate the form for, uses the current post if null
 * @return void
 */
function shprinkone_comment_form($args = array(), $post_id = null) {
	global $id;

	if (null === $post_id)
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$req = get_option('require_name_email');
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields = array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		'<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
		'email' => '<p class="comment-form-email"><label for="email">' . __('Email') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		'<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
		'url' => '<p class="comment-form-url"><label for="url">' . __('Website') . '</label>' .
		'<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
	);

	$required_text = sprintf(' ' . __('Required fields are marked %s'), '<span class="required">*</span>');
	$defaults = array(
		'fields' => apply_filters('comment_form_default_fields', $fields),
		'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun') . '</label><textarea id="comment" name="comment" class="input-xxlarge" aria-required="true"></textarea></p>',
		'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>'), get_edit_user_link(), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published.') . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after' => null,
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'title_reply' => __('Leave a Reply', 'shprinkone'),
		'title_reply_to' => __('Leave a Reply to %s', 'shprinkone'),
		'cancel_reply_link' => __('Cancel reply', 'shprinkone'),
		'label_submit' => __('Post Comment', 'shprinkone'),
	);

	$args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));
	?>
		<?php if (comments_open($post_id)) : ?>
		<?php do_action('comment_form_before'); ?>
		<div id="respond">
			<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
			<?php echo $args['must_log_in']; ?>
			<?php do_action('comment_form_must_log_in_after'); ?>
			<?php else : ?>
			<form action="<?php echo site_url('/wp-comments-post.php'); ?>"
				method="post" id="<?php echo esc_attr($args['id_form']); ?>">
				<fieldset>
					<legend id="reply-title">
						<?php comment_form_title($args['title_reply'], $args['title_reply_to']); ?>
						<small><?php cancel_comment_reply_link($args['cancel_reply_link']); ?>
						</small>
					</legend>

					<?php do_action('comment_form_top'); ?>
					<?php if (is_user_logged_in()) : ?>
					<?php echo apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity); ?>
					<?php do_action('comment_form_logged_in_after', $commenter, $user_identity); ?>
					<?php else : ?>
					<?php echo $args['comment_notes_before']; ?>
					<?php
					do_action('comment_form_before_fields');
					foreach ((array) $args['fields'] as $name => $field) {
			echo apply_filters("comment_form_field_{$name}", $field) . "\n";
		}
		do_action('comment_form_after_fields');
		?>
					<?php endif; ?>
					<?php echo apply_filters('comment_form_field_comment', $args['comment_field']); ?>
					<?php echo $args['comment_notes_after']; ?>
					<p class="form-submit">
						<button class="btn" name="submit" type="submit"
							id="<?php echo esc_attr($args['id_submit']); ?>">
							<?php echo esc_attr($args['label_submit']); ?>
						</button>
						<?php comment_id_fields($post_id); ?>
					</p>
					<?php do_action('comment_form', $post_id); ?>
				</fieldset>
			</form>
			<?php endif; ?>
		</div>
		<!-- #respond -->
		<?php do_action('comment_form_after'); ?>
		<?php else : ?>
		<?php do_action('comment_form_comments_closed'); ?>
		<?php endif; ?>
		<?php
}

/**
 * ADMINISTRATION
 */

/**
 * Register widget location within the template
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_theme_options_init() {
	register_setting(
	'shprinkone_options', // Options group, see settings_fields() call in twentyeleven_theme_options_render_page()
	'shprinkone_theme_options', // Database option, see twentyeleven_get_theme_options()
	'shprinkone_theme_options_validate' // The sanitization callback, see twentyeleven_theme_options_validate()
	);
	// Register our settings field group
	add_settings_section(
	'general', // Unique identifier for the settings section
	'', // Section title (we don't want one)
	'__return_false', // Section callback (we don't want anything)
	'theme_options' // Menu slug, used to uniquely identify the page; see twentyeleven_theme_options_add_page()
	);

	add_settings_field('layout', __('Default Layout', 'shprinkone'), 'shprinkone_settings_field_layout', 'theme_options', 'general');
}

add_action('admin_init', 'shprinkone_theme_options_init');

/**
 * Add theme admin page
 *
 * @return  void
 * @since   1.0
*/
function shprinkone_add_theme_page() {
	$theme_page = add_theme_page(
			__('Theme Options', 'shprinkone'), // Name of page
			__('Theme Options', 'shprinkone'), // Label in menu
			'edit_theme_options', // Capability required
			'theme_options', // Menu slug, used to uniquely identify the page
			'shprinkone_theme_options_render' // Function that renders the options page
	);

	if (!$theme_page)
		return;
}

add_action('admin_menu', 'shprinkone_add_theme_page');

/**
 * Render options
 *
 * @return  void
 * @since   1.0
*/
function shprinkone_theme_options_render() {
	$theme_name = function_exists('wp_get_theme') ? wp_get_theme() : get_current_theme();
	echo '<div class="wrap">';
	screen_icon();
	echo '<h2>' . sprintf(__('%s Theme Options', 'shprinkone'), $theme_name) . '</h2>';
	settings_errors();
	echo '<form method="post" action="options.php">';
	settings_fields('shprinkone_options');
	do_settings_sections('theme_options');
	submit_button();
	echo'</form></div>';
}
/**
 * Set field layout
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_settings_field_layout() {
	$options = shprinkone_get_theme_options();
	foreach (shprinkone_layouts() as $layout) {
		$checked = ($options['theme_layout'] == $layout['value']) ? 'checked="checked"' : '';
		$html = '<div class="layout image-radio-option theme-layout">';
		$html .= '<label class="description"> <input type="radio" name="shprinkone_theme_options[theme_layout]"';
		$html .= 'value="' . esc_attr($layout['value']) . '" ' . $checked . ' /> <span>';
		$html .= '<img src="' . esc_url($layout['thumbnail']) . '" width="136" height="122" alt="" />';
		$html .= $layout['label'];
		$html .= '</span></label></div>';
		echo $html;
	}
}

/**
 * Get theme options
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_get_theme_options() {
	return get_option('shprinkone_theme_options', shprinkone_get_default_theme_options());
}

/**
 * Get default theme options
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_get_default_theme_options() {
	$default_theme_options = array(
		'theme_layout' => 'content-sidebar',
	);

	if (is_rtl())
		$default_theme_options['theme_layout'] = 'sidebar-content';

	return apply_filters('shprinkone_default_theme_options', $default_theme_options);
}

/**
 * Set Layouts
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __('Content on left', 'shprinkone'),
			'thumbnail' => get_template_directory_uri() . '/img/content-sidebar.png',
		),
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __('Content on right', 'shprinkone'),
			'thumbnail' => get_template_directory_uri() . '/img/sidebar-content.png',
		),
		'content' => array(
			'value' => 'content',
			'label' => __('One-column, no sidebar', 'shprinkone'),
			'thumbnail' => get_template_directory_uri() . '/img/content.png',
		),
	);

	return apply_filters('shprinkone_layouts', $layout_options);
}

/**
 * Validate theme options
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_theme_options_validate($input) {
	$output = $defaults = shprinkone_get_default_theme_options();

	// Theme layout must be in our array of theme layout options
	if (isset($input['theme_layout']) && array_key_exists($input['theme_layout'], shprinkone_layouts()))
		$output['theme_layout'] = $input['theme_layout'];

	return apply_filters('shprinkone_theme_options_validate', $output, $input, $defaults);
}

