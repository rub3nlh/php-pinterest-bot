<?php

namespace seregazhuk\PinterestBot\Helpers;

class CsrfHelper
{
    const TOKEN_NAME = 'csrftoken';
    const DEFAULT_TOKEN = '1234';
    /**
     * Get a CSRF token from the given cookie file
     *
     * @param string $file
     * @return string|null
     */
    public static function getTokenFromFile($file)
    {
        if ( ! file_exists($file)) {
            return null;
        }

        foreach (file($file) as $line) {

            if ($token = self::_parseLineForToken($line)) {
                return $token;
            }
        }

        return null;
    }

    /**
     * @param string $line
     * @return bool
     */
    protected static function _parseLineForToken($line)
    {
        if (empty(strstr($line, self::TOKEN_NAME))) {
            return false;
        }

        preg_match('/'.self::TOKEN_NAME.'\s(\w*)/', $line, $matches);
        if ( ! empty($matches)) {
            return $matches[1];
        }

        return false;
    }

    public static function getDefaultCookie()
    {
        return 'Cookie: csrftoken='.CsrfHelper::DEFAULT_TOKEN.';';
    }

}
