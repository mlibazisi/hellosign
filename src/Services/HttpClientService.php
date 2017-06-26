<?php
/*
 * This file is part of the signer package
 *
 * Copyright (c) 2017 Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Services;

use Interfaces\HttpClientInterface;
use Constants\AppConstants;

/**
 * A cURL based HTTP client
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
class HttpClientService implements HttpClientInterface
{

    use \Helpers\Traits\FunctionTrait;

    /**
     * A set of cURL resources
     *
     * @var array
     */
    private $_handles = [];

    /**
     * Connection timeout in seconds
     *
     * @var int
     */
    const CONNECTION_TIMEOUT = 3;

    /**
     * Submit a GET http request
     *
     * @param string    $url        The url to get
     * @param array     $headers    Optional headers
     *
     * @return mixed
     */
    public function jsonGet( $url, array $headers = [] )
    {

        $handle = $this->_getHandle( $url );

        $this->curlSetOption( $handle, CURLOPT_CRLF, TRUE );
        $this->curlSetOption( $handle, CURLOPT_TIMEOUT, self::CONNECTION_TIMEOUT );
        $this->curlSetOption( $handle, CURLOPT_RETURNTRANSFER, TRUE );

        if ( $headers ) {

            foreach ( $headers as $name => $header ) {
                $this->curlSetOption( $handle, $name, $header );
            }

        }

        $response = $this->curlExecute( $handle );
        $this->curlClose( $handle );

        return $this->jsonDecode( $response );
    }

    /**
     * Make sure the cURL resource is closed
     *
     * @return void
     */
    public function __destruct()
    {

        $handles = $this->_getHandle();

        foreach ( $handles as $handle ) {
            $this->curlClose( $handle );
        }

    }

    /**
     * Init Curl
     *
     * @param string $url The url to open
     *
     * @return mixed
     */
    protected function _getHandle( $url = NULL )
    {

        if ( !$url ) {
            return $this->_handles;
        }

        if ( !isset( $this->_handles[ $url ] )
            || $this->isResource( $this->_handles[ $url ] ) ) {
            $this->_handles[ $url ] = $this->curlInit( $url );
        }

        return $this->_handles[ $url ];

    }


}