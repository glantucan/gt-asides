<?php


/**
 * [aside ...] shortcut parser
 *
 * @param [array] $atts
 * @param [string] $content
 * @return void
 */
function gt_asides_aside_shortcode_renderer( $atts, $content = null ) {
    global $GT_ASIDES_CONF_DEFAULTS;
    // IMPORTANT TIP - Don't use camelCase or UPPER-CASE for $atts attribute names $atts values are lower-cased during shortcode_atts( array( 'attr_1' => 'attr_1 default', // ...etc ), $atts )processing, so you might want to just use lower-case.
    
    // Preprocess and sanitize attributes
    $attributes = shortcode_atts( array(
        'c' => 'true',      /* Collapse the aside on load? */
        'l' => '',          /* Another post slug. Load that post as an aside ($content ignore)*/
        't' => 'more',      /* See GT_ASIDES_CLASSES keys */
        's' => 'true',      /* Save as aside post */
    ), $atts);
    
    $rendered = aside_shortcode_renderer( $attributes, $content, 
                                          $GT_ASIDES_CONF_DEFAULTS['css_classes'], 
                                          $GT_ASIDES_CONF_DEFAULTS['markdown_parser'] );

    // Workaround some wp texturing issues
    // for some reason it's still scaping quotes which screws up just en the class attribute
    $rendered = preg_replace('/\<code class=[^"]"(.*?)[^"]"\>/s', '<code class="language-$1">', $rendered);
    // FIXME: These are not good, there may be situations where I do want a \' or \" inside a string, for instance
    $rendered = str_replace("\'", "'", $rendered);
    $rendered = str_replace('\"', '"', $rendered); 

    return $rendered;
}

/**
 * Wordpress independet asides renderer
 *
 * @param [type] $atts
 * @param [type] $content
 * @param [type] $aside_classes
 * @param [type] $md_parser
 * @return void
 */
function aside_shortcode_renderer($attributes, $content = null, $aside_classes, $md_parser) {

    // Decide if we load another post as the aside content
    if (!empty( $attributes['l'] )) {
        // TODO: load the aside post
    }
    elseif (!empty($content)) {
        $aside_content = $content;
    }

    // Generate wrapper div classes based on the attributes values
    $wrapper_classes = $aside_classes['base']['class'] . ' ' . 
                       $aside_classes['types'][$attributes['t']]['class'];

    // COllapse by default?
    if (!isset($attributes['c']) || $attributes['c']=='true') {
        $wrapper_classes .= ' ' . $aside_classes['collapsed']['class']; 
    }
    
    // Get the aside button label text
    $aside_label = '';
    if ( !empty($attributes['t'] )) {
        $aside_class_label = $aside_classes['types'][$attributes['t']]['label'];
        if ( !empty($aside_class_label) ) {
            $aside_label = $aside_class_label;
        } 
    }
    gt_log($aside_class_label);
    gt_log( empty($aside_label));
    
    if( empty($aside_label) ) {
        $aside_label = $aside_classes['base']['label'];
    }
    gt_log($aside_label);

    $rendered_content  = '<div class="' . $wrapper_classes . '">';
    $rendered_content .= '  <div class="gt-asides-toggle-btn-wrapper">' .
                                '<div class="gt_asides-toggle-btn">' .
                                    '<span class="gt-asides-icon"></span>' .
                                    '<span class="gt-asides-label">' .
                                       $aside_label . 
                                    '</span>' .
                                '</div>' .
                            '</div>';
    $rendered_content .= '  <div class="gt-aside-content">';
    $rendered_content .=        gt_parse_markdown( $aside_content, $md_parser );
    $rendered_content .= '  </div>' .
                         '</div>';

    //gt_log($rendered_content);
    return $rendered_content;
}

/**
 * Calls the actual parser (using its particular interface) to return the parsed content
 *
 * @param [type] $content
 * @param [type] $md_parser
 * @return void
 */
function gt_parse_markdown($content, $md_parser) {
    $parsed_content = $md_parser->transform($content, array('decode_code_blocks' => true) );
    return $parsed_content;
}