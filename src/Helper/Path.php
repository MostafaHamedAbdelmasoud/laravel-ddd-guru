<?php

namespace MostafaHamed\DDD\Helper;

use MostafaHamed\DDD\Helper\Make\Types\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Path
{
    /**
     * Retrive the path relative to Common directory
     *
     * @param params ...$relatives
     * @return string
     */

    public static function toCommon(...$relatives): string
    {
        return self::build(app_path('Common'), ...$relatives);
    }

    /**
     * Retrive the path relative to Infrastructure directory
     *
     * @param params ...$relatives
     * @return string
     */
    public static function toInfrastructure(...$relatives): string
    {
        return self::build(app_path('Infrastructure'), ...$relatives);
    }

    /**
     * Retrive the path relative to Interfaces directory
     *
     * @param params ...$relatives
     * @return string
     */
    public static function toInterfaces(...$relatives): string
    {
        return self::build(app_path('Interfaces'), ...$relatives);
    }

    /**
     * Retrive the path relative to Domain directory
     *
     * @param string $name domain name
     * @param params ...$relatives
     * @return string
     */
    public static function toDomain($name = '', ...$relatives): string
    {
        return self::build(app_path('Domain'), $name, ...$relatives);
    }

    /**
     * Get path to current package
     *
     * @return string
     */
    public static function package()
    {
        return Str::before(__DIR__, 'src');
    }

    /**
     * Return full path based on inputs
     *
     * @param Array ...$names
     * @return string
     */
    public static function build(...$names): string
    {
        $isLinux = false;
        if (strpos($names[0], DIRECTORY_SEPARATOR) === 0) {
            $isLinux = true;
        }
        $path = join(DIRECTORY_SEPARATOR, ArrayFormatter::trim($names, DIRECTORY_SEPARATOR));
        if ($isLinux) $path = DIRECTORY_SEPARATOR . $path;
        return $path;
    }

    public static function files(...$dir): array
    {

        $path = Path::build(base_path(), ...$dir);

        if (!File::isDirectory($path)) {
            throw new \Exception($path . ' Not found');
        }

        $files = File::files($path);

        $files = collect($files)->map(function ($file) {
            return pathinfo($file, PATHINFO_FILENAME);
        })->toArray();

        return $files;
    }

    public static function directories(...$dir): array
    {
        $path = Path::build(base_path(), ...$dir);

        if (!File::isDirectory($path)) {
            throw new \Exception($path . ' Not found');
        }

        $directories = File::directories($path);

        array_walk($directories, function (&$el) {
            $el = basename($el);
        });

        return $directories;
    }

    public static function stub(...$names): string
    {

        $full = self::build(
            self::package(),
            'stub',
            join(DIRECTORY_SEPARATOR, ArrayFormatter::trim($names, DIRECTORY_SEPARATOR))
        );

        return $full;
    }

    public static function helper(...$names): string
    {

        $full = self::build(
            self::package(),
            'src',
            'Helper',
            join(DIRECTORY_SEPARATOR, ArrayFormatter::trim($names, DIRECTORY_SEPARATOR))
        );

        return $full;
    }

    public static function getDomains(): array
    {

        $domains = File::directories(app_path('Domain'));

        foreach ($domains as &$domain) {
            $domain = basename($domain);
        }

        return $domains;
    }

    public static function getNameSpaceAndFileName(...$dir): array
    {
        $dirFiles = self::files(...$dir);
        $fileData = [];

        foreach ($dirFiles as $file) {
            array_push($dir, $file);

            array_push($fileData, [
                'nameSpace' => self::build(...$dir),
                'fileName' => $file,
            ]);
            array_pop($dir);
        }

        return $fileData;
    }
}
