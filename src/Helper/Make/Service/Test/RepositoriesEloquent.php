<?php

namespace MostafaHamed\DDD\Helper\Make\Service\Test;

use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\Path;
use MostafaHamed\DDD\Helper\Make\Maker;
use Illuminate\Support\Facades\File;
use MostafaHamed\DDD\Helper\Make\Service\Test\Test;

class RepositoriesEloquent extends Test
{
    private $domain;
    private $TestCommand;

    public function __construct(Maker $TestCommand, string $domain)
    {
        $this->domain = $domain;
        $this->repositoriesDirPath = ['App', 'Domain', $domain, 'Repositories', 'Eloquent'];
        $this->repositories = Path::files(...$this->repositoriesDirPath);
        $this->TestCommand = $TestCommand;
    }

    public function generate()
    {
        foreach ($this->repositories as $repository) {
            $repoInstance = $this->instantiateJustCreated($this->repositoriesDirPath, $repository, app());
            $entity = get_class($repoInstance->getmodel());
            $entityName = collect(explode('\\', $entity))->last();

            $placeholders = [
                '{{REPOSITORY}}' => $repository,
                '{{ENTITY}}' => $entityName,
                '{{ENTITY_LC}}' => Str::lower($entityName),
                '{{DOMAIN}}' => $this->domain,
            ];

            $dir = Path::toDomain($this->domain, 'Tests', 'Unit', 'Repositories', 'Eloquent');

            if (!File::isDirectory($dir)) {
                File::makedirectory($dir, 0755, true, true);
            }


            $content = Str::of($this->TestCommand->getStub('repository-eloquent-test'))
                ->replace(array_keys($placeholders), array_values($placeholders));

            $classFullName = $repository . 'Test';

            $this->TestCommand->save($dir, $classFullName, 'php', $content);
        }
    }
}
