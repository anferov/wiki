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
        dd($this->parsers);

        $content = $markdown;

        foreach ($this->parsers as $parser){
            $content = $parser->parse($markdown);
        }

        return $content;
    }

    public function addParser(ParserContract $parserContract): void
    {
        $this->parsers[] = $parserContract;
    }
}