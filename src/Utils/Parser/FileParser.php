<?php

namespace App\Utils\Parser;

class FileParser
{
    /**
     * @param string $delimiter
     * @param string $fileContent
     * @return array
     */
    public static function parseByDelimiter(string $delimiter, string $fileContent): array
    {
        return explode($delimiter, $fileContent);
    }
}
