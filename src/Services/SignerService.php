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

use Constants\AppConstants;
use Constants\ConfigConstants;
use Constants\ServiceConstants;
use Exceptions\AppException;
use Interfaces\SignerInterface;
use Interfaces\ContainerInterface;
use HelloSign;

/**
 * The signer class
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
class SignerService implements SignerInterface {

    use \Helpers\Traits\FunctionTrait;

    /**
     * Container
     *
     * @var ContainerInterface
     *
     */
    private $_container;

    /**
     * SignerService constructor
     *
     * @param ContainerInterface $container
     *
     */
    public function __construct( ContainerInterface $container ) {

        $this->_container = $container;

    }

    /**
     * Submit a signature request
     *
     * @param string $name      Signer name
     * @param string $email     Signer email address
     * @param string $file_path File for the signature request.
     *
     * @throws AppException
     *
     * @return bool
     */
    public function sign( $name, $email, $file_path ) {

        if ( !$this->fileExists( $file_path ) ) {
            throw new AppException( 'File not found: ' . $file_path );
        }

        $validate = $this->_container->get(
            ServiceConstants::VALIDATOR
        );

        if ( !$validate->email( $email ) ) {
            throw new AppException( 'Invalid email: ' . $email );
        }

        $url = $this->_container->get(
            ConfigConstants::REPOS_URL
        );

        if ( !$validate->url( $url ) ) {
            throw new AppException( 'Invalid url: ' . $url );
        }

        $repo = $this->_getHighestOpenIssuesRepo( $url );

        if ( !$repo ) {
            throw new AppException( 'No repositories found: ' . $url );
        }

        return $this->_requestSignature( $name, $email, $file_path, $repo );

    }

    /**
     * Get repo with highest open issues
     *
     * @param string $url The url with repos
     *
     * @throws AppException
     *
     * @return array
     */
    private function _getHighestOpenIssuesRepo( $url ) {

        $http_client = $this->_container->get(
            ServiceConstants::HTTP_CLIENT
        );

        $headers[ CURLOPT_USERAGENT ] = $this->_container->get(
            ConfigConstants::USER_AGENT_HEADER
        );

        $http_retries = (int)$this->_container->get(
            ConfigConstants::HTTP_RETRIES,
            FALSE
        );

        $http_retries = ( $http_retries )
            ? $http_retries
            : AppConstants::HTTP_RETRIES;

        $logger = $this->_container->get(
            ServiceConstants::LOGGER
        );

        $repos = [];

        while ( $http_retries > 0 ) {

            try {

                $repos        = $http_client->jsonGet( $url, $headers );
                $http_retries = 0;

            } catch ( AppException $e ) {

                $http_retries--;
                $message = "Failed HTTP request. {$http_retries} Retries left: " . $e->getMessage();
                $logger->log( $message );

                if ( $http_retries == 0 ) {
                    throw new AppException( 'Faiied to submit HTTP Request after max tries' );
                }

            }

        }

        if ( !$repos ) {
            return [];
        }

        $repo_postfix = $this->_container->get(
            ConfigConstants::REPO_POSTFIX
        );

        $postfix_start = (int)$this->strlength( $repo_postfix ) * -1;

        $highest_open_issues = -1;
        $target_repo         = [];

        foreach ( $repos as $repo ) {

            if ( !$this->hasKey( $repo, 'name' )
            || !$this->hasKey( $repo, 'open_issues_count' ) ) {
                continue;
            }

            $needle = $this->substring( $repo['name'], $postfix_start );

            if ( $needle != $repo_postfix ) {
                continue;
            }

            if ( $repo['open_issues_count'] > $highest_open_issues ) {

                $highest_open_issues        = $repo['open_issues_count'];
                $target_repo['name']        = $repo['name'];
                $target_repo['description'] = ( $this->hasKey( $repo, 'description' ) )
                    ? $repo['description']
                    : '';

            }

        }

        return $target_repo;

    }

    /**
     * Submit a signature request
     *
     * @param string $name      The name of signer
     * @param string $email     Email of signer
     * @param string $file_path Path to file
     * @param array $repo       The repo to sign
     *
     * @return array
     */
    private function _requestSignature( $name, $email, $file_path, array $repo ) {

        $api_key = $this->_container->get(
            ConfigConstants::API_KEY
        );

        $client  = $this->_getHelloSignClient( $api_key );
        $request = $this->_getHelloSignRequest();

        $test_mode = (int)$this->_container->get(
            ConfigConstants::TEST_MODE
        );

        if ( $test_mode != 0 ) {
            $request->enableTestMode();
        }

        $request->setTitle( $repo['name'] );

        $email_subject = $this->_container->get(
            ConfigConstants::EMAIL_SUBJECT
        );

        $request->setSubject( $email_subject );
        $request->setMessage( $repo['description'] );
        $request->addSigner( $email, $name );
        $request->addFile( $file_path );

        $response = $client->sendSignatureRequest( $request );

        if ( !$response->hasError() ) {
            return TRUE;
        }

        $logger = $this->_container->get(
            ServiceConstants::LOGGER
        );

        foreach ( $response->getSignatures() as $signature ) {

            $message = 'STATUS: Signature ID: ' .
                $signature->getId() .
                ' Status Code: ' .
                $signature->getStatusCode();
            $logger->log( $message );

        }

        return FALSE;

    }

    /**
     * Load HelloSign client
     *
     * @param string $api_key The api key
     *
     * @throws AppException
     *
     * @return mixed
     */
    private function _getHelloSignClient( $api_key ) {

        $logger = $this->_container->get(
            ServiceConstants::LOGGER
        );

        try {

            return new HelloSign\Client( $api_key );

        } catch ( \Exception $e ) {

            $message = 'Failed to load HelloSign\Client: ' . $e->getMessage();
            $logger->log( $message );
            throw new AppException( $message );

        }

    }

    /**
     * Load HelloSignRequest client
     *
     * @throws AppException
     *
     * @return mixed
     */
    private function _getHelloSignRequest() {

        $logger = $this->_container->get(
            ServiceConstants::LOGGER
        );

        try {

            return new HelloSign\SignatureRequest();

        } catch ( \Exception $e ) {

            $message = 'Failed to load HelloSign\SignatureRequest: ' . $e->getMessage();
            $logger->log( $message );
            throw new AppException($message  );

        }

    }

}