<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use ReflectionClass;

class Allow extends Maker
{
    /**
     * Fill all placeholders in the stub file
     *
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $domains = Path::getDomains();

        $repositories = collect([]);

        foreach($domains as $domain){
            if(!File::isDirectory(Path::build('app','Domain',$domain,'Entities'))){
                continue;
            }
            $repos_per_domain = Path::files('app','domain',$domain,'Repositories','Eloquent');
            foreach($repos_per_domain as $repo){
                $repositories->push(NamespaceCreator::Segments('App','Domain',$domain,'Repositories','Eloquent',$repo));
            }
        }

        $allows = collect([]);

        foreach($repositories as $repo){

            $this->getAllowFieldsContent($repo,$allows);

            $path = (new ReflectionClass($repo))->getFileName();
            $file = File::get($path);


            $allow_fields = "\n";
            $_allow_relations =[];
            $allow_relations = "\n";
            foreach($allows->toArray() as $field){
                $allow_fields.="\t\t'$field',\n";

                $relations = explode('.',$field);
                if(count($relations)>1){
                    array_pop($relations);
                    $relations = implode('.',$relations);
                    if(!in_array($relations,$_allow_relations)){
                        $allow_relations.="\t\t'$relations',\n";
                        array_push($_allow_relations,$relations);
                    }
                }
            }
            $content = $this->replace_between($file,'###allowedFields###','###\allowedFields###',$allow_fields);
            if(count($_allow_relations)){
                $content = $this->replace_between($content,'###allowedIncludes###','###\allowedIncludes###',$allow_relations);
            }

            File::put($path,$content);
            $allows = collect([]);
        }

        return true;
    }
    public function replace_between($str, $needle_start, $needle_end, $replacement) {
        $pos = strpos($str, $needle_start);
        $start = $pos === false ? 0 : $pos + strlen($needle_start);

        $pos = strpos($str, $needle_end, $start);
        $end = $pos === false ? strlen($str) : $pos;

        return substr_replace($str, $replacement, $start, $end - $start);
    }

    private function getAllowFieldsContent($repo,&$allows){

        $repo_reflection = new \ReflectionClass($repo);

        $this->setFillables($repo_reflection,$allows);

        $this->setRelations($repo_reflection,$allows);
    }

    private function setFillables($reflector, &$allows){
        $repoInstance = $reflector->newInstanceWithoutConstructor();

        $model = $reflector->getMethod('model')->invoke($repoInstance);
        $allows = $allows->merge(array_merge(['id'],(new $model)->getFillable()));
    }

    private function setRelations($reflector, &$allows){


        $nestedRelations = function($repoRelation,$prefix,&$allows){

            $repo_relation_reflection = new \ReflectionClass($repoRelation);

            $repoInstance = $repo_relation_reflection->newInstanceWithoutConstructor();
            $relations = $repo_relation_reflection->getMethod('relations')->invoke($repoInstance);

            foreach($relations as $relation_method => $repoRelation){

                $repo_relation_reflection = new \ReflectionClass($repoRelation);

                $repoRelationInstance = $repo_relation_reflection->newInstanceWithoutConstructor();
                $model = $repo_relation_reflection->getMethod('model')->invoke($repoRelationInstance);

                $fillables = array_merge(['id'],with(new $model)->getFillable());

                array_walk($fillables,function(&$el)use($relation_method,$prefix){
                    $el = $prefix.'.'.$relation_method.'.'.$el;
                });
                $allows =  $allows->merge($fillables);
            }
        };

        $repoInstance = $reflector->newInstanceWithoutConstructor();
        $relations = $reflector->getMethod('relations')->invoke($repoInstance);


        foreach($relations as $relation_method=>$repoRelation){

            $repo_relation_reflection = new \ReflectionClass($repoRelation);

            $repoRelationInstance = $repo_relation_reflection->newInstanceWithoutConstructor();
            $model = $repo_relation_reflection->getMethod('model')->invoke($repoRelationInstance);

            $fillables = array_merge(['id'],with(new $model)->getFillable());

            array_walk($fillables,function(&$el)use($relation_method){
                $el = $relation_method.'.'.$el;
            });
            $allows =  $allows->merge($fillables);

            ($nestedRelations)($repoRelation,$relation_method,$allows);
        }

    }

}
