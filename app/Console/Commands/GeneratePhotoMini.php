<?php

namespace App\Console\Commands;

use App\Services\PhotoMiniService;
use Illuminate\Console\Command;

class GeneratePhotoMini extends Command
{
    protected $signature = 'photo:generate-mini
                            {--width=200 : Width of mini image in pixels}';

    protected $description = 'Create 200px-wide JPG mini versions of photos in storage/app/public/photo/';

    public function handle(PhotoMiniService $service): int
    {
        $service->setWidth((int)$this->option('width'));

        $this->info('Scanning photos...');

        [$processed, $errors] = $service->run();

        $this->info("Processed: $processed mini images created");

        if ($errors) {
            $this->warn('Errors:');
            foreach ($errors as $error) {
                $this->error("  - $error");
            }
        }

        return $processed > 0 ? self::SUCCESS : self::FAILURE;
    }
}
