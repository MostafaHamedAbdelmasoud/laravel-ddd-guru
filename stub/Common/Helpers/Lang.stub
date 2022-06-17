<?php

/**
 * Get The Common Languages.
 *
 * @return array
 */
function AppLanguages() : array
{
    return ['ar', 'en'];
}

/**
 * Get The Common Locale.
 *
 * @return string
 */
function GetLanguage() : string
{
    return app()->getLocale();
}

/**
 * Get's The Site Direction.
 *
 * @return string
 */
function GetDirection() : string
{
    return GetLanguage() == 'ar' ? 'rtl' : 'ltr';
}

/**
 * Get's The Default Language.
 *
 * @return string
 */
function GetDefaultLang() : string
{
    return 'en';
}

/**
 * if design isRtl.
 *
 * @return bool
 */
function isRtl() : bool
{
    return GetLanguage() == 'ar' ? true : false;
}

/**
 * @param $language
 * @param $key
 * @return string
 */
function GetLanguageValues($language, $key) : string
{
    return config('languages.language.'.$language)[$key];
}
