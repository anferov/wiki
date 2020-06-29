<?php

namespace App\Domain\Contract;

interface ContentRepositoryContract
{
    public function findMarkdownByToken(string $token): string;
}