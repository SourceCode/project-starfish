<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.mail.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
 /**
 * @access public
 * @var object mail handler
 * @category objects
 */

class stMail 
{
	function sendMail($toEmail, $fromEmail, $fromAddress, $subject, $content) 
	{
		$message = '<html>
			<head>
				<title>' . $subject . '</title>
			</head>
			<body>' . nl2br($content) . '</body>
		</html>';
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "To: " . $toEmail . "\r\n";
		$headers .= "From: " . $fromEmail . " <" . $fromAddress . ">\r\n";
		mail($toEmail, $subject, $message, $headers);
		return true;
	}

}

?>