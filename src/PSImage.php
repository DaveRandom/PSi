<?php

/**
 * Class PSImage
 */
class PSImage
{
    /**
     * Image type constants
     */
    const TYPE_PNG  = 1;
    const TYPE_JPEG = 2;
    const TYPE_EPS  = 4;

    /**
     * Image encoding constants
     */
    const ENCODING_HEX = 1;
    const ENCODING_85  = 2;

    /**
     * @var \PSDocument
     */
    private $document;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $dtor;

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
    private $encoding;

    /**
     * Constructor
     *
     * @param PSDocument $document
     * @param int $id
     * @param callable $dtor
     */
    public function __construct(PSDocument $document, $id, callable $dtor)
    {
        $this->document = $document;
        $this->id = $id;
        $this->dtor = $dtor;
    }

    /**
     * Get the document that owns this image
     *
     * @return \PSDocument
     */
    public function getOwnerDocument()
    {
        return $this->document;
    }

    /**
     * Get the ID of this image within the owner document
     *
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Get the width of this image in (units?)
     *
     * @return float
     */
    public function getWidth()
    {
        if (!isset($this->width)) {
            $this->width = ps_get_value($this->document->resource, "imagewidth", $this->id);
        }

        return $this->width;
    }

    /**
     * Get the height of this image in (units?)
     *
     * @return float
     */
    public function getHeight()
    {
        if (!isset($this->height)) {
            $this->height = ps_get_value($this->document->resource, "imageheight", $this->id);
        }

        return $this->height;
    }

    /**
     * Get the encoding constant for this image
     *
     * @return int
     */
    public function getEncoding()
    {
        if (!isset($this->encoding)) {
            $encoding = ps_get_parameter($this->document->resource, 'imageencoding', $this->id);
            $this->encoding = $encoding === 'hex' ? self::ENCODING_HEX : self::ENCODING_85;
        }

        return $this->encoding;
    }

    /**
     * Destroy this image and call the destructor function
     */
    public function close()
    {
        ps_close_image($this->document->resource, $this->id);
        call_user_func($this->dtor);

        $this->document = $this->dtor = null;
    }
}
