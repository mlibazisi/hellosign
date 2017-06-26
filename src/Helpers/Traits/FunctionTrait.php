<?php
/*
 * This file is part of the signer package
 *
 * Copyright (c) 2017 Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Helpers\Traits;

use Exceptions\AppException;

/**
 * Set of utility functions
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
trait FunctionTrait
{

    /**
     * Wrapper for PHP file_exists
     *
     * @param string $filename The file name
     *
     * @return bool
     */
    function fileExists( $filename ) {

        return \file_exists( $filename );

    }

    /**
     * Wrapper for PHP array_merge
     *
     * @param array $arr1 Array 1
     * @param array $arr2 Array 2
     *
     * @return array
     */
    function arrayMerge( array $arr1, array $arr2 ) {

        return array_merge( $arr1, $arr2 );

    }

    /**
     * Wrapper for PHP parse_ini_file
     *
     * @param string $file_path The config file path
     *
     * @throws AppException;
     *
     * @return mixed
     */
    function parseIniFile( $file_path ) {

        if ( !$this->fileExists( $file_path ) ) {
            throw new AppException( 'Config file not found in: ' . $file_path );
        }

        return parse_ini_file( $file_path, true);

    }

    /**
     * Wrapper for PHP error_log
     *
     * @param string $message The message to log
     * @param string $file_path The log file path
     *
     * @return bool
     */
    function errorLog( $message, $file_path ) {

        return \error_log( $message, 3, $file_path );

    }

    /**
     * Wrapper for is_resource
     *
     * @param mixed $resource The resource to test
     *
     * @return bool
     */
    public function isResource( $resource )
    {

        return \is_resource( $resource );

    }

    /**
     * Wrapper for curl_setopt
     *
     * @param resource  $handle Curl handle resource
     * @param string    $name   The option name
     * @param mixed     $value  The option value
     *
     * @return bool true on success , false on failure
     */
    public function curlSetOption( $handle, $name, $value )
    {

        return \curl_setopt( $handle, $name, $value );

    }

    /**
     * Wrapper for json_decode
     *
     * @param string  $string String to decode
     * @param bool    $assoc  Convert to assoc array
     *
     * @return mixed
     */
    public function jsonDecode( $string, $assoc = TRUE )
    {

        return \json_decode( $string, $assoc );

    }

    /**
     * Wrapper for strlen
     *
     * @param string  $string   String to get length
     *
     * @return int
     */
    public function strlength( $string )
    {

        return \strlen( $string );

    }

    /**
     * Makes sure an array key is accessible
     *
     * @param array  $array   The array to test
     * @param string $key     The key to find
     *
     * @return bool
     */
    public function hasKey( &$array, $key )
    {

        return isset( $array[ $key ] );

    }

    /**
     * Wrapper for substr
     *
     * @param string  $string   String to find substr
     * @param int     $start    Beginning to search
     *
     * @return mixed
     */
    public function substring( $string, $start )
    {

        return \substr( $string, $start );

    }

    /**
     * Wrapper for curl_exec
     *
     * @param resource $handle Curl handle resource
     *
     * @return mixed
     */
    public function curlExecute( $handle )
    {

        return \curl_exec( $handle );

    }

    /**
     * Wrapper for curl_init
     *
     * @param string $url Url to open
     *
     * @return mixed
     */
    public function curlInit( $url )
    {

        return \curl_init( $url );

    }

    /**
     * Wrapper for curl_close
     *
     * @param resource  $handle Curl handle resource
     *
     * @return void
     */
    public function curlClose( $handle )
    {

        if ( $this->isResource( $handle ) ) {
            \curl_close( $handle );
        }

    }

}