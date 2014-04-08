<?php

/**
 * Class PSImage
 *
 * @property-read \PSDocument $document
 * @property-read int $id
 * @property-read float $width
 * @property-read float $height
 * @property-read string $encoding
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
     * @var resource
     */
    private $resource;

    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $width;

    /**
     * @var float
     */
    private $height;

    /**
     * @var string
     */
    private $encoding;

    /**
     * Constructor
     *
     * @param PSDocument $document
     * @param resource $resource
     * @param int $id
     */
    public function __construct(PSDocument $document, $resource, $id)
    {
        $this->id = $id;
    }

    /**
     * Magic getter
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'document': case 'id':
                return $this->$name;

            case 'width': case 'height':
                if (!isset($this->$name)) {
                    $this->$name = ps_get_value($this->resource, "image{$name}", $this->id);
                }

                return $this->$name;

            case 'encoding':
                if (!isset($this->encoding)) {
                    $encoding = ps_get_parameter($this->resource, 'imageencoding', $this->id);
                    $this->encoding = $encoding === 'hex' ? self::ENCODING_HEX : self::ENCODING_85;
                }

                return $this->encoding;
        }

        return null;
    }
}
