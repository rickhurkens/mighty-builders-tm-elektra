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
    $patterns_to_overwrite = [
        'footer-default' => ['Footer Default', 'footer'],
        'header-default' => ['Header Default', 'header'],
    ];

    foreach ($patterns_to_overwrite as $pattern_slug => $values) {
        list($pattern_title, $category) = $values;

        // Unregister the parent theme's pattern
        unregister_block_pattern('mighty-builders/' . $pattern_slug);

        // Register your child theme's pattern
        register_block_pattern(
            'mighty-builders/' . $pattern_slug,
            array(
                'title' => __($pattern_title, 'mighty-builders-tm-elektra'),
                'description' => __('The default ' . $pattern_title . ' pattern, customized by the child theme.'),
                'categories' => array('mighty-builders', $category),
                'content' => remove_php_from_file(get_stylesheet_directory() . '/patterns/' . $pattern_slug . '.php'),
            )
        );
    }
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

// // TODO: prevent unnecessary templates from being loaded.
// // This doesn't work.
// add_action('wp_loaded', function () {
//     global $wp_block_templates;
//     error_log(print_r($wp_block_templates, true));
//     error_log('happening234');

//     $templates_to_unregister = [
//         '404',
//         'archive-product',
//         'archive',
//         'blank',
//         'cart',
//         'checkout',
//         'front-page',
//         'fullwidth-page-template',
//         'home',
//         'index',
//         'page-leftsidebar-template',
//         'page-sitemap-template',
//         'page',
//         'search',
//         'single-fullwith-template',
//         'single-leftsidebar-template',
//         'single-product',
//         'single',
//     ];

//     foreach ($templates_to_unregister as $template) {
//         unregister_block_template('mighty-builders//' . $template);
//     }
// }, 90);
?>