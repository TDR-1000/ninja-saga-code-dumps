<?php

    require_once __DIR__.'/ITypedObject.php'; 
 
    /**
     * NScripters_RecordSet
     * 
     * @uses NScripters_ITypedObject
     * @uses Countable
     * @package SabreAMF 
     * @version $Id: RecordSet.php 233 2009-06-27 23:10:34Z evertpot $
     * @copyright Copyright (C) 2006-2009 Rooftop Solutions. All rights reserved.
     * @author Evert Pot (http://www.rooftopsolutions.nl/) 
     * @licence http://www.freebsd.org/copyright/license.html  BSD License (4 Clause)
     */
    abstract class NScripters_RecordSet implements NScripters_ITypedObject, Countable {


        /**
         * getData 
         * 
         * @return array 
         */
        abstract public function getData(); 

        /**
         * getColumnNames 
         * 
         * @return array 
         */
        abstract public function getColumnNames();

        /**
         * getAMFClassName 
         * 
         * @return string 
         */
        final public function getAMFClassName() {

            return 'RecordSet';

        }

        /**
         * getAMFData 
         * 
         * @return object 
         */
        public function getAMFData() {

            return (object)array(
                'serverInfo' => (object)array(
                    'totalCount'  => $this->count(),
                    'initialData' => $this->getData(),
                    'cursor'      => 1,
                    'serviceName' => false,
                    'columnNames' => $this->getColumnNames(),
                    'version'     => 1,
                    'id'          => false,
                )
            );


        }

    }




