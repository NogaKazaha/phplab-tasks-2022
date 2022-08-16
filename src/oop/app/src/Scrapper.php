<?php

namespace src\oop\app\src;

use src\oop\app\src\Transporters\TransportInterface;
use src\oop\app\src\Parsers\ParserInterface;

class Scrapper
{
    /**
     * @var TransportInterface
     */
    private $transporter;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var TransportInterface
     * @var ParserInterface
     */
    public function __construct(TransportInterface $transporter, ParserInterface $parser)
    {
        $this->transporter = $transporter;
        $this->parser = $parser;
    }

    public function getMovie($url)
    {
        $transport = $this->transporter->getContent($url);
        $parsed = $this->parser->parseContent($transport);
        return $parsed;
    }
}
