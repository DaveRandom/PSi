<?php

/**
 * Class PSDocument
 *
 * @property-read float $width
 * @property-read float $height
 * @property-read int $orientation
 * @property-read string $keywords
 * @property-read string $subject
 * @property-read string $title
 * @property-read string $creator
 * @property-read string $author
 */
class PSDocument
{
    /**
     * Page orientation constants
     */
    const ORI_PORTRAIT = 0;
    const ORI_LANDSCAPE = 1;

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
     * @var int
     */
    private $orientation;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $creator;

    /**
     * @var string
     */
    private $author;

    /**
     * Resolve an integer image type identifier to a string
     *
     * @param int $type
     * @return string
     * @throws \LogicException
     */
    private function resolveImageType($type)
    {
        static $typeStrings = [
            \PSImage::TYPE_PNG  => 'png',
            \PSImage::TYPE_JPEG => 'jpeg',
            \PSImage::TYPE_EPS  => 'eps',
        ];

        if (!isset($typeStrings[$type])) {
            throw new \LogicException('Invalid image type: ' . $type);
        }

        return $typeStrings[$type];
    }

    /**
     * Create a PSImage object from an image identifier and type
     *
     * @param int $imageId
     * @return \PSImage
     */
    private function createImage($imageId)
    {
        return new \PSImage($this, $this->resource, $imageId);
    }

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
        static $infoFields = [
            'keywords' => 'Keywords', 'subject' => 'Subject', 'title' => 'Title',
            'creator' => 'Creator', 'author' => 'Author',
        ];

        if (!function_exists('ps_new')) {
            throw new \LogicException('The PS extension must be installed to use this class');
        }

        if (!$this->resource = ps_new()) {
            throw new \RuntimeException('Failed to initialise the document resource');
        }

        foreach ((array) $meta as $name => $value) {
            if (!isset($infoFields[$name = strtolower($name)])) {
                throw new \LogicException('Unknown field in meta data: ' . $name);
            }

            if ($value !== null) {
                $this->$name = (string) $value;
                ps_set_info($this->resource, $infoFields[$name], $this->$name);
            }
        }

        $this->width = (float) $width;
        $this->height = (float) $height;
        ps_set_info($this->resource, 'BoundingBox', "0 0 {$this->width} {$this->height}");

        $this->orientation = ((int) $orientation) === self::ORI_LANDSCAPE ? self::ORI_LANDSCAPE : self::ORI_PORTRAIT;
        ps_set_info($this->resource, 'Orientation', $this->orientation === self::ORI_LANDSCAPE ? 'Landscape' : 'Portrait');
    }

    /**
     * Magic getter
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        static $readableProperties = ['width', 'height', 'keywords', 'subject', 'title', 'creator', 'author'];

        return in_array($name, $readableProperties) ? $this->$name : null;
    }

    /**
     * Start a new page
     */
    public function beginPage()
    {
        ps_begin_page($this->resource, $this->width, $this->height);
    }

    /**
     * Fetches the full buffer containing the generated PS data
     *
     * @return string
     */
    public function getBuffer()
    {
        return ps_get_buffer($this->resource);
    }

    /**
     * Create an image from a data string
     *
     * @param int $type
     * @param string $data
     * @param int $width
     * @param int $height
     * @param int $colors
     * @param int $bpc
     * @return \PSImage
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function createImageFromData($data, $width, $height, $type, $colors = 4, $bpc = 8)
    {
        $imageId = ps_open_image(
            $this->resource, $this->resolveImageType($type), null, $data,
            strlen($data), $width, $height, $colors, $bpc, null
        );

        if (!$imageId) {
            throw new \RuntimeException('Unable to create image from data string');
        }

        return $this->createImage($imageId, $type);
    }

    /**
     * Create an image from a file
     *
     * @param string $filePath
     * @param int $type
     * @return \PSImage
     * @throws \RuntimeException
     * @throws \LogicException
     */
    public function createImageFromFile($filePath, $type = null)
    {
        static $knownExtensions = [
            'png'  => \PSImage::TYPE_PNG,
            'jpg'  => \PSImage::TYPE_JPEG,
            'jpeg' => \PSImage::TYPE_JPEG,
            'eps'  => \PSImage::TYPE_EPS,
        ];

        if (!file_exists($filePath) || !is_file($filePath) || !is_readable($filePath)) {
            throw new \RuntimeException('Supplied image file path does not exist or is not readable: ' . $filePath);
        }

        if ($type === null) {
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            if (!isset($knownExtensions[$extension])) {
                throw new \LogicException('No image type specified an unable to infer valid type from file extension: ' . $filePath);
            }

            $type = $knownExtensions[$extension];
        }

        $imageId = ps_open_image_file($this->resource, $this->resolveImageType($type), $filePath);

        if (!$imageId) {
            throw new \RuntimeException('Unable to create image from file: ' . $filePath);
        }

        return $this->createImage($imageId, $type);
    }

    /**
     * Create an image from a gd resource
     *
     * @param resource $gd
     * @return \PSImage
     * @throws \RuntimeException
     * @throws \LogicException
     */
    public function createImageFromGD($gd)
    {
        if (!function_exists('imagecreate')) {
            throw new \LogicException('Method requires the GD extension to be loaded');
        }

        $imageId = ps_open_memory_image($this->resource, (int) $gd);

        if (!$imageId) {
            throw new \RuntimeException('Unable to create image from GD resource');
        }

        return $this->createImage($imageId);
    }

    /**
     * Place an image in the document
     *
     * @param PSImage $image
     * @param float $x
     * @param float $y
     * @param float $scale
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function placeImage(\PSImage $image, $x, $y, $scale = 1.0)
    {
        if ($image->document !== $this) {
            throw new \LogicException('Supplied image is not owned by this document');
        }

        if (!ps_place_image($this->resource, $image->id, $x, $y, $scale)) {
            throw new \RuntimeException('Unable to place image ' . $image->id . ' in document');
        }
    }
}
