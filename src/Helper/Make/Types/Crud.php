<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use MostafaHamed\DDD\Helper\Make\Types\Rule;

class Crud extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
    ];

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

    /**
     * Fill all placeholders in the stub file
     *
     * @return Boll
     */
    public function service(Array $values):Bool{

        // Create Entity
        Entity::createService([
            'name'      => $values['name'],
            'domain'    => $values['domain']
        ]);

        // Graphql::createService([
        //     'name'      => $values['name'],
        //     'domain'    => $values['domain'],
        //     'entity'    => $values['name'],
        //     'graphql type'=>'.graphql',
        //     'graphql php type'=>null
        // ]);

        // Create DatabaseView
        // DatabaseView::createService([
        //     'name'      => $values['name'],
        //     'domain'    => $values['domain']
        // ]);

        // Create Database Files
        Migration::createService([
            'domain'    =>  $values['domain'],
            'entity'    =>  $values['name'],
            'append'    =>  false
        ]);

        Factory::createService([
            'name'      =>  $values['name'],
            'domain'    =>  $values['domain'],
            'entity'    =>  $values['name']
        ]);
        Seeder::createService([
            'name'      =>  $values['name'],
            'domain'    =>  $values['domain'],
            'entity'    =>  $values['name'],
            'count'     =>  1000
        ]);

        // Create Views
        $this->views($values);

        // // Create Datatable
        Datatable::createService([
            'name'          =>  $values['name'],
            'domain'        =>  $values['domain'],
            'entity'        =>  $values['name'],
        ]);

        // Create Request
        Request::createService([
            'name'      =>  $values['name'],
            'domain'    =>  $values['domain'],
        ]);

        // Create Repository
        Repo::createService([
            'name'      =>  $values['name'],
            'domain'    =>  $values['domain'],
            'entity'    =>  $values['name']
        ]);

        // Create API Resource
        Resource::createService([
            'name'      =>  $values['name'],
            'domain'    =>  $values['domain'],
            'entity'    =>  Naming::class($values['name']),
        ]);

        // Create API Resource
        // Test::createService([
        //     'name'              =>  $values['name'],
        //     'domain'            =>  $values['domain'],
        //     'entity related'    =>  true,
        //     'entity'            =>  $values['name'],
        //     'test type'         => 'All'
        // ]);

        // Create Controllers
        $this->controllers($values);

        return true;

    }

    private function views($values){
        $dir_name = Str::of(Str::lower($values['name']))->replace(' ','_');
        $route_name = Str::of(Str::plural(Str::lower($values['name'])))->replace(' ','_');

        $dir = Path::toDomain($values['domain'],'Resources','Views',$dir_name);

        if(File::isDirectory($dir)){
            return;
        }
        File::makeDirectory($dir, 0755, true);
        File::makeDirectory(Path::build($dir,'_partials'), 0755, true);
        File::makeDirectory(Path::build($dir,'buttons'), 0755, true);


        $placeholders = [
            "###ROUTE###"=>$route_name,
            "###VIEW###"=>$dir_name,
            '###DATATABLE_NAME###'=> strtolower(Str::of($values['name'])->replace(' ','-'))
        ];

        $fields = Str::of($this->getStub('view-fields'))->replace(array_keys($placeholders),array_values($placeholders));
        $scripts = Str::of($this->getStub('view-scripts'))->replace(array_keys($placeholders),array_values($placeholders));
        $buttons = Str::of($this->getStub('view-buttons'))->replace(array_keys($placeholders),array_values($placeholders));
        $create = Str::of($this->getStub('view-create'))->replace(array_keys($placeholders),array_values($placeholders));
        $edit = Str::of($this->getStub('view-edit'))->replace(array_keys($placeholders),array_values($placeholders));
        $index = Str::of($this->getStub('view-index'))->replace(array_keys($placeholders),array_values($placeholders));
        $show = Str::of($this->getStub('view-show'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save(Path::build($dir,'_partials'),'_fields','blade.php',$fields);
        $this->save(Path::build($dir,'_partials'),'_scripts','blade.php',$scripts);
        $this->save(Path::build($dir,'buttons'),'actions','blade.php',$buttons);

        $this->save($dir,'create','blade.php',$create);
        $this->save($dir,'edit','blade.php',$edit);
        $this->save($dir,'index','blade.php',$index);
        $this->save($dir,'show','blade.php',$show);

        // Modify the layout nabar file
        $navbar_path = base_path('navbar.json');

        if(!File::isFile($navbar_path)){
            $this->save(base_path(),'navbar','json',json_encode([],JSON_PRETTY_PRINT));
        }

        $navbar = json_decode(File::get($navbar_path),true);

        $name = Str::plural(Str::lower($values['name']));

        array_push($navbar,[
            "name"=> $name,
            "icon"=> "nav-icon fas fa-tachometer-alt",
            "route"=> $route_name.'.index',
            "children"=> [
                [
                    "name"=> "list ".$name,
                    "route"=> $route_name.".index"
                ],
                [
                    "name"=> "create new ".Str::lower($values['name']),
                    "route"=> $route_name.".create"
                ]
            ]
        ]);
        $this->save(base_path(),'navbar','json',json_encode($navbar,JSON_PRETTY_PRINT));
    }

    private function controllers($values){

        // Create Resource Controller
        Controller::createService([
            'name'                  =>  $values['name'],
            'domain'                =>  $values['domain'],
            'controller type'       =>  'Normal',
            'repository'            =>  Naming::class($values['name'].' Repository'),
            'request'               =>  Naming::class($values['name']),
            'api resource'          =>  $values['name'],
        ]);

        $controllerName = Naming::class($values['name']).'Controller';
        $route_name = Naming::tableName($values['name']);


        $web_path = Path::toDomain($values['domain'],'Routes','web','auth.php');
        $web_content =Str::of(File::get($web_path))->replace("###CRUD_PLACEHOLDER###","Route::resource('/$route_name','$controllerName');\n\t###CRUD_PLACEHOLDER###");
        $this->save(Path::toDomain($values['domain'],'Routes','web'),'auth','php',$web_content);


        $web_path = Path::toDomain($values['domain'],'Routes','api','auth.php');
        $web_content =Str::of(File::get($web_path))->replace("###CRUD_PLACEHOLDER###","Route::resource('/$route_name','$controllerName');\n\t###CRUD_PLACEHOLDER###");
        $this->save(Path::toDomain($values['domain'],'Routes','api'),'auth','php',$web_content);

    }
}
