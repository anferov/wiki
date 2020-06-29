<?php

namespace App\Domain\Contract;

interface ParserContract
{
    public function parse(string $markdown): string;
}