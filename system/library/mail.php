<?php
class Mail {
	protected $to;
	protected $from;
	protected $sender;
	protected $subject;
	protected $text;
	protected $html;
	protected $attachments = array();
	public $protocol = 'mail';
	public $hostname;
	public $username;
	public $password;
	public $port = 25;
	public $timeout = 5;
	public $newline = "\n";
	public $crlf = "\r\n";
	public $verp = false;
	public $parameter = '';

	public function setTo($to) {
		$this->to = $to;
	}

	public function setFrom($from) {
		$this->from = $from;
	}

	public function setSender($sender) {
		$this->sender = $sender;
	}

	public function setSubject($subject) {
		$this->subject = $subject;
	}

	public function setText($text) {
		$this->text = $text;
	}

	public function setHtml($html) {
    $this->html .= "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>

        <html>
        <head>
          <title>Thank you for your Order!</title>
        </head>

        <body bgcolor='#f1f1f1' font-size='10px' leftmargin='0' topmargin='0' rightmargin='0' bottommargin='0' marginwidth='0' marginheight='0' style='color:#000000;font-size:11px;line-height:14px;font-family:Verdana, Arial, Helvetica, sans-serif;' >

        <!-- CSS goes in <body style='color:#000000;font-size:11px;line-height:14px;font-family:Verdana, Arial, Helvetica, sans-serif;' > in case contents of <head> is stripped -->

        <style>

        BODY, TD
        {
          color: #000000;
          font-size: 11px;
          line-height: 14px;
          font-family: Verdana, Arial, Helvetica, sans-serif;
          background: ;
        }
        P
        {
          font-size: 12px;
          margin-top: 5px;
          margin-bottom: 10px;
          line-height: 15px;
          font-family: Verdana, Arial, Helvetica, sans-serif;
          color: #333;
        }
        A
        {
          text-decoration: underline;
          color: #8C2323;
        }
        A:hover
        {
          text-decoration: none;
        }
        .announcementTitle
        {
          color: #5F0E1C;
          font-size: 18px;
          font-weight: bold;
          padding-bottom: 5px;
          margin-bottom: 20px;
          border-bottom: 1px solid #D9D9D9;
        }
        .footerText, .footerText A
        {
          color: #FFF;
        }
        .topNote
        {
          display: none;
        }
        .topNote A
        {
          color: #3D3D3D;
        }
        
        .serialTable {  padding: 5px; font-size: 1.2em; font-weight: bold; background-color: white; }
        .serialNotice { font-size: 12px; font-weight: bold; }
        
        .serialNum { font-weight: bold; color: #5F0E1C; font-size:16px; }
        .keyCode { font-weight: bold; color: #5F0E1C; font-size:16px; }
        </style>

        <!-- The entire email is wrapped in a table to make sure the background color is displayed if it's stripped from the body tag -->

        <table width='100%' bgcolor='#f1f1f1' cellpadding='0' cellspacing='0'>
        <tr>
        <td valign='top' align='center' style='color:#000000;font-size:11px;line-height:14px;font-family:Verdana, Arial, Helvetica, sans-serif;' >

          <!-- Header table -->

          <table align='center' width='600' cellspacing='0' cellpadding='0' border='0' bgcolor='#400000;'>
          <tr>
            <td style='color:#000000;font-size:11px;line-height:14px;font-family:Verdana, Arial, Helvetica, sans-serif;' ><img src='http://www.1099-etc.com/wp-content/uploads/2014/09/emailheader.png' alt='Advanced Micro Solutions - Customer Support Announcement' width='600' height='197'></td>
          </tr>
          </table>

          <!-- Content table -->

          <table width='600' cellspacing='0' cellpadding='0' border='0' bgcolor='ffffff'>
          <tr>
            
            <td width='600' valign='top' style='color:#000000;font-size:11px;line-height:14px;font-family:Verdana, Arial, Helvetica, sans-serif; padding:5px; margin:0;' >

            <br><br>

            <!-- Email Content -->

           
            ";
		$this->html .= $html;
    $this->html .= "


        <br>
</td></tr>
<tr><td>
         <center> <p style='font-size:12px;margin-top:5px;margin-bottom:10px;line-height:15px;font-family:Verdana, Arial, Helvetica, sans-serif;color:#333;' ><p style='font-size:12px;margin-top:5px;margin-bottom:10px;line-height:15px;font-family:Verdana, Arial, Helvetica, sans-serif;color:#333;' >
        Have questions about your order?  Please call us at 800.536.1099 or reply to this email for assistance.

            </p></center>

        <br>
</td></tr>
<tr><td align='center'>
        <table border=0 cellspacing=0 cellpadding=0 width=600 bgcolor='#820024'>



        <tr><td width=10% style='font-size:14px;color:#ffffff;line-height:14px;font-family:Verdana, Arial, Helvetica, sans-serif;' align=center><b>Advanced Micro Solutions, Inc</b><br>1709 S. State Street<br>Edmond, OK 73013<br><br>Sales - 800.536.1099 | Support - 405.340.0697<br>Tax ID: 73-1270820</td></tr>

         
          <tr>
            <td width='600' style='font-size:11px;line-height:14px;font-family:Verdana, Arial, Helvetica, sans-serif;' ><center><span class='footerText' style='color:#ffffff;' >&copy;1985 - &copy;" . date("Y") . " Advanced Micro Solutions, Inc</span></center></td>
            </tr>
         
        </table>
</td></tr>
</table>


          </td>
        </tr>
        </table>

        </body>
        </html>";
	}

	public function addAttachment($filename) {
		$this->attachments[] = $filename;
	}

	public function send() {
		if (!$this->to) {
			trigger_error('Error: E-Mail to required!');
			exit();			
		}

		if (!$this->from) {
			trigger_error('Error: E-Mail from required!');
			exit();					
		}

		if (!$this->sender) {
			trigger_error('Error: E-Mail sender required!');
			exit();					
		}

		if (!$this->subject) {
			trigger_error('Error: E-Mail subject required!');
			exit();					
		}

		if ((!$this->text) && (!$this->html)) {
			trigger_error('Error: E-Mail message required!');
			exit();					
		}
    if($_SERVER['HTTP_HOST'] == 'test.shop.1099-etc.com')
    {
      if(is_array($this->to))
      {
        foreach($this->to as $key=>$value)
        {
          if(strpos($value, '1099-etc.com') === false)
          {
            $this->to[$key] = 'noreply@1099-etc.com';
          }
        }
			  $to = implode(',', $this->to);
      }
      else
      {
        if(strpos($this->to, '1099-etc.com') === false)
        {
          $to = 'noreply@1099-etc.com';
        }
        else
        {
          $to = $this->to;
        }
      }
    }
    else
    {
		  if (is_array($this->to)) {
			  $to = implode(',', $this->to);
		  } else {
			  $to = $this->to;
		  }
    }

		$boundary = '----=_NextPart_' . md5(time());

		$header = '';
		
		$header .= 'MIME-Version: 1.0' . $this->newline;
		
		if ($this->protocol != 'mail') {
			$header .= 'To: ' . $to . $this->newline;
			$header .= 'Subject: ' . $this->subject . $this->newline;
		}
		
		$header .= 'Date: ' . date('D, d M Y H:i:s O') . $this->newline;
		$header .= 'From: ' . '=?UTF-8?B?' . base64_encode($this->sender) . '?=' . '<' . $this->from . '>' . $this->newline;
		$header .= 'Reply-To: ' . '=?UTF-8?B?' . base64_encode($this->sender) . '?=' . '<' . $this->from . '>' . $this->newline;
		$header .= 'Return-Path: ' . $this->from . $this->newline;
		$header .= 'X-Mailer: PHP/' . phpversion() . $this->newline;
		$header .= 'Content-Type: multipart/related; boundary="' . $boundary . '"' . $this->newline . $this->newline;

		if (!$this->html) {
			$message  = '--' . $boundary . $this->newline;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
			$message .= $this->text . $this->newline;
		} else {
			$message  = '--' . $boundary . $this->newline;
			$message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"' . $this->newline . $this->newline;
			$message .= '--' . $boundary . '_alt' . $this->newline;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;

			if ($this->text) {
				$message .= $this->text . $this->newline;
			} else {
				$message .= 'This is a HTML email and your email client software does not support HTML email!' . $this->newline;
			}

			$message .= '--' . $boundary . '_alt' . $this->newline;
			$message .= 'Content-Type: text/html; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
			$message .= $this->html . $this->newline;
			$message .= '--' . $boundary . '_alt--' . $this->newline;
		}

		foreach ($this->attachments as $attachment) {
			if (file_exists($attachment)) {
				$handle = fopen($attachment, 'r');
				
				$content = fread($handle, filesize($attachment));
				
				fclose($handle);

				$message .= '--' . $boundary . $this->newline;
				$message .= 'Content-Type: application/octet-stream; name="' . basename($attachment) . '"' . $this->newline;
				$message .= 'Content-Transfer-Encoding: base64' . $this->newline;
				$message .= 'Content-Disposition: attachment; filename="' . basename($attachment) . '"' . $this->newline;
				$message .= 'Content-ID: <' . basename(urlencode($attachment)) . '>' . $this->newline;
				$message .= 'X-Attachment-Id: ' . basename(urlencode($attachment)) . $this->newline . $this->newline;
				$message .= chunk_split(base64_encode($content));
			}
		}

		$message .= '--' . $boundary . '--' . $this->newline;

		if ($this->protocol == 'mail') {
			ini_set('sendmail_from', $this->from);

			if ($this->parameter) {
				mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header, $this->parameter);
			} else {
				mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header);
			}
		} elseif ($this->protocol == 'smtp') {
			$handle = fsockopen($this->hostname, $this->port, $errno, $errstr, $this->timeout);

			if (!$handle) {
				trigger_error('Error: ' . $errstr . ' (' . $errno . ')');
				exit();					
			} else {
				if (substr(PHP_OS, 0, 3) != 'WIN') {
					socket_set_timeout($handle, $this->timeout, 0);
				}

				while ($line = fgets($handle, 515)) {
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}

				if (substr($this->hostname, 0, 3) == 'tls') {
					fputs($handle, 'STARTTLS' . $this->crlf);

					while ($line = fgets($handle, 515)) {
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}

					if (substr($reply, 0, 3) != 220) {
						trigger_error('Error: STARTTLS not accepted from server!');
						exit();								
					}
				}

				if (!empty($this->username)  && !empty($this->password)) {
					fputs($handle, 'EHLO ' . getenv('SERVER_NAME') . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) {
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}

					if (substr($reply, 0, 3) != 250) {
						trigger_error('Error: EHLO not accepted from server!');
						exit();								
					}

					fputs($handle, 'AUTH LOGIN' . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) {
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}

					if (substr($reply, 0, 3) != 334) {
						trigger_error('Error: AUTH LOGIN not accepted from server!');
						exit();						
					}

					fputs($handle, base64_encode($this->username) . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) {
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}

					if (substr($reply, 0, 3) != 334) {
						trigger_error('Error: Username not accepted from server!');
						exit();								
					}

					fputs($handle, base64_encode($this->password) . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) {
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}

					if (substr($reply, 0, 3) != 235) {
						trigger_error('Error: Password not accepted from server!');
						exit();								
					}
				} else {
					fputs($handle, 'HELO ' . getenv('SERVER_NAME') . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) {
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}

					if (substr($reply, 0, 3) != 250) {
						trigger_error('Error: HELO not accepted from server!');
						exit();							
					}
				}

				if ($this->verp) {
					fputs($handle, 'MAIL FROM: <' . $this->from . '>XVERP' . $this->crlf);
				} else {
					fputs($handle, 'MAIL FROM: <' . $this->from . '>' . $this->crlf);
				}

				$reply = '';

				while ($line = fgets($handle, 515)) {
					$reply .= $line;

					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}

				if (substr($reply, 0, 3) != 250) {
					trigger_error('Error: MAIL FROM not accepted from server!');
					exit();							
				}

				if (!is_array($this->to)) {
					fputs($handle, 'RCPT TO: <' . $this->to . '>' . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) {
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}

					if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) {
						trigger_error('Error: RCPT TO not accepted from server!');
						exit();							
					}
				} else {
					foreach ($this->to as $recipient) {
						fputs($handle, 'RCPT TO: <' . $recipient . '>' . $this->crlf);

						$reply = '';

						while ($line = fgets($handle, 515)) {
							$reply .= $line;

							if (substr($line, 3, 1) == ' ') {
								break;
							}
						}

						if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) {
							trigger_error('Error: RCPT TO not accepted from server!');
							exit();								
						}
					}
				}

				fputs($handle, 'DATA' . $this->crlf);

				$reply = '';

				while ($line = fgets($handle, 515)) {
					$reply .= $line;

					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}

				if (substr($reply, 0, 3) != 354) {
					trigger_error('Error: DATA not accepted from server!');
					exit();						
				}
            	
				// According to rfc 821 we should not send more than 1000 including the CRLF
				$message = str_replace("\r\n", "\n",  $header . $message);
				$message = str_replace("\r", "\n", $message);
				
				$lines = explode("\n", $message);
				
				foreach ($lines as $line) {
					$results = str_split($line, 998);
					
					foreach ($results as $result) {
						if (substr(PHP_OS, 0, 3) != 'WIN') {
							fputs($handle, $result . $this->crlf);
						} else {
							fputs($handle, str_replace("\n", "\r\n", $result) . $this->crlf);
						}							
					}
				}
				
				fputs($handle, '.' . $this->crlf);

				$reply = '';

				while ($line = fgets($handle, 515)) {
					$reply .= $line;

					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}

				if (substr($reply, 0, 3) != 250) {
					trigger_error('Error: DATA not accepted from server!');
					exit();						
				}
				
				fputs($handle, 'QUIT' . $this->crlf);

				$reply = '';

				while ($line = fgets($handle, 515)) {
					$reply .= $line;

					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}

				if (substr($reply, 0, 3) != 221) {
					trigger_error('Error: QUIT not accepted from server!');
					exit();						
				}

				fclose($handle);
			}
		}
	}
}
?>
