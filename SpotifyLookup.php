<?php
/**
 * @file SpotifyLookup.php
 * User: James Irving-Swift
 * On behalf of: Holiday Lettings Ltd
 * Date: 26/02/2014
 * Time: 07:23
 */

namespace SpotifyLib;

require "SpotifyMethod.php";

class SpotifyLookup implements SpotifyMethod {

    /**
     * @var $api    /SpotifyLib/SpotifyApi  api Class to use
     *
     */
    private $api;

    /**
     * @var $uri  String            string of item you want to lookup
     */
    private $uri;

    /**
     * @var $result stdClass        the result from the api
     */
    private $result;

    /**
     * @var $resultInfo stdClass    the info part of the response
     */
    private $resultInfo;

    /**
     * @var $resultType String      the type of result we get back
     */
    private $resultType;

    /**
     * @param SpotifyApi $api       Injection of SpotifyApi
     * @param string $apiVersion    version number of the api you want to use
     */
    public function __construct(SpotifyApi $api, $apiVersion = "1"){
        $this->setApi($api);
        $this->getApi()->setApiVersion($apiVersion);

    }

    /**
     * Setter for private var api
     *
     * @param SpotifyApi $api    instance of the spotify api class
     * @return SpotifySearch    this instance of this class
     */
    public function setApi(SpotifyApi $api)
    {
        $this->api = $api;

        return $this;
    }

    /**
     * Getter for private var api
     *
     * @return SpotifyApi
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Setter for private var uri
     *
     * @param $uri string       artist to search for
     * @return SpotifySearch     this instance of this class
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Getter for private var uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Setter for private var result
     *
     * @param $result \stdClass
     * @return SpotifyLookup this instance of this class
     */
    public function setResult(\stdClass $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Getter for private var result
     *
     * @return \stdClass
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Setter for private var resultInfo
     *
     * @param resultInfo \SpotifyLib\stdClass
     * @return SpotifyLookup                    this instance of this class
     */
    public function setResultInfo($resultInfo)
    {
        $this->resultInfo = $resultInfo;

        return $this;
    }

    /**
     * Getter for private var resultInfo
     *
     * @return \SpotifyLib\stdClass
     */
    public function getResultInfo()
    {
        return $this->resultInfo;
    }

    /**
     * Setter for private var resultType
     *
     * @param $resultType String
     * @return SpotifyLookup        this instance of this class
     */
    public function setResultType($resultType)
    {
        $this->resultType = $resultType;

        return $this;
    }

    /**
     * Getter for private var resultType
     *
     * @return String
     */
    public function getResultType()
    {
        return $this->resultType;
    }

    /**
     * search
     *
     * @param string $uri (optional)
     */
    public function search( $uri = '' ) {

        if ( $uri !== '') {
            $this->setUri($uri);
        }

        $this->getApi()->getCurl()->setEndPoint('.json');
        $this->getApi()->getCurl()->addParam('uri',$this->getUri());
        $this->getApi()->getCurl()->call();

        $response = $this->getApi()->getCurl()->getResponse();

        if ( $response instanceof \stdClass && property_exists($response,'info')) {

            $this->setResultInfo($response->info);
            $this->setResultType($this->getResultInfo()->type);
            $this->setResult( $response->{$this->getResultType()} );

        }

    }

} 