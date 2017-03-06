<?php

namespace ShopBundle\Service\Upload;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Uploader
 * @package ShopBundle\Service\Upload
 */
class Uploader
{
    /**
     * @var string
     */
    private $directory;


    /**
     * Constructor.
     *
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->directory = $directory;

        // Create the directory if it does not exist
        if (!is_dir($directory)) {
            mkdir($this->directory);
        }
    }

    /**
     * Loads the file.
     *
     * @param string $fileName
     *
     * @return File
     */
    public function loadFile($fileName)
    {
        $path = $this->directory . '/' . $fileName;

        if (is_file($path)) {
            return new File($path);
        }

        return null;
    }

    /**
     * Uploads the given file.
     *
     * @param UploadedFile $file
     *
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->directory, $fileName);

        return $fileName;
    }

    /**
     * Removes the given file.
     *
     * @param File $file
     */
    public function remove(File $file)
    {
        if (!$file->isFile()) {
            return;
        }

        @unlink($file->getPath());
    }
}
