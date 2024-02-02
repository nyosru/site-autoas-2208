<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\App;

class ListClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:classes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display a list of registered classes in Laravel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        return 0;
//        $classes = App::getClasses();
        $this->info('List of registered classes:');
//        foreach ($classes as $class) {
//            $this->line($class);
//        }

        $bindings = Container::getInstance()->getBindings();
        $bindings2 = (array) $bindings;
        ksort($bindings2);
        foreach ($bindings2 as $key => $value) {
//            echo $key . '<br>';
//            if( strpos( $key , 'phpcat' ) !== false )
            echo $key . PHP_EOL;
        }

    }
}
