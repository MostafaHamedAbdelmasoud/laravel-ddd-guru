<?php

namespace MostafaHamed\DDD;

use MostafaHamed\DDD\Helper\ArrayFormatter;
use MostafaHamed\DDD\Helper\Make\Types\Domain;
use MostafaHamed\DDD\Helper\Make\Types\FirstDomain;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use MostafaHamed\DDD\Helper\Stub;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Formatter\NullOutputFormatter;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Generate Main DDD Direcotry-Sturcutre
 */
class Directory extends Command
{
    use Stub;

    private $base = "app";

    /**
     * Contains the base structure after converting nested array to Dot formate
     *
     * @var array
     */
    private $filesystem = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddd:directory
    {--withoutBackup}
    {--removeBackup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the current directroy structure to suit DDD application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->filesystem = ArrayFormatter::dot(config('ddd.structure.base'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {


            Artisan::call('vendor:publish', [
                '--provider' => 'Mediconesystems\LivewireDatatables\LivewireDatatablesServiceProvider',
            ]);

            $this->info("Livewire config Published");

            Artisan::call('livewire:publish', [
                '--assets'=>true
            ]);
            $this->info("Livewire assets Published");

            Artisan::call('vendor:publish', [
                '--provider' => 'Joselfonseca\LighthouseGraphQLPassport\Providers\LighthouseGraphQLPassportServiceProvider',
            ]);
            $this->info("Auth Passport Config Published");

            $this->setupDirectory();
            $this->bootstrap();
            $this->firstDomain();

            $this->setupJS();
        } catch (\Exception $e) {
            echo("\033[31m ".$e->getMessage() ."\033[0m\n");
            return  false;
        }
    }

    /**
     * Create Domain sub-directories
     *
     * @return void
     */
    private function setupDirectory()
    {

        if (File::isDirectory(base_path($this->base))) {
            File::deleteDirectory($this->base);
        }

        foreach ($this->filesystem as $folder => $files) {

            $folder = str_replace('.', DIRECTORY_SEPARATOR, $folder);

            File::makeDirectory(base_path() . DIRECTORY_SEPARATOR . $this->base . DIRECTORY_SEPARATOR . $folder, 0777, true, true);

            foreach ($files as $file) {

                $destination = base_path() . DIRECTORY_SEPARATOR . $this->base . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file;

                $stub = File::get(__DIR__ . '/../stub/' . $folder . '/' . basename($file, '.php') . '.stub');

                File::put($destination, $stub);
            }
        }


        File::put(base_path('routes') . DIRECTORY_SEPARATOR . 'web.php', $this->getStub('route-web'));
    }

    /**
     * Create Configuration files
     *
     * @return void
     */
    private function bootstrap()
    {
        // Set Config App
        File::put(config_path('app.php'), $this->getStub('config-app'));

        if (app()->version() >= "9"){
            File::move('lang',resource_path('lang'));
        }
//        File::ensureDirectoryExists(resource_path('lang/en'));
        File::put(resource_path('lang/en/main.php'), $this->getStub('main-translation'));
        File::put(config_path('auth.php'), $this->getStub('config-auth'));
        File::put(config_path('cors.php'), $this->getStub('config-cors'));
        // File::put(config_path('lighthouse.php'),$this->getStub('config-lighthouse'));
        File::put(base_path('phpunit.xml'), $this->getStub('phpunit'));

        // Set Bootstrap
        File::put(base_path('bootstrap') . DIRECTORY_SEPARATOR . 'app.php', File::get(__DIR__ . '/../stub/Bootstrap/app.stub'));

        // Set GraphQL

        // File::put(base_path('graphql/directives.graphql'),$this->getStub('graphql-common'));
        // File::put(base_path('graphql/schema.graphql'),"#import directives.graphql\n#import ../app/Domain/*/Graphql/*/*.graphql");
    }

    /**
     * Generate User Domain
     *
     * @return void
     */
    private function firstDomain()
    {

        File::delete(base_path('navbar.json'));

        FirstDomain::createService([]);


        $navbar = rtrim(Path::toCommon('Components', 'Navbar'), DIRECTORY_SEPARATOR);
        if (!File::isDirectory($navbar)) {
            File::makeDirectory($navbar, 0755, true);
        }
        File::copyDirectory(Path::build(Path::package(), 'views', config('ddd.layout')[0], 'navbar'), $navbar);

        $header = rtrim(Path::toCommon('Components', 'Header'), DIRECTORY_SEPARATOR);
        if (!File::isDirectory($header)) {
            File::makeDirectory($header, 0755, true);
        }
        File::copyDirectory(Path::build(Path::package(), 'views', config('ddd.layout')[0], 'header'), $header);

        $footer = rtrim(Path::toCommon('Components', 'Footer'), DIRECTORY_SEPARATOR);
        if (!File::isDirectory($footer)) {
            File::makeDirectory($footer, 0755, true);
        }
        File::copyDirectory(Path::build(Path::package(), 'views', config('ddd.layout')[0], 'footer'), $footer);
    }


    public function setupJS()
    {
        File::put(resource_path('js/app.js'), $this->getStub('app-js'));

        $commans = [
            'npm i',
            'npm i vue',
            'npm install vuex --save',
            'npm install es6-promise',
            'npm install tailwindcss'
        ];

        shell_exec(join(' & ', $commans));

    }
}
