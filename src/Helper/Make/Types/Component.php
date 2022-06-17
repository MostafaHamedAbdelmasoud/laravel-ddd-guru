<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Component extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [
        'name',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [];

    /**
     * Check if the current options is True/False question
     *
     * @return Array
     */
    public $booleanOptions = [];

    /**
     * Check if the current options is requesd based on other option
     *
     * @return Array
     */
    public $requiredUnless = [];


    public function service(Array $values):Bool{

        if(!File::exists(base_path('navbar.json'))){
            $this->createJSONFile($values);
        }

        if(!File::isDirectory(Path::toCommon('Components'))){
            File::makeDirectory(Path::toCommon('Components'));
        }

        $this->createComponent($values);

        return true;
    }
    private function createJSONFile($values){

        $data = [
            [
                'name'      =>  'user',
                'icon'      =>  'nav-icon fas fa-tachometer-alt',
                'url'     =>  'url-going-to-hit',
                'children'  =>  [
                    [
                        'name'      =>  'List Users',
                        'url'       =>  'url-going-to-hit-list',
                    ],
                    [
                        'name'      =>  'Create New User',
                        'url'       =>  'url-going-to-hit-new',
                    ],
                    [
                        'name'      =>  'Roles',
                        'url'       =>  'url-going-to-hit-roles',
                    ]
                ]
            ],
            [
                'name'      =>  'user',
                'icon'      =>  'nav-icon fas fa-tachometer-alt',
                'url'     =>  'url-going-to-hit',
                'children'  =>  [

                ]
            ]
        ];
        $this->save(base_path(),'navbar','json',json_encode($data,JSON_PRETTY_PRINT));

    }

    private function createComponent($values){
        $name = Naming::class($values['name']);

        File::makeDirectory(Path::toCommon('Components',$name));

        $placholders = [
            '{{NAME}}'=> $name,
        ];

        $blade = Str::of($this->getStub('component-view'))->replace(array_keys($placholders),array_values($placholders));
        $this->save(Path::toCommon('Components',$name),'view','blade.php',$blade);

        $class = Str::of($this->getStub('component-class'))->replace(array_keys($placholders),array_values($placholders));
        $this->save(Path::toCommon('Components',$name),'Component','php',$class);
    }
}
