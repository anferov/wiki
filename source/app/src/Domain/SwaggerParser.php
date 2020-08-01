<?php

namespace App\Domain;

use App\Domain\Contract\ParserContract;

class SwaggerParser implements ParserContract
{
    private const PATTERN = '#`{3}swagger[^`]*`{3}#';

    public function parse(string $markdown): string
    {

        dd($markdown);
        dd(preg_replace_callback(self::PATTERN, function ($match) {
            return '<iframe src="http://swagger:8080"></iframe>';
        }, $markdown));


    }
}