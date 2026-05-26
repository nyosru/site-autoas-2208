<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PhotoMiniService
{
    private string $photoDir = 'public/photo';
    private string $miniDir = 'public/photo/mini';
    private int $width = 200;

    public function run(): array
    {
        $files = Storage::files($this->photoDir);
        $processed = 0;
        $errors = [];

        foreach ($files as $file) {
            $basename = pathinfo($file, PATHINFO_BASENAME);
            $miniPath = $this->miniDir . '/' . $basename;

            if (Storage::exists($miniPath)) {
                continue;
            }

            try {
                $this->createMini($file, $miniPath);
                $processed++;
            } catch (\Throwable $e) {
                $errors[] = "$basename: " . $e->getMessage();
            }
        }

        return [$processed, $errors];
    }

    private function createMini(string $sourcePath, string $destPath): void
    {
        $fullSource = Storage::path($sourcePath);
        $fullDest = Storage::path($destPath);

        $destDir = dirname($fullDest);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        [$srcWidth, $srcHeight, $type] = getimagesize($fullSource);

        $supported = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
        if (!in_array($type, $supported, true)) {
            throw new \RuntimeException('Unsupported image type: ' . image_type_to_mime_type($type));
        }

        $srcImage = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($fullSource),
            IMAGETYPE_PNG => imagecreatefrompng($fullSource),
            IMAGETYPE_GIF => imagecreatefromgif($fullSource),
            IMAGETYPE_WEBP => imagecreatefromwebp($fullSource),
        };

        if (!$srcImage) {
            throw new \RuntimeException('Failed to create image from source');
        }

        $ratio = $srcWidth / $srcHeight;
        $newWidth = $this->width;
        $newHeight = (int)round($newWidth / $ratio);

        $dstImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);

        if (!imagejpeg($dstImage, $fullDest, 85)) {
            throw new \RuntimeException('Failed to save JPEG mini image');
        }

        imagedestroy($srcImage);
        imagedestroy($dstImage);
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;
        return $this;
    }
}
