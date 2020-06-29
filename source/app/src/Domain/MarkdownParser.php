<?php

namespace App\Domain;

use App\Domain\Contract\ParserContract;
use Parsedown;

class MarkdownParser implements ParserContract{

    private Parsedown $parsedown;

    public function __construct(Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    public function parse(string $markdown): string
    {
        return $this->parsedown->text($markdown);
    }
}