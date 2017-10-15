<?php

    /**
     * NScripters_UndefinedMethodException
     * 
     * @package SabreAMF
     * @version $Id: UndefinedMethodException.php 233 2009-06-27 23:10:34Z evertpot $
     * @copyright Copyright (C) 2006-2009 Rooftop Solutions. All rights reserved.
     * @author Evert Pot (http://www.rooftopsolutions.nl/) 
     * @author Renaun Erickson (http://renaun.com/blog)
     * @licence http://www.freebsd.org/copyright/license.html  BSD License (4 Clause) 
     */

    /**
     * Detailed Exception interface
     *
     * @uses NScripters_DetailException
     */
    require_once __DIR__.'/DetailException.php';

    /**
     * This is the receipt for UndefinedMethodException and default values reflective of ColdFusion RPC faults
     */
    class NScripters_UndefinedMethodException extends Exception Implements NScripters_DetailException {

    	/**
    	 *	Constructor
    	 */
    	public function __construct( $class, $method ) {
    		// Specific message to MethodException
    		$this->message = "Undefined method '$method' in class $class";
    		$this->code = "Server.Processing";

    		// Call parent class constructor
    		parent::__construct( $this->message );
    		
    	}

        public function getDetail() {

            return "Check to ensure that the method is defined, and that it is spelled correctly.";

        }


    }

?>
