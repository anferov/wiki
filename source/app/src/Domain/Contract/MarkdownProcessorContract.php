<?php

namespace App\Domain\Contract;

interface MarkdownProcessorContract
{
    public function parse(string $markdown): string;
    public function addParser(ParserContract $parserContract): void;
}