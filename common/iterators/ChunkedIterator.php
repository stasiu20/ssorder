<?php

namespace common\iterators;

/**
 * Class ChunkedIterator
 * @package common\iterators
 * @link https://raw.githubusercontent.com/guzzle/guzzle3/master/src/Guzzle/Iterator/ChunkedIterator.php
 */
class ChunkedIterator extends \IteratorIterator
{
    /** @var int Size of each chunk */
    protected $chunkSize;

    /** @var array Current chunk */
    protected $chunk;

    /**
     * @param \Traversable $iterator Traversable iterator
     * @param int $chunkSize Size to make each chunk
     * @throws \InvalidArgumentException
     */
    public function __construct(\Traversable $iterator, $chunkSize)
    {
        $chunkSize = (int)$chunkSize;
        if ($chunkSize < 0) {
            throw new \InvalidArgumentException("The chunk size must be equal or greater than zero; $chunkSize given");
        }

        parent::__construct($iterator);
        $this->chunkSize = $chunkSize;
    }

    public function rewind()
    {
        parent::rewind();
        $this->next();
    }

    public function next()
    {
        $this->chunk = [];
        for ($i = 0; $i < $this->chunkSize && parent::valid(); $i++) {
            $this->chunk[] = parent::current();
            parent::next();
        }
    }

    public function current()
    {
        return $this->chunk;
    }

    public function valid()
    {
        return (bool)$this->chunk;
    }
}
