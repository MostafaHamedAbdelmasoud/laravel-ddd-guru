<?php

namespace MostafaHamed\DDD;

use ReflectionClass;
use MostafaHamed\DDD\Helper\Path;
use MostafaHamed\DDD\Helper\Stub;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use MostafaHamed\DDD\Helper\ArrayFormatter;
use Illuminate\Support\Facades\Artisan;
use MostafaHamed\DDD\Helper\Make\Types\Domain;
use MostafaHamed\DDD\Helper\Make\Types\FirstDomain;


/**
 * Generate Main DDD Direcotry-Sturcutre
 */
class Build extends Command
{
    private $app_path;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddd:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build domains ';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $backupFolder = File::directories(base_path('backup'));

        if(count($backupFolder)!==1){
            $this->error('you should have only one folder in backup');
            return;
        }
        $this->app_path = $backupFolder[0].DIRECTORY_SEPARATOR.'app';
        $files = File::allFiles($this->app_path);

        foreach($files as $file){
            $namespace = str_replace($this->app_path,'',$file->getPathname());
            $class = 'App\\'.trim($namespace,DIRECTORY_SEPARATOR . ' .php');

            Log::info($class);
            if(class_exists($class)){
            }
        }
    }

}
