<?php

	# https://pdfbox.apache.org/2.0/commandline.html

	# wget http://mirrors.sonic.net/apache/pdfbox/2.0.9/pdfbox-app-2.0.9.jar
	# mv pdfbox-app-2.0.9.jar /usr/local/bin/
	# ln -s /usr/local/bin/pdfbox-app-2.0.9.jar /usr/local/bin/pdfbox.jar

	$GLOBALS['java']['bin'] = "/usr/bin/java";
	$GLOBALS['pdfbox']['jar'] = "/usr/local/bin/pdfbox.jar";

	########################################################################

	function pdfbox_commands(){

		return array(
			"ConvertColorspace",
			"Decrypt",
			"Encrypt",
			"ExtractText",
			"ExtractImages",
			"OverlayPDF",
			"PrintPDF",
			"PDFDebugger",
			"PDFMerger",
			"PDFReader",
			"PDFSplit",
			"PDFToImage",
			"TextToPDF",
			"WriteDecodedDoc"
		);
	}

	########################################################################

	function pdfbox_is_valid_command($cmd){

		$valid = pdfbox_commands();
		return in_array($cmd, $valid);
	}

	########################################################################

	function pdfbox_exec($cmd, $args=array()){

		if (! file_exists($GLOBALS['java']['bin'])){
			return array("ok" => 0, "error" => "missing java");
		}

		if (! file_exists($GLOBALS['pdfbox']['jar'])){
			return array("ok" => 0, "error" => "missing pdfbox");
		}

		if (! pdfbox_is_valid_command($cmd)){
			return array("ok" => 0, "error" => "invalid pdfbox command");
		}

		$sh_cmd = array(
			$GLOBALS['java']['bin'],
			"-jar",
			$GLOBALS['pdfbox']['jar'],
			$cmd
		);

		$sh_cmd = array_merge($sh_cmd, $args);

		$sh_cmd = implode(" ", $sh_cmd);
		$esc_cmd = escapeshellcmd($sh_cmd);

		exec($esc_cmd, $out, $ok); 

		if ($ok){
			return array("ok" => 0, "error" => "command failed ({$out})");
		}

		return array("ok" => 1, "output" => $out);
	}

	########################################################################

	# the end