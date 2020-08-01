<?php

namespace App\Domain;

use App\Domain\Contract\ParserContract;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SwaggerParser implements ParserContract
{
    private const PATTERN = '#`{3}swagger[^`]*`{3}#';
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface  $route;

    public function __construct(Filesystem $filesystem, UrlGeneratorInterface $route)
    {
        $this->filesystem = $filesystem;
        $this->route = $route;
    }

    public function parse(string $markdown): string
    {
        return preg_replace_callback(self::PATTERN, function ($match) {
            $content = str_replace(['```swagger', '```'], ['', ''], $match[0]);
            $fileName = md5($match[0]) . (json_decode($content) === null ? '.yaml' : '.json');

            $this->filesystem->dumpFile($fileName, $content);
            return '<iframe style="display: block; overflow-y: visible" width="100%"  src="http://localhost?url='
                . $this->route->generate('swagger_config', ['token' => $fileName], UrlGeneratorInterface::ABSOLUTE_URL)
                . '"></iframe>';
        }, $markdown);
    }
}