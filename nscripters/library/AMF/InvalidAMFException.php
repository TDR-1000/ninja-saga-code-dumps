<?php

    /**
     * NScripters_InvalidAMFException
     * 
     * @package SabreAMF
     * @version $Id: $
     * @copyright Copyright (C) 2006-2009 Rooftop Solutions. All rights reserved.
     * @author Asbjørn Sloth Tønnesen <asbjorn@lila.io>
     * @licence http://www.freebsd.org/copyright/license.html  BSD License (4 Clause) 
     */

    /**
     * Detailed exception 
     */
    require_once __DIR__.'/DetailException.php';

    /**
     * In valid AMF exception
     *
     * @uses NScripters_DetailException
     */
    class NScripters_InvalidAMFException extends Exception implements NScripters_DetailException {

		/**
		 *	Constructor
		 */
		public function __construct() {
			// Specific message to ClassException
			$this->message = "No valid AMF request received";
			$this->code = "Server.Processing";

			// Call parent class constructor
			parent::__construct( $this->message );
		}

        public function getDetail() {

            return "Please check that you are calling this page with Flash and AMF.";

        }

    }

?>
