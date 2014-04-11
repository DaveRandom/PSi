<?php

/**
 * Class PSDocument
 *
 * @property-read resource $resource read-only access to the underlying ps resource
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
     * @var string[]
     */
    private $meta = [];

    /**
     * @var \PSImage[]
     */
    private $images = [];

    private $fonts = [];

    /**
     * @var string[]
     */
    private $searchPaths = [];

    /**
     * Normalise meta field names to lower case and set the values on the document resource
     *
     * @param string[] $meta
     * @throws \LogicException
     */
    private function setMeta(array $meta)
    {
        static $metaFields = [
            'keywords' => 'Keywords', 'subject' => 'Subject', 'title' => 'Title',
            'creator' => 'Creator', 'author' => 'Author',
        ];

        foreach ($meta as $name => $value) {
            $nameLower = strtolower($name);

            if (!isset($metaFields[$nameLower])) {
                throw new \LogicException('Unknown field in meta data: ' . $name);
            }

            if ($value !== null) {
                $this->meta[$nameLower] = (string) $value;
                ps_set_info($this->resource, $metaFields[$nameLower], $this->meta[$nameLower]);
            }
        }
    }

    /**
     * Set the dimensions of the document
     *
     * @param float $width
     * @param float $height
     * @param int $orientation
     */
    private function setDimensions($width, $height, $orientation)
    {
        $this->width = $width;
        $this->height = $height;
        ps_set_info($this->resource, 'BoundingBox', "0 0 {$width} {$height}");

        $this->orientation = $orientation === self::ORI_LANDSCAPE ? self::ORI_LANDSCAPE : self::ORI_PORTRAIT;
        ps_set_info($this->resource, 'Orientation', $this->orientation === self::ORI_LANDSCAPE ? 'Landscape' : 'Portrait');
    }

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
     * The destructor function allows us to remove the image from the document's internal list without
     * exposing the list structure itself as public.
     *
     * @param int $id
     * @return \PSImage
     */
    private function createImage($id)
    {
        if (!isset($this->images[$id])) {
            $this->images[$id] = new \PSImage($this, $id, function() use($id) {
                unset($this->images[$id]);
            });
        }

        return $this->images[$id];
    }

    private function createFont($name, $id)
    {

    }

    /**
     * Add a path to the list of search paths if not already set
     *
     * @param string $path
     */
    private function addSearchPath($path)
    {
        if (!isset($this->searchPaths[$path])) {
            ps_set_parameter($this->resource, 'SearchPath', $path);
            $this->searchPaths[$path] = true;
        }
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
        if (!function_exists('ps_new')) {
            throw new \LogicException('The PS extension must be installed to use this class');
        }

        if (!$this->resource = ps_new()) {
            throw new \RuntimeException('Failed to initialise the document resource');
        }

        $this->setDimensions((float) $width, (float) $height, (int) $orientation);
        $this->setMeta((array) $meta);
    }

    /**
     * Magic getter
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $name === 'resource' ? $this->resource : null;
    }

    /**
     * Get the width of the document in (units?)
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get the height of the document in (units?)
     *
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Get the orientation of the document
     *
     * @return int
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Get a meta field value or an associative meta fields
     *
     * @param string $key
     * @return string|string[]
     * @throws \LogicException
     */
    public function getMeta($key = null)
    {
        if ($key !== null) {
            $keyLower = strtolower($key);

            if (!isset($this->meta[$keyLower])) {
                throw new \LogicException('Unknown meta field name: ' . $key);
            }

            return $this->meta[$keyLower];
        }

        return $this->meta;
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
    public function loadImageFromData($data, $width, $height, $type, $colors = 4, $bpc = 8)
    {
        $id = ps_open_image(
            $this->resource, $this->resolveImageType($type), null, $data,
            strlen($data), $width, $height, $colors, $bpc, null
        );

        if (!$id) {
            throw new \RuntimeException('Unable to create image from data string');
        }

        return $this->createImage($id);
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
    public function loadImageFromFile($filePath, $type = null)
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

        $id = ps_open_image_file($this->resource, $this->resolveImageType($type), $filePath);

        if (!$id) {
            throw new \RuntimeException('Unable to create image from file: ' . $filePath);
        }

        return $this->createImage($id);
    }

    /**
     * Create an image from a gd resource
     *
     * @param resource $gd
     * @return \PSImage
     * @throws \RuntimeException
     * @throws \LogicException
     */
    public function loadImageFromGD($gd)
    {
        if (!function_exists('imagecreate')) {
            throw new \LogicException('Method requires the GD extension to be loaded');
        }

        $id = ps_open_memory_image($this->resource, (int) $gd);

        if (!$id) {
            throw new \RuntimeException('Unable to create image from GD resource');
        }

        return $this->createImage($id);
    }

    /**
     * Get an image from its identifier
     *
     * @param int $id
     * @return \PSImage
     * @throws \LogicException
     */
    public function getImageById($id)
    {
        if (!isset($this->images[$id])) {
            throw new \LogicException('Undefined image id: ' . $id);
        }

        return $this->images[$id];
    }

    public function loadFont($name, $encoding = '', $embed = false)
    {
        if (is_file($name . '.afm')) {
            // slightly ugly way to guarantee that fonts referenced by name only that exist in
            // the cwd will be found, by forcing it into the path-based route
            $name = $name . '.afm';
        }

        if (pathinfo($name, PATHINFO_EXTENSION) === 'afm') {
            $fontName = pathinfo($name, PATHINFO_FILENAME);

            if (is_file($name)) {
                $dirPath = dirname(realpath($name));

                if ($embed && !is_file($dirPath . '/' . $fontName . '.pfb')) {
                    throw new \RuntimeException('Embedded fonts must provide a corresponding pfb file');
                }

                $this->addSearchPath($dirPath);
            }
        } else {
            $fontName = (string) $name;
        }

        $id = ps_findfont($this->resource, $fontName, (string) $encoding, (bool) $embed);

        if (!$id) {
            throw new \RuntimeException('Unable to load font: ' . $fontName);
        }
    }

    /**
     * Place an image in the document
     *
     * @param \PSImage $image
     * @param float $x
     * @param float $y
     * @param float $scale
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function placeImage(\PSImage $image, $x, $y, $scale = 1.0)
    {
        if ($image->getOwnerDocument() !== $this) {
            throw new \LogicException('Supplied image is not owned by this document');
        }

        if (!ps_place_image($this->resource, $image->getID(), $x, $y, $scale)) {
            throw new \RuntimeException('Unable to place image ' . $image->getID() . ' in document');
        }
    }
}
