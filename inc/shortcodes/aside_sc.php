<?php



/**
 * [aside ...] shortcut parser
 *
 * @param [array] $atts
 * @param [string] $content
 * @return void
 */
function aside_shortcode_parser( $atts, $content = null ) {
    global $gt_asides_markdown;
    // IMPORTANT TIP - Don't use camelCase or UPPER-CASE for $atts attribute names $atts values are lower-cased during shortcode_atts( array( 'attr_1' => 'attr_1 default', // ...etc ), $atts )processing, so you might want to just use lower-case.
    
    // Preprocess and sanitize attributes
    $attributes = shortcode_atts( array(
        'c' => 'true',    /* Collapse the aside on load? */
        'l' => '',      /* Another post slug. Load that post as an aside (content will be ignored)*/
    ), $atts);

    // Generate wrapper div classes based on the attributes values
    $wrapper_classes = 'gt-aside';
    if (!isset($attributes['c']) || $attributes['c']=='true') {
        $wrapper_classes .= ' collapse'; 
    }
    $rendered_content = '<div class="' . $wrapper_classes . '">';
    if (!empty( $attributes['l'] )) {
        // TODO: load the aside post
    }
    elseif (!empty($content)) {
        
        $content = $gt_asides_markdown->transform($content, array('decode_code_blocks' => true) );
        //gt_log($content);
        // for some reason it's still scaping quotes which screws up just en the class attribute
        $content = preg_replace('/\<code class=[^"]"(.*?)[^"]"\>/s', '<code class="language-$1">', $content);
        // FIXME: These are not good, there may be situations where I do want a \' or \" inside a string, for instance
        $content = str_replace("\'", "'", $content);
        $content = str_replace('\"', '"', $content); 

        $rendered_content .= $content;
    }
    // TODO: Add support for inner shortcodes
    $rendered_content .= '</div>';
    //gt_log($rendered_content);
    return $rendered_content;
}