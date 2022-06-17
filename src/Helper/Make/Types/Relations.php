<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use Reflection;
use ReflectionClass;
use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\Path;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\FileCreator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use MostafaHamed\DDD\Helper\Make\Types\Allow;
use MostafaHamed\DDD\Helper\NamespaceCreator;

class Relations extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [];

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

    /**
     * Fill all placeholders in the stub file
     *
     * @param array $values
     * @return boolean
     */
    public function service(array $values = []): bool
    {
        $domains = Path::getDomains();

        $this->fillRelationsFileForEachEntity($domains);
        return true;
    }

    /**
     * Fill Relations file for each file
     *
     * @param Array $domains
     * @return void
     */
    public function fillRelationsFileForEachEntity(array $domains)
    {

        foreach ($domains as $domain) {
            if (!File::isDirectory(Path::build('app', 'Domain', $domain, 'Entities'))) {
                continue;
            }
            $entities = Path::files('App', 'Domain', $domain, 'Entities');
            foreach ($entities as $entity) {
                $relations_stub = [];
                $repo_stubs = [];

                $class = NamespaceCreator::segments('App', 'Domain', $domain, 'Entities', $entity);
                $reflector = new ReflectionClass($class);
                $this->reflectEntitesBelongsTo($reflector, $relations_stub, $repo_stubs);
                $this->reflectEntitesHasMany($reflector, $relations_stub, $repo_stubs);
                $this->reflectEntitesBelongsToMany($reflector, $relations_stub, $repo_stubs);
                $this->reflectEntitesHasOne($reflector, $relations_stub, $repo_stubs);
                $this->reflectEntitesMorphTo($reflector, $relations_stub, $repo_stubs);
                $this->reflectEntitesMorphOne($reflector, $relations_stub, $repo_stubs);
                $this->reflectEntitesMorphMany($reflector, $relations_stub, $repo_stubs);
                $this->reflectEntitesMorphToMany($reflector, $relations_stub, $repo_stubs);
                $this->reflectEntitesMorphedByMany($reflector, $relations_stub, $repo_stubs);

                if (count($relations_stub)) {
                    $relationsNamespace = NamespaceCreator::segments('App', 'Domain', $domain, 'Entities', 'Traits', 'Relations', $entity . 'Relations');
                    $relationReflection = new ReflectionClass($relationsNamespace);
                    $relationFile = File::get($relationReflection->getFileName());
                    $relationContent = join("\n", $relations_stub);
                    $content = $this->replace_between($relationFile, '###allowedRelations###', '###\allowedRelations###', $relationContent);
                    File::put($relationReflection->getFileName(), $content);
                }

                if (count($repo_stubs)) {
                    $relationsRepoNamespace = NamespaceCreator::segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', $entity . 'RepositoryEloquent');
                    $relationRepoReflection = new ReflectionClass($relationsRepoNamespace);
                    $relationRepoFile = File::get($relationRepoReflection->getFileName());

                    $repo_relations = "\n";
                    foreach ($repo_stubs as $relation) {
                        $key = $relation['key'];
                        $value = $relation['rep'];
                        $repo_relations .= "'$key'=> $value,\n";
                    }

                    $content = $this->replace_between($relationRepoFile, '###allowedRelations###', '###\allowedRelations###', $repo_relations);
                    File::put($relationRepoReflection->getFileName(), $content);
                }
            }
        }
    }

    /**
     * Replace String betwwen to atring
     *
     * @param string $str
     * @param string $needle_start
     * @param string $needle_end
     * @param string $replacement
     * @return void
     */
    public function replace_between($str, $needle_start, $needle_end, $replacement)
    {
        $pos = strpos($str, $needle_start);
        $start = $pos === false ? 0 : $pos + strlen($needle_start);

        $pos = strpos($str, $needle_end, $start);
        $end = $pos === false ? strlen($str) : $pos;

        return substr_replace($str, $replacement, $start, $end - $start);
    }

    /**
     * Get class related to belongsTo
     *
     * @param ReflectionClass $reflector
     * @return void
     */
    private function reflectEntitesBelongsTo(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $belongsTo = $reflector->hasProperty('belongsTo');
        if ($belongsTo) {

            $relations = $reflector->getProperty('belongsTo');
            $relations->setAccessible(true);
            $belongsToRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            foreach ($belongsToRelationsData as $class) {
                $classRef =  new \ReflectionClass($class);

                $case = sprintf('
                    public function %s() : BelongsTo{
                        return $this->belongsTo(%s);
                    }
                ', strtolower($classRef->getShortName()), '\\' . $class . '::class');
                array_push($relations_stub, $case);

                $entity = $classRef->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => strtolower($classRef->getShortName()),
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$classRef->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }

    /**
     * Get class related to hasMany
     *
     * @param ReflectionClass $reflector
     * @return void
     */
    private function reflectEntitesHasMany(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $hasMany = $reflector->hasProperty('hasMany');

        if ($hasMany) {
            $relations = $reflector->getProperty('hasMany');
            $relations->setAccessible(true);
            $hasManyRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            foreach ($hasManyRelationsData as $class) {
                $classRef =  new \ReflectionClass($class);
                $case = sprintf('
                    public function %s() : HasMany{
                        return $this->hasMany(%s);
                    }
                ', Naming::tableName($classRef->getShortName()), '\\' . $class . '::class');
                array_push($relations_stub, $case);

                $entity = $classRef->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => Naming::tableName($classRef->getShortName()) . '',
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$classRef->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }

    /**
     * Get class related to BelongsToMany
     *
     * @param ReflectionClass $reflector
     * @param array $relations_stub
     * @param array $repo_stubs
     * @return void
     */
    private function reflectEntitesBelongsToMany(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $belongsToMany = $reflector->hasProperty('belongsToMany');
        if ($belongsToMany) {

            $relations = $reflector->getProperty('belongsToMany');
            $relations->setAccessible(true);
            $belongsToManyRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            foreach ($belongsToManyRelationsData as $class) {
                $classRef =  new \ReflectionClass($class);
                $case = sprintf('public function %s() : BelongsToMany{
                        return $this->belongsToMany(%s);
                    }
                ', strtolower($classRef->getShortName()), '\\' . $class . '::class');
                array_push($relations_stub, $case);

                $entity = $classRef->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => Naming::tableName($classRef->getShortName()) . '',
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$classRef->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }

    /**
     * Get class related to HasOne
     *
     * @param ReflectionClass $reflector
     * @param array $relations_stub
     * @param array $repo_stubs
     * @return void
     */
    private function reflectEntitesHasOne(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $hasOne = $reflector->hasProperty('hasOne');
        if ($hasOne) {

            $relations = $reflector->getProperty('hasOne');
            $relations->setAccessible(true);
            $hasOneRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            foreach ($hasOneRelationsData as $class) {
                $classRef =  new \ReflectionClass($class);

                $case = sprintf('
                    public function %s() : HasOne{
                        return $this->hasOne(%s);
                    }
                ', strtolower($classRef->getShortName()), '\\' . $class . '::class');
                array_push($relations_stub, $case);

                $entity = $classRef->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => strtolower($classRef->getShortName()),
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$classRef->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }

    /**
     * Get class related to MorphTo
     *
     * @param ReflectionClass $reflector
     * @param array $relations_stub
     * @param array $repo_stubs
     * @return void
     */
    private function reflectEntitesMorphTo(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $morphTo = $reflector->hasProperty('morphTo');

        if ($morphTo) {

            $relations = $reflector->getProperty('morphTo');
            $relations->setAccessible(true);
            $morphToRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            if ($morphToRelationsData == true) {

                $case = sprintf('
                    public function %s() : MorphTo{
                        return $this->morphTo();
                    }
                ', strtolower(rtrim($reflector->getShortName(), 'able') . 'able'));
                array_push($relations_stub, $case);

                $entity = $reflector->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => strtolower($reflector->getShortName()),
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$reflector->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }

    /**
     * Get class related to MorphOne
     *
     * @param ReflectionClass $reflector
     * @param array $relations_stub
     * @param array $repo_stubs
     * @return void
     */
    private function reflectEntitesMorphOne(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $morphOne = $reflector->hasProperty('morphOne');
        if ($morphOne) {

            $relations = $reflector->getProperty('morphOne');
            $relations->setAccessible(true);
            $morphOneRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            foreach ($morphOneRelationsData as $class) {
                $classRef =  new \ReflectionClass($class);

                $case = sprintf('
                    public function %s() : MorphOne{
                        return $this->morphOne(%s,"%s");
                    }
                ', strtolower(rtrim($classRef->getShortName(), 'able')), '\\' . $class . '::class', strtolower(rtrim($classRef->getShortName(), 'able') . 'able'));
                array_push($relations_stub, $case);

                $entity = $classRef->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => strtolower($classRef->getShortName()),
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$classRef->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }

    /**
     * Get class related to MorphMany
     *
     * @param ReflectionClass $reflector
     * @param array $relations_stub
     * @param array $repo_stubs
     * @return void
     */
    private function reflectEntitesMorphMany(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $morphMany = $reflector->hasProperty('morphMany');
        if ($morphMany) {

            $relations = $reflector->getProperty('morphMany');
            $relations->setAccessible(true);
            $morphManyRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            foreach ($morphManyRelationsData as $class) {
                $classRef =  new \ReflectionClass($class);

                $case = sprintf('
                    public function %s() : MorphMany{
                        return $this->morphMany(%s,"%s");
                    }
                ', strtolower(rtrim($classRef->getShortName(), 'able')), '\\' . $class . '::class', strtolower(rtrim($classRef->getShortName(), 'able') . 'able'));
                array_push($relations_stub, $case);

                $entity = $classRef->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => strtolower($classRef->getShortName()),
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$classRef->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }

    /**
     * Get class related to MorphToMany
     *
     * @param ReflectionClass $reflector
     * @param array $relations_stub
     * @param array $repo_stubs
     * @return void
     */
    private function reflectEntitesMorphToMany(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $morphToMany = $reflector->hasProperty('morphToMany');
        if ($morphToMany) {

            $relations = $reflector->getProperty('morphToMany');
            $relations->setAccessible(true);
            $morphToManyRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            foreach ($morphToManyRelationsData as $class) {
                $classRef =  new \ReflectionClass($class);

                $case = sprintf('
                    public function %s() : MorphToMany{
                        return $this->morphToMany(%s,"%s");
                    }
                ', strtolower(rtrim($classRef->getShortName(), 'able')), '\\' . $class . '::class', strtolower(rtrim($classRef->getShortName(), 'able') . 'able'));
                array_push($relations_stub, $case);

                $entity = $classRef->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => strtolower($classRef->getShortName()),
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$classRef->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }

    /**
     * Get class related to MorphByMany
     *
     * @param ReflectionClass $reflector
     * @param array $relations_stub
     * @param array $repo_stubs
     * @return void
     */
    private function reflectEntitesMorphedByMany(ReflectionClass $reflector, &$relations_stub, &$repo_stubs)
    {
        $morphByMany = $reflector->hasProperty('morphByMany');
        if ($morphByMany) {

            $relations = $reflector->getProperty('morphByMany');
            $relations->setAccessible(true);
            $morphByManyRelationsData = $relations->getValue($reflector->newInstanceWithoutConstructor());

            foreach ($morphByManyRelationsData as $class) {
                $classRef =  new \ReflectionClass($class);

                $case = sprintf('
                    public function %s() : MorphByMany{
                        return $this->morphByMany(%s,"%s");
                    }
                ', strtolower(rtrim($classRef->getShortName(), 'able')), '\\' . $class . '::class', strtolower(rtrim($classRef->getShortName(), 'able') . 'able'));
                array_push($relations_stub, $case);

                $entity = $classRef->getName();
                $domain = explode('\\', $entity)[2];
                array_push(
                    $repo_stubs,
                    [
                        'key' => strtolower($classRef->getShortName()),
                        'rep' => NamespaceCreator::Segments('App', 'Domain', $domain, 'Repositories', 'Eloquent', "{$classRef->getShortName()}RepositoryEloquent::class"),
                    ]
                );
            }
        }
    }
}
