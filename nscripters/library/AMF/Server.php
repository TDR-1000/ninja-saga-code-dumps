<?php

    require_once __DIR__.'/OutputStream.php';
    require_once __DIR__.'/InputStream.php';
    require_once __DIR__.'/Message.php';
    require_once __DIR__.'/Const.php';
    require_once __DIR__.'/InvalidAMFException.php';
 

    /**
     * AMF Server
     * 
     * This is the AMF0/AMF3 Server class. Use this class to construct a gateway for clients to connect to 
     * 
     * @package SabreAMF 
     * @version $Id: Server.php 233 2009-06-27 23:10:34Z evertpot $
     * @copyright Copyright (C) 2006-2009 Rooftop Solutions. All rights reserved.
     * @author Evert Pot (http://www.rooftopsolutions.nl/) 
     * @licence http://www.freebsd.org/copyright/license.html  BSD License (4 Clause)
     * @uses NScripters_OutputStream
     * @uses NScripters_InputStream
     * @uses NScripters_Message
     * @uses NScripters_Const
     * @example ../examples/server.php
     */
    class NScripters_Server {

        /**
         * amfInputStream 
         * 
         * @var NScripters_InputStream
         */
        protected $amfInputStream;
        /**
         * amfOutputStream 
         * 
         * @var NScripters_OutputStream
         */
        protected $amfOutputStream;

        /**
         * The representation of the AMF request
         * 
         * @var NScripters_Message
         */
        protected $amfRequest;

        /**
         * The representation of the AMF response
         * 
         * @var NScripters_Message
         */
        protected $amfResponse;

        /**
         * Input stream to read the AMF from
         * 
         * @var NScripters_Message
         */
        static protected $dataInputStream = 'php://input';

        /**
         * Input string to read the AMF from
         * 
         * @var NScripters_Message
         */
        static protected $dataInputData = '';

        /**
         * __construct 
         * 
         * @return void
         */
        public function __construct() {

            $data = $this->readInput();

            //file_put_contents($dump.'/' . md5($data),$data);

            $this->amfInputStream = new NScripters_InputStream($data);
           
            $this->amfRequest = new NScripters_Message();
            $this->amfOutputStream = new NScripters_OutputStream();
            $this->amfResponse = new NScripters_Message();
            
            $this->amfRequest->deserialize($this->amfInputStream);

        }

        /**
         * getRequests 
         * 
         * Returns the requests that are made to the gateway.
         * 
         * @return array 
         */
        public function getRequests() {

            return $this->amfRequest->getBodies();

        }

        /**
         * setResponse 
         * 
         * Send a response back to the client (based on a request you got through getRequests)
         * 
         * @param string $target This parameter should contain the same as the 'response' item you got through getRequests. This connects the request to the response
         * @param int $responsetype Set as either NScripters_Const::R_RESULT or NScripters_Const::R_STATUS, depending on if the call succeeded or an error was produced
         * @param mixed $data The result data
         * @return void
         */
        public function setResponse($target,$responsetype,$data) {


            switch($responsetype) {

                 case NScripters_Const::R_RESULT :
                        $target = $target.='/onResult';
                        break;
                 case NScripters_Const::R_STATUS :
                        $target = $target.='/onStatus';
                        break;
                 case NScripters_Const::R_DEBUG :
                        $target = '/onDebugEvents';
                        break;
            }
            return $this->amfResponse->addBody(array('target'=>$target,'response'=>'','data'=>$data));

        }

        /**
         * sendResponse 
         *
         * Sends the responses back to the client. Call this after you answered all the requests with setResponse
         * 
         * @return void
         */
        public function sendResponse() {

            header('Content-Type: ' . NScripters_Const::MIMETYPE);
            $this->amfResponse->setEncoding($this->amfRequest->getEncoding());
            $this->amfResponse->serialize($this->amfOutputStream);
            echo($this->amfOutputStream->getRawData());

        }

        /**
         * addHeader 
         *
         * Add a header to the server response
         * 
         * @param string $name 
         * @param bool $required 
         * @param mixed $data 
         * @return void
         */
        public function addHeader($name,$required,$data) {

            $this->amfResponse->addHeader(array('name'=>$name,'required'=>$required==true,'data'=>$data));

        }

        /**
         * getRequestHeaders
         *
         * returns the request headers
         *
         * @return void
         */
        public function getRequestHeaders() {
            
            return $this->amfRequest->getHeaders();

        }

        /**
         * setInputFile
         *
         * returns the true/false depended on wheater the stream is readable
         *
         * @param string $stream New input stream
         *
         * @author Asbjørn Sloth Tønnesen <asbjorn@lila.io>
         * @return bool
         */
        static public function setInputFile($stream) {

            if (!is_readable($stream)) return false;

            self::$dataInputStream = $stream;
            return true;

        }

        /**
         * setInputString
         *
         * Returns the true/false depended on wheater the string was accepted.
         * That a string is accepted by this method, does NOT mean that it is a valid AMF request.
         *
         * @param string $string New input string
         *
         * @author Asbjørn Sloth Tønnesen <asbjorn@lila.io>
         * @return bool
         */
        static public function setInputString($string) {

            if (!(is_string($string) && strlen($string) > 0))
                throw new NScripters_InvalidAMFException();

            self::$dataInputStream = null;
            self::$dataInputData = $string;
            return true;

        }

        /**
         * readInput
         *
         * Reads the input from stdin unless it has been overwritten
         * with setInputFile or setInputString.
         *
         * @author Asbjørn Sloth Tønnesen <asbjorn@lila.io>
         * @return string Binary string containing the AMF data
         */
        protected function readInput() {

            if (is_null(self::$dataInputStream)) return self::$dataInputData;

            $data = file_get_contents(self::$dataInputStream);
            if (!$data) throw new NScripters_InvalidAMFException();

            return $data;

        }

    }


