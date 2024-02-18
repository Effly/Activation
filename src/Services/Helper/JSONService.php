<?php

namespace App\Services\Helper;

use Symfony\Component\Filesystem\Filesystem;

class JSONService
{
    public function __construct(
        private readonly Filesystem $filesystem
    )
    {
    }

    public function createJsonFile(string $number, string $data): void
    {
        $currentDate = new \DateTime('now');
        $path = $this->generatePath($currentDate);
        $this->filesystem->mkdir($path);
        $filePath = $path . '/' . $number . '.json';
        $this->filesystem->dumpFile($filePath, json_encode($data));
    }

    private function generatePath(\DateTime $date): string
    {
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        return $year . '/' . $month . '/' . $day;
    }
}