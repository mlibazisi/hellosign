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

use Interfaces\ContainerInterface;
use Exceptions\AppException;

/**
 * App Service and Config container
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
class ContainerService implements ContainerInterface
{

    use \Helpers\Traits\FunctionTrait;

    /**
     * Container
     *
     * @var array
     *
     */
    private $_vars = [];

    /**
     * Fetch item from container
     *
     * @param string $key       The key of the item to fetch
     * @param mixed  $default   Value to return if key is not found
     * @param bool   $required  Required, so throw exception if it is not found
     *
     * @throws AppException
     *
     * @return mixed
     */
    public function get( $key, $default = NULL, $required = TRUE ) {

        if ( !isset(
            $this->_vars[ $key ]
        ) ) {

            if ( $required ) {
                throw new AppException( 'ContainerService failed to load: ' . $key );
            }

            return $default;

        }

        return $this->_vars[ $key ];

    }

    /**
     * Add an item to the container
     *
     * @param string $key       The key of the item
     * @param string $value     The value of the item
     *
     * @return void
     */
    public function set( $key, $value ) {

        $this->_vars[ $key ] = $value;

    }

    /**
     * Merge items into the container
     *
     * @param array $vars Vars to merge in
     *
     * @return void
     */
    public function merge( array $vars ) {

        $this->_vars = $this->arrayMerge(
            $this->_vars,
            $vars
        );

    }

}