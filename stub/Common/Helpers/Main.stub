<?php

use Illuminate\Support\Collection;

/**
 *
 * @param  string $url 'url into admin pages'
 * @return string $url
 */
function aurl(string $url)
{
    return url(config('system.admin.prefix') . $url);
}


/**
 * the image dynamic function
 * @param string $dir           'image directory'
 * @param $image
 * @param $checkFunction
 * @return string
 */
function UploadImages(string $dir, $image, $checkFunction = null) : string
{
    $saveImage = '';

    if (! File::exists(public_path('uploads').'/' . $dir)) { // if file or fiolder not exists
        /**
         *
         * @param $PATH Required
         * @param $mode Defualt 0775
         * @param create the directories recursively if doesn't exists
         */
        File::makeDirectory(public_path('uploads') . '/' . $dir, 0775, true); // create the dir or the
    }

    if (File::isFile($image)) {
        ini_set('memory_limit', '-1');

        $name = $image->getClientOriginalName(); // get image name
        $extension  = $image->getClientOriginalExtension(); // get image extension
        $sha1       = sha1($name); // hash the image name
        $fileName   = rand(1, 1000000) . "_" . date("y-m-d-h-i-s") . "_" . $sha1 . "." . $extension; // create new name for the image

        // if (! is_null($checkFunction)) {
        //     if (!$checkFunction($extension)) {
        //         return false;
        //     }
        // }

        if (checkImages($extension)) {
            $uploadedImage = Image::make($image->getRealPath());
            $uploadedImage->save(public_path('uploads/' . $dir . '/' . $fileName), '100'); // save the image
        } else {
            $image->move(public_path('uploads/' . $dir), $fileName);
        }

        $saveImage = $dir . '/' . $fileName; // get the name of the image and the dir that uploaded in
    }

    return $saveImage;
}

/**
 * Return The Image With Path
 * @param string $image
 * @return string $image
 */
function ShowImage($image, $width = 200, $height = 150) : string
{
    if (! is_null($image) && !empty($image) && File::exists(public_path('uploads').'/' . $image)) {
        return asset('uploads/' . $image);
    }
    return "https://place-hold.it/{$width}x{$height}";
}

/**
 * userCan description
 * @param  string $permission
 * @return bool
 */
function userCan(string $permission) : bool
{
    static $permissions = null;

    if (is_null($permissions)) {
        $permissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
    }

    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    return in_array($permission, $permissions);
}


/**
 * getData
 *
 * gets data from old() and $edit
 */
function getData(Collection $data, $attr)
{
    return $data->has($attr) ? $data[$attr] : null;
}


/**
 * Check Var Value
 *
 * Checks The Empty And Null Vals
 */
 function checkVar($val)
 {
     return !empty($val) && !is_null($val);
 }

 /**
 * isJson
 * @param $args
 * @return boolean
 */
 function isJson($json)
 {
     json_decode($json);
     return (json_last_error()===JSON_ERROR_NONE);
 }

 /**
  * panic
  *
  * throws an exception with the specified message
  *
  * @return Exception
  */
 function panic($msg)
 {
     throw new \Exception($msg);
 }

/**
 * Is Active Function Checks If The Current Menu Link IS Active.
 *
 * @param  mixed   $url
 * @param  boolean $is_parent_menu
 * @return string
 */
function is_active($url, $is_parent_menu = false) : string
{
    if (active_route($url)) {
        return $is_parent_menu ? 'kt-menu__item--submenu kt-menu__item--open kt-menu__item--here' : 'kt-menu__item--active';
    }
    return '';
}

/**
 * Format Enum To VueSelectComponent
 * @param  array $enumValues
 * @return array
 */
function formatEnumToVueComponent(array $enumValues) : string
{
    $return = [];

    foreach ($enumValues as $value) {
        $return[$value] = trans("main.$value");
    }

    return collect($return)->toJson();
}

/**
 * VarByLang
 * @param  any $var
 * @param  string $lang
 * @return string
 */
function VarByLang($var, $lang = null)
{
    if (!checkVar($lang)) {
        $lang = GetLanguage();
    }
    return checkVar($var) ? optional(json_decode($var))->$lang : '';
}

/**
 * Format Model To VueSelectComponent
 * @param  array   $modelToArray
 * @param  string  $key
 * @param  string  $value
 * @param  boolean $is_multi_lang
 * @return string
 */
function formatModelValuesToVueComponent(array $modelToArray, string $key = 'id', string $value = 'name', bool $is_multi_lang = false) : string
{
    $return = [];

    foreach ($modelToArray as $model) {
        $return[$model[$key]] = $is_multi_lang ? VarByLang($model[$value]) : $model[$value];
    }

    return collect($return)->toJson();
}
