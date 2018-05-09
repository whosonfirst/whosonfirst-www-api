<?php

	# https://github.com/defuse/php-encryption
	# https://github.com/defuse/php-encryption/blob/master/docs/classes/Crypto.md

	require_once("defuse-crypto/defuse-crypto.2.2.0.phar");

	use Defuse\Crypto\Crypto;
	
	#################################################################
	
	function crypto_encrypt($data, $secret){
	
		try {
			return Crypto::encryptWithPassword($data, $secret);
		} catch (Exception $e) {
			return null;
		}
	}

	#################################################################
	
	function crypto_decrypt($ciphertext, $secret){

		try {
			return Crypto::decryptWithPassword($ciphertext, $secret);		    
		} catch (Exception $e){
			return null;
		}			
	}
	
	#################################################################
	# the end