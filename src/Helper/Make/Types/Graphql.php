<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Graphql extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'entity',
        'graphql type',
        'graphql php type'
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'entity',
        'graphql type',
        'graphql php type'
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
    public $requiredUnless = [
        'graphql php type'=>[
            'option'    =>  'graphql type',
            'value'     =>  '.php'
        ]
    ];

    /**
     * Fill all placeholders in the stub file
     *
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []):bool{
        $values['name'] = Naming::class($values['name']);

        // Create Inputs
        $placeholders=[
            '{{ENTITY}}'=>$values['name'],
            '{{ENTITY_PLURARL}}'=> Str::plural(Str::lower($values['name'])),
            '{{ENTITY_LC}}'=>Str::lower($values['name']),
            '{{DOMAIN}}'=>$values['domain'],
            '{{NAME}}'=>$values['name'],
            '{{NAME_LC}}'=>Str::lower($values['name'])
        ];

        if($values['graphql type'] == '.php'){
            $this->createPHPFiles($values,$placeholders);
        }else{
            $this->createGraphQLFiles($values,$placeholders);
        }

        return true;
    }

    private function createGraphQLFiles(Array $values,Array $placeholders):void{
        $entity = Naming::class($values['entity']);

        $files = [
            'Mutations',
            'Queries',
            'Subscriptions',
            'Types',
            'Inputs',
        ];
        foreach($files as $key){

            $content = Str::of($this->getStub("graphql-$key"))->replace(array_keys($placeholders),array_values($placeholders));
            $file = Path::toDomain($values['domain'],'Graphql',$key,$entity.'.graphql');
            if(File::exists($file)){
                File::append($file,"\n$content");
            }else{
                File::put($file,$content);
            }
        }
    }

    private function createPHPFiles(Array $values,Array $placeholders):void{

        switch($values['graphql php type']){
            case 'query':
                $content = Str::of($this->getStub('graphql-Queries-php'))->replace(array_keys($placeholders),array_values($placeholders));
                File::put(Path::toDomain($values['domain'],'Graphql','Queries',$values['name'].'.php'),$content);
            break;
            case 'mutation':
                $content = Str::of($this->getStub('graphql-Mutations-php'))->replace(array_keys($placeholders),array_values($placeholders));
                File::put(Path::toDomain($values['domain'],'Graphql','Mutations',$values['name'].'.php'),$content);
            break;
            case 'directive':
                $content = Str::of($this->getStub('graphql-Directives-php'))->replace(array_keys($placeholders),array_values($placeholders));
                File::put(Path::toDomain($values['domain'],'Graphql','Directives',$values['name'].'Directive.php'),$content);
            break;
            case 'scalar':
                $content = Str::of($this->getStub('graphql-Scalars-php'))->replace(array_keys($placeholders),array_values($placeholders));
                File::put(Path::toDomain($values['domain'],'Graphql','Scalars',$values['name'].'.php'),$content);
                File::append(base_path('graphql/directives.graphql'),"\nscalar ".$values['name']."\n");
            break;

        }
    }

}
