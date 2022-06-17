<?php

namespace MostafaHamed\DDD;

use MostafaHamed\DDD\Helper\FileCreator;
use Illuminate\Console\Command;
use MostafaHamed\DDD\Helper\Make\Service\MakeFactory;
use MostafaHamed\DDD\Helper\Make\Service\NullMaker;
use Illuminate\Support\Facades\Artisan;

class Make extends Command
{

    /**
     * Holder Makers
     *
     * @var array
     */
    private $maker;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddd:make {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create Domain\n\tCRUD\n\tDatatable\n\tEntity\n\tController\n\tRequest\n\tSAC\n\tListener\n\tNotification\n\tEmail\n\tProvider\n\tRepository\n\tView\n\tResource";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        MakeFactory::defineAttributes($this->signature);

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * Pass instance of the command so we can create instance of Maker based on type
         */
        $maker = MakeFactory::create($this);

        /**
         * Check if Maker supported
         */
        if($maker instanceof NullMaker){
            $this->error($this->argument('type')." type is not supported");
            return;
        }

        $result = $maker->create();

        if($result){
            $this->info("Process successded");
        }else{
            $this->error("Process Failed");
        }
    }
}
