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
            'title' => __('Footer Default', 'mighty-builders-tm-elektra'),
            'description' => __('The default footer pattern, customized by the child theme.'),
            'categories' => array('mighty-builders', 'footer'),
            'content' => remove_php_from_file(get_stylesheet_directory() . '/patterns/footer-default.php'),
        )
    );
});


function remove_php_from_file($file_path)
{
    // Read the content of the file
    $file_content = file_get_contents($file_path);

    // Regular expression to match \<?php ... ?\> blocks, including multiline ones
    $pattern = '/<\?php[\s\S]*?\?>/';

    // Remove PHP blocks from the file content
    $cleaned_content = preg_replace($pattern, '', $file_content);

    return $cleaned_content;
}

// TODO: prevent unnecessary templates from being loaded.
?>