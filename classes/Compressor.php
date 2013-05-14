<?php

/**
 * Interface for various javascript compressors.
 *
 * It is recommended that you use mod_pagespeed (if serving with Apache), or
 * the equivalent for your server software.
 */
class Compressor {
	
    public $js;
    public $compression;
	
    /**
     * Constructor.
     *
     * @param String $js The JavaScript to be compressed
     * @param String $compression The type of compression to use. Compression libraries should be included in coi-social/dependencies
     */
    public function __construct($js, $compression)
    {
        $this->js = $js;
        $this->compression = $compression;
    }

    /**
     * Make the appropriate compression method call.
     *
     * @return String The compressed javascript
     * @throws Exception If $this->compression is set to an unrecognised compressor
     */
    public function compress()
    {
        switch ($this->compression)
        {
            case 'booster':
                return $this->booster();
            case 'packer':
                return $this->packer();
            case 'jshrink':
                return $this->jshrink();
            default:
                throw new Exception("Unrecognized compression method: {$this->compression}");
        }
    }

    /**
     * Compress using the {@link https://github.com/Schepp/CSS-JS-Booster CSS-JS-Booster} compression library.
     *
     * @return String The compressed JavaScript
     * @throws Exception If the CSS-JS-Booster library could not be found
     */
    public function booster()
    {
        // Flush any output in the buffer - prevents Content Encoding Errors {@link http://stackoverflow.com/a/11007081/187954}
        ob_flush();
		$booster_path = Kohana::find_file('vendor', 'booster/booster_inc.php');
        if ( ! is_file($booster_path))
        {
            throw new Exception("Failed to load Booster at {$booster_path}");
        }
        include_once $booster_path;
        $booster = new Booster();
        $booster->js_stringmode = TRUE;
        $booster->js_source = $this->js;
        return $booster->js();
    }

    /**
     * Compress using the {@link http://joliclic.free.fr/php/javascript-packer/en/ Packer} compression library.
     *
     * @return String The compressed JavaScript
     * @throws Exception If the Packer library could not be found
     */
    public function packer()
    {
		$packerPath = Kohana::find_file('vendor', 'packer/class.JavaScriptPacker.php');
        if ( ! is_file($packerPath)) {
            throw new Exception("Failed to load Packer at {$packerPath}");
        }
        include_once $packerPath;
        $packer = new JavaScriptPacker($this->js);

        return $packer->pack();
    }

    /**
     * Compress using the {@link https://github.com/tedivm/JShrink/ JShrink} compression library.
     *
     * @return String The compressed JavaScript
     * @throws Exception If the JShrink library could not be found
     */
    public function jshrink()
    {
        $jshrink_path = Kohana::find_file('vendor', 'jshrink/Minifier.php');
        if ( ! is_file($jshrink_path)) {
            throw new Exception("Failed to load JShrink at {$jshrink_path}");
        }
        include_once $jshrink_path;
        return Minifier::minify($this->js, array('flaggedComments' => false));
    }

}