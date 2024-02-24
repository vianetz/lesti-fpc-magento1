<?php

/** @immutable */
final class Lesti_Fpc_Model_Fpc_CacheItem
{
    private string $_content;
    private int $_time;
    private string $_contentType;

    public function __construct(string $content, int $time, string $contentType)
    {
        $this->_content = $content;
        $this->_time = $time;
        $this->_contentType = $contentType;
    }

    public function getContent(): string
    {
        return $this->_content;
    }

    public function getTime(): int
    {
        return $this->_time;
    }

    public function getContentType(): string
    {
        return $this->_contentType;
    }
}
