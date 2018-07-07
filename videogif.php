<?php
/*
  Plugin Name: VideoGIF
  Description: Adds a shortcode for encoding GIFV or mp4 GIF content.
  Version: 0.1
  Author: Nikita Rushmanov
 */
add_shortcode('videogif', 'videogif');
function videogif($attr = [], $content = null)
{
    // normalize attribute keys, lowercase
    $attr = array_change_key_case((array)$attr, CASE_LOWER);

    // New-style shortcode with the caption inside the shortcode with the link and image tags.
    if(isset($content)) {
        $attr['caption'] = $content;
    }

    // override default attributes with user attributes
    $attr = shortcode_atts([
            'caption' => $attr['caption'],
            'mp4' => $attr['mp4'],
            'style' => null,
            'controls' => false
        ], $attr);

    // build output
    $o = '';
    $o .= '<figure class="wp-caption alignnone">';
    $o .= '<a class="image-popup" href="' . $attr['mp4'] . '">';
    $o .= '<video autoplay loop muted ';
    if ($attr['controls']) $o .= 'controls ';
    $o .= 'class="videogif"';
    if (!is_null($attr['style'])) $o .= 'style="' . $attr['style'] . '" ';
    $o .= '><source src="' . $attr['mp4'] . '" type="video/mp4" /></video>';
    $o .= '</a>';
    $o .= '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption></figure>';

    // return output
    return $o;
}

add_action('wp_enqueue_scripts', 'videogif_init');
function videogif_init() {
    wp_register_style('videogif', plugins_url('videogif/videogif.css'));
    wp_enqueue_style('videogif');
}
