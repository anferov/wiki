<?php

namespace App\Domain;

use App\Domain\Contract\MarkdownProcessorContract;
use App\Domain\Contract\ParserContract;

class MarkdownProcessor implements MarkdownProcessorContract
{

    /**
     * @var ParserContract[]
     */
    private array $parsers = [];

    public function parse(string $markdown): string
    {
        $content = $markdown;

        foreach (array_reverse($this->parsers) as $parser){
            $content = $parser->parse($content);
        }

        return $content;
    }

    public function addParser(ParserContract $parserContract): void
    {
        $this->parsers[] = $parserContract;
    }
}