<?php
/**
 * Stubs for the functions in the PS extension
 *
 * This file only exists to make IDEs play nice with code inspections. It is not required for the library to work and
 * should not be executed by an application consuming the library
 */

/**
 * Add bookmark to current page
 *
 * @param resource $psdoc
 * @param string $text
 * @param int $parent
 * @param int $open
 * @return int
 */
function ps_add_bookmark($psdoc, $text, $parent = 0, $open = 0) {}

/**
 * Adds link which launches file
 *
 * @param resource $psdoc
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param string $filename
 * @return bool
 */
function ps_add_launchlink($psdoc, $llx, $lly, $urx, $ury, $filename) {}

/**
 * Adds link to a page in the same document
 *
 * @param resource $psdoc
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param int $page
 * @param string $dest
 * @return bool
 */
function ps_add_locallink($psdoc, $llx, $lly, $urx, $ury, $page, $dest) {}

/**
 * Adds note to current page
 *
 * @param resource $psdoc
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param string $contents
 * @param string $title
 * @param string $icon
 * @param string $open
 * @return bool
 */
function ps_add_note($psdoc, $llx, $lly, $urx, $ury, $contents, $title, $icon, $open) {}

/**
 * Adds link to a page in a second pdf document
 *
 * @param resource $psdoc
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param string $filename
 * @param int $page
 * @param string $dest
 * @return bool
 */
function ps_add_pdflink($psdoc, $llx, $lly, $urx, $ury, $filename, $page, $dest) {}

/**
 * Adds link to a web location
 *
 * @param resource $psdoc
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param string $url
 * @return bool
 */
function ps_add_weblink($psdoc, $llx, $lly, $urx, $ury, $url) {}

/**
 * Draws an arc counterclockwise
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @param float $radius
 * @param float $alpha
 * @param float $beta
 * @return bool
 */
function ps_arc($psdoc, $x, $y, $radius, $alpha, $beta) {}

/**
 * Draws an arc clockwise
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @param float $radius
 * @param float $alpha
 * @param float $beta
 * @return bool
 */
function ps_arcn($psdoc, $x, $y, $radius, $alpha, $beta) {}

/**
 * Start a new page
 *
 * @param resource $psdoc
 * @param float $width
 * @param float $height
 * @return bool
 */
function ps_begin_page($psdoc, $width, $height) {}

/**
 * Start a new pattern
 *
 * @param resource $psdoc
 * @param float $width
 * @param float $height
 * @param float $xstep
 * @param float $ystep
 * @param int $painttype
 * @return int
 */
function ps_begin_pattern($psdoc, $width, $height, $xstep, $ystep, $painttype) {}

/**
 * Start a new template
 *
 * @param resource $psdoc
 * @param float $width
 * @param float $height
 * @return int
 */
function ps_begin_template($psdoc, $width, $height) {}

/**
 * Draws a circle
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @param float $radius
 * @return bool
 */
function ps_circle($psdoc, $x, $y, $radius) {}

/**
 * Clips drawing to current path
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_clip($psdoc) {}

/**
 * Closes image and frees memory
 *
 * @param resource $psdoc
 * @param int $imageid
 * @return void
 */
function ps_close_image($psdoc, $imageid) {}

/**
 * Closes a PostScript document
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_close($psdoc) {}

/**
 * Closes and strokes path
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_closepath_stroke($psdoc) {}

/**
 * Closes path
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_closepath($psdoc) {}

/**
 * Continue text in next line
 *
 * @param resource $psdoc
 * @param string $text
 * @return bool
 */
function ps_continue_text($psdoc, $text) {}

/**
 * Draws a curve
 *
 * @param resource $psdoc
 * @param float $x1
 * @param float $y1
 * @param float $x2
 * @param float $y2
 * @param float $x3
 * @param float $y3
 * @return bool
 */
function ps_curveto($psdoc, $x1, $y1, $x2, $y2, $x3, $y3) {}

/**
 * Deletes all resources of a PostScript document
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_delete($psdoc) {}

/**
 * End a page
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_end_page($psdoc) {}

/**
 * End a pattern
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_end_pattern($psdoc) {}

/**
 * End a template
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_end_template($psdoc) {}

/**
 * Fills and strokes the current path
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_fill_stroke($psdoc) {}

/**
 * Fills the current path
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_fill($psdoc) {}

/**
 * Loads a font
 *
 * @param resource $psdoc
 * @param string $fontname
 * @param string $encoding
 * @param bool $embed
 * @return int
 */
function ps_findfont($psdoc, $fontname, $encoding, $embed = false) {}

/**
 * Fetches the full buffer containing the generated PS data
 *
 * @param resource $psdoc
 * @return string
 */
function ps_get_buffer($psdoc) {}

/**
 * Gets certain parameters
 *
 * @param resource $psdoc
 * @param string $name
 * @param float $modifier
 * @return string
 */
function ps_get_parameter($psdoc, $name, $modifier = 0.0) {}

