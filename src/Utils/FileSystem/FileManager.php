<?php

namespace App\Utils\FileSystem;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;

class FileManager
{
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    #[Pure]
    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    /**
    * @return false|string
    */
    public function getFileContent(string $fileAbsolutePath): bool|string
    {
        if (!$this->filesystem->exists($fileAbsolutePath)) {
            throw new FileNotFoundException();
        }

        return file_get_contents($fileAbsolutePath);
    }
}
