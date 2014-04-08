<?php

/**
 * Class PSDocument
 *
 * @property-read float $width
 * @property-read float $height
 */
class PSDocument
{
    const ORI_PORTRAIT = 1;
    const ORI_LANDSCAPE = 2;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @var float
     */
    private $width;

    /**
     * @var float
     */
    private $height;

    /**
     * Constructor
     *
     * @param float $width
     * @param float $height
     * @param int $orientation
     * @param object|array $meta
     * @throws \LogicException when the PS extension is not available or bad arguments are passed
     * @throws \RuntimeException when initialising the document fails
     */
    public function __construct($width, $height, $orientation = self::ORI_PORTRAIT, $meta = [])
    {
        if (!function_exists('ps_new')) {
            throw new \LogicException('The PS extension must be installed to use this class');
        }

        if (!$this->resource = ps_new()) {
            throw new \RuntimeException('Failed to initialise the document resource');
        }

        $meta = (array) $meta;
        foreach (['Keywords', 'Subject', 'Title', 'Creator', 'Author'] as $name) {
            if (isset($meta[$name])) {
                ps_set_info($this->resource, $name, (string) $meta[$name]);
            } else {
                throw new \LogicException('Unknown field in meta data: ' . $name);
            }
        }

        $this->width = (float) $width;
        $this->height = (float) $height;
    }

    public function beginPage()
    {
        ps_begin_page($this->resource, $this->width, $this->height);
    }
}