/**
 * Gets certain values
 *
 * @param resource $psdoc
 * @param string $name
 * @param float $modifier
 * @return float
 */
function ps_get_value($psdoc, $name, $modifier = 0.0) {}

/**
 * Hyphenates a word
 *
 * @param resource $psdoc
 * @param string $text
 * @return array
 */
function ps_hyphenate($psdoc, $text) {}

/**
 * Reads an external file with raw PostScript code
 *
 * @param resource $psdoc
 * @param string $file
 * @return bool
 */
function ps_include_file($psdoc, $file) {}

/**
 * Draws a line
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @return bool
 */
function ps_lineto($psdoc, $x, $y) {}

/**
 * Create spot color
 *
 * @param resource $psdoc
 * @param string $name
 * @param int $reserved
 * @return int
 */
function ps_makespotcolor($psdoc, $name, $reserved = 0) {}

/**
 * Sets current point
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @return bool
 */
function ps_moveto($psdoc, $x, $y) {}

/**
 * Creates a new PostScript document object
 *
 * @return resource
 */
function ps_new() {}

/**
 * Opens a file for output
 *
 * @param resource $psdoc
 * @param string $filename
 * @return bool
 */
function ps_open_file($psdoc, $filename = null) {}

/**
 * Opens image from file
 *
 * @param resource $psdoc
 * @param string $type
 * @param string $filename
 * @param string $stringparam
 * @param int $intparam
 * @return int
 */
function ps_open_image_file($psdoc, $type, $filename, $stringparam = null, $intparam = 0) {}

/**
 * Reads an image for later placement
 *
 * @param resource $psdoc
 * @param string $type
 * @param string $source
 * @param string $data
 * @param int $length
 * @param int $width
 * @param int $height
 * @param int $components
 * @param int $bpc
 * @param string $params
 * @return int
 */
function ps_open_image($psdoc, $type, $source, $data, $length, $width, $height, $components, $bpc, $params) {}

/**
 * Takes an GD image and returns an image for placement in a PS document
 *
 * @param resource $psdoc
 * @param int $gd
 * @return int
 */
function ps_open_memory_image($psdoc, $gd) {}

/**
 * Places image on the page
 *
 * @param resource $psdoc
 * @param int $imageid
 * @param float $x
 * @param float $y
 * @param float $scale
 * @return bool
 */
function ps_place_image($psdoc, $imageid, $x, $y, $scale) {}

/**
 * Draws a line
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @param float $width
 * @param float $height
 * @return bool
 */
function ps_rect($psdoc, $x, $y, $width, $height) {}

/**
 * Restore previously save context
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_restore($psdoc) {}

/**
 * Sets rotation factor
 *
 * @param resource $psdoc
 * @param float $rot
 * @return bool
 */
function ps_rotate($psdoc, $rot) {}

/**
 * Save current context
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_save($psdoc) {}

/**
 * Sets scaling factor
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @return bool
 */
function ps_scale($psdoc, $x, $y) {}

/**
 * Sets color of border for annotations
 *
 * @param resource $psdoc
 * @param float $red
 * @param float $green
 * @param float $blue
 * @return bool
 */
function ps_set_border_color($psdoc, $red, $green, $blue) {}

/**
 * Sets length of dashes for border of annotations
 *
 * @param resource $psdoc
 * @param float $black
 * @param float $white
 * @return bool
 */
function ps_set_border_dash($psdoc, $black, $white) {}

/**
 * Sets length of dashes for border of annotations
 *
 * @param resource $psdoc
 * @param string $style
 * @param float $width
 * @return bool
 */
function ps_set_border_style($psdoc, $style, $width) {}

/**
 * Sets information fields of document
 *
 * @param resource $psdoc
 * @param string $name
 * @param string $value
 * @return bool
 */
function ps_set_info($psdoc, $name, $value) {}

/**
 * Sets certain parameters
 *
 * @param resource $psdoc
 * @param string $name
 * @param string $value
 * @return bool
 */
function ps_set_parameter($psdoc, $name, $value) {}

/**
 * Sets position for text output
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @return bool
 */
function ps_set_text_pos($psdoc, $x, $y) {}

/**
 * Sets certain values
 *
 * @param resource $psdoc
 * @param string $name
 * @param float $value
 * @return bool
 */
function ps_set_value($psdoc, $name, $value) {}

/**
 * Sets current color
 *
 * @param resource $psdoc
 * @param string $type
 * @param string $colorspace
 * @param float $c1
 * @param float $c2
 * @param float $c3
 * @param float $c4
 * @return bool
 */
function ps_setcolor($psdoc, $type, $colorspace, $c1, $c2, $c3, $c4) {}

/**
 * Sets appearance of a dashed line
 *
 * @param resource $psdoc
 * @param float $on
 * @param float $off
 * @return bool
 */
function ps_setdash($psdoc, $on, $off) {}

/**
 * Sets flatness
 *
 * @param resource $psdoc
 * @param float $value
 * @return bool
 */
function ps_setflat($psdoc, $value) {}

