<?php

namespace App\Domain;

use App\Domain\Contract\ContentRepositoryContract;

class TmpRepo implements ContentRepositoryContract {

    public function findMarkdownByToken(string $token): string
    {
        switch ($token){
            case "api/opcache":
                return file_get_contents('/srv/www/wiki/src/DataFixtures/stub/example.md');
                break;
            default:
                return '404';

        }
    }
}