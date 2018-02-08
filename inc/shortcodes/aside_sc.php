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
    
    $collapsed = true;

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

    // COllapse by default
    if (!isset($attributes['c']) || $attributes['c']=='true') {
        $wrapper_classes .= ' ' . $aside_classes['collapsed']['class']; 
    } else {
        $collapsed = false;
    }
    
    // Get the aside button labels text
    $open_label = '';
    if ( !empty($attributes) && !empty($attributes['t'] )) {
        $aside_class_label = $aside_classes['types'][$attributes['t']]['label'];
        if ( !empty($aside_class_label) ) {
            $open_label = $aside_class_label;
        } 
    }
    if( empty($open_label) ) {
        $open_label = $aside_classes['button']['openedLabel'];
    }
    $close_label = $aside_classes['button']['closedLabel'];

    // Render the html
    $rendered_content  = '<div class="' . $wrapper_classes . '">';
    $rendered_content .= '  <div class="' . $aside_classes['button']['class']. '">' .
                                '<div class="gt-deco"></div>' .
                                '<div class="gt-icon"></div>' .
                                '<div class="gt-label gt-collapsed">' .
                                    $open_label . 
                                '</div>' .
                                '<div class="gt-label gt-opened">' .
                                    $close_label . 
                                '</div>' .
                            '</div>';
    $rendered_content .= '  <div class="' .  $aside_classes['content-class'] . '">';
    $rendered_content .=        gt_parse_markdown( $aside_content, $md_parser );
    // insert the toggle button also at the end of th aside content.
    $rendered_content .= '      <div class="' . $aside_classes['button']['class']. '">' .
                                    '<div class="gt-deco"></div>' .
                                    '<div class="gt-icon"></div>' .
                                    '<div class="gt-label gt-collapsed">' .
                                        $open_label . 
                                    '</div>' .
                                    '<div class="gt-label gt-opened">' .
                                        $close_label . 
                                    '</div>' .
                                '</div>';
    $rendered_content .= '  </div>';
    $rendered_content .= '</div>';

    gt_log('$rendered_content');
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