/**
 * Sets font to use for following output
 *
 * @param resource $psdoc
 * @param float $fontid
 * @param float $size
 * @return bool
 */
function ps_setfont($psdoc, $fontid, $size) {}

/**
 * Sets gray value
 *
 * @param resource $psdoc
 * @param float $gray
 * @return bool
 */
function ps_setgray($psdoc, $gray) {}

/**
 * Sets appearance of line ends
 *
 * @param resource $psdoc
 * @param int $type
 * @return bool
 */
function ps_setlinecap($psdoc, $type) {}

/**
 * Sets how connected lines are joined
 *
 * @param resource $psdoc
 * @param int $type
 * @return bool
 */
function ps_setlinejoin($psdoc, $type) {}

/**
 * Sets width of a line
 *
 * @param resource $psdoc
 * @param float $width
 * @return bool
 */
function ps_setlinewidth($psdoc, $width) {}

/**
 * Sets the miter limit
 *
 * @param resource $psdoc
 * @param float $value
 * @return bool
 */
function ps_setmiterlimit($psdoc, $value) {}

/**
 * Sets overprint mode
 *
 * @param resource $psdoc
 * @param int $mode
 * @return bool
 */
function ps_setoverprintmode($psdoc, $mode) {}

/**
 * Sets appearance of a dashed line
 *
 * @param resource $psdoc
 * @param float[] $lengths
 * @return bool
 */
function ps_setpolydash($psdoc, $lengths) {}

/**
 * Creates a pattern based on a shading
 *
 * @param resource $psdoc
 * @param int $shadingid
 * @param string $optlist
 * @return int
 */
function ps_shading_pattern($psdoc, $shadingid, $optlist) {}

/**
 * Creates a shading for later use
 *
 * @param resource $psdoc
 * @param string $type
 * @param float $x0
 * @param float $y0
 * @param float $x1
 * @param float $y1
 * @param float $c1
 * @param float $c2
 * @param float $c3
 * @param float $c4
 * @param string $optlist
 * @return int
 */
function ps_shading($psdoc, $type, $x0, $y0, $x1, $y1, $c1, $c2, $c3, $c4, $optlist) {}

/**
 * Fills an area with a shading
 *
 * @param resource $psdoc
 * @param int $shadingid
 * @return bool
 */
function ps_shfill($psdoc, $shadingid) {}

/**
 * Output text in a box
 *
 * @param resource $psdoc
 * @param string $text
 * @param float $left
 * @param float $bottom
 * @param float $width
 * @param float $height
 * @param string $hmode
 * @param string $feature
 * @return int
 */
function ps_show_boxed($psdoc, $text, $left, $bottom, $width, $height, $hmode, $feature = null) {}

/**
 * Output text at position
 *
 * @param resource $psdoc
 * @param string $text
 * @param int $len
 * @param float $x
 * @param float $y
 * @return bool
 */
function ps_show_xy2($psdoc, $text, $len, $x, $y) {}

/**
 * Output text at position
 *
 * @param resource $psdoc
 * @param string $text
 * @param float $x
 * @param float $y
 * @return bool
 */
function ps_show_xy($psdoc, $text, $x, $y) {}

/**
 * Output a text at current position
 *
 * @param resource $psdoc
 * @param string $text
 * @param int $len
 * @return bool
 */
function ps_show2($psdoc, $text, $len) {}

/**
 * Output a text at current position
 *
 * @param resource $psdoc
 * @param string $text
 * @return bool
 */
function ps_show($psdoc, $text) {}

/**
 * Gets geometry of a string
 *
 * @param resource $psdoc
 * @param string $text
 * @param int $fontid
 * @param float $size
 * @return array
 */
function ps_string_geometry($psdoc, $text, $fontid = 0, $size = 0.0) {}

/**
 * Gets width of a string
 *
 * @param resource $psdoc
 * @param string $text
 * @param int $fontid
 * @param float $size
 * @return float
 */
function ps_stringwidth($psdoc, $text, $fontid = 0, $size = 0.0) {}

/**
 * Draws the current path
 *
 * @param resource $psdoc
 * @return bool
 */
function ps_stroke($psdoc) {}

/**
 * Gets name of a glyph
 *
 * @param resource $psdoc
 * @param int $ord
 * @param int $fontid
 * @return string
 */
function ps_symbol_name($psdoc, $ord, $fontid = 0) {}

/**
 * Gets width of a glyph
 *
 * @param resource $psdoc
 * @param int $ord
 * @param int $fontid
 * @param float $size
 * @return float
 */
function ps_symbol_width($psdoc, $ord, $fontid = 0, $size = 0.0) {}

/**
 * Output a glyph
 *
 * @param resource $psdoc
 * @param int $ord
 * @return bool
 */
function ps_symbol($psdoc, $ord) {}

/**
 * Sets translation
 *
 * @param resource $psdoc
 * @param float $x
 * @param float $y
 * @return bool
 */
function ps_translate($psdoc, $x, $y) {}
