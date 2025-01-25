<?php
// Enqueue parent and child theme styles
function child_theme_enqueue_styles()
{
    // Load parent theme styles
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Load child theme styles
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
add_action('wp_enqueue_scripts', 'child_theme_enqueue_styles');

add_action('after_setup_theme', function () {
    // Unregister the parent theme's footer-default pattern
    unregister_block_pattern('mighty-builders/footer-default');

    // Register your child theme's footer-default pattern
    register_block_pattern(
        'mighty-builders/footer-default',
        array(
            'title' => __('Footer Default', 'your-child-theme-textdomain'),
            'description' => __('The default footer pattern, customized by the child theme.'),
            'categories' => array('mighty-builders', 'footer'),
            'content' => file_get_contents(get_stylesheet_directory() . '/patterns/footer-default.php'),
        )
    );
});

// TODO: prevent unnecessary templates from being loaded.
?>