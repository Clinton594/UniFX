<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function sendMail($from, $subject, $receiver, $message)
{
// Load Composer's autoloader
    require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
    $mail->SMTPKeepAlive = true;
    $mail->SMTPDebug = 2;// Set mailer to use SMTP
    $mail->Host       = 'uniquefxcapital.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $from;                     // SMTP username
    $mail->Password   = 'uni@2021?';                               // SMTP password
    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($from);
    $mail->addAddress($receiver);     // Add a recipient
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="format-detection" content="telephone=no" /></head><body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"><center style="background-color:#E1E1E1;"><table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;"><tr><td align="center" valign="top" id="bodyCell"><table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer"><tr><td align="center" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="30" cellspacing="0" width="100%"><tr><td align="center" valign="top" class="textContent"><h1 style="color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:35px;font-weight:normal;margin-bottom:5px;text-align:center;"><img src="http://uniquefxcapital.com/images/logo.png" width="200px"></h1> <h4 style="text-align:center;font-weight:normal;font-family:Helvetica,Arial,sans-serif;font-size:23px;margin-bottom:10px;color:#FFFFFF;line-height:135%;"></h4><div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#FFFFFF;line-height:135%;"></div></td></tr></table></td></tr></table></td></tr></table></td><tr mc:hideable><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer"><tr><td valign="top" width="500" class="flexibleContainerCell"><table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="left" valign="top" class="flexibleContainerBox"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 100%;"><tr><td align="left" class="textContent"><h3 style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">'.$subject.'</h3><div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">'.$message.'</div></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr style="padding-top:0;"><td align="center" valign="top"><table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer"><tr><td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="0" cellspacing="0" width="50%" class="emailButton" style="background-color: #272c33;"><tr></tr></table></td></tr></table></td></tr></table</td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer"><tr><td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell"><table align="left" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer"><tr><td align="left" valign="top" class="textContent"><div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:135%;"></div></td></tr></table></td></tr></table></td></tr></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer"><tr><td align="center" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="30" cellspacing="0" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" class="textContent"><div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">This is an automated Email. Please do not reply to this mail.<br>For further enquiries please chat us up</div></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer"><tr><td align="center" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="30" cellspacing="0" width="100%"><tr><td valign="top" bgcolor="#E1E1E1"><div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;"><div>Copyright &#169; 2021 <a href="https://www.uniquefxcapital.com" target="_blank" style="text-decoration:none;color:#828282;"><span style="color:#828282;">Uniquefxcapital</span></a>. All&nbsp;rights&nbsp;reserved.</div><div>If you do not want to receive emails from us, you can <a href="#" target="_blank" style="text-decoration:none;color:#828282;"><span style="color:#828282;">unsubscribe</span></a>.</div></div></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></center></body></html>';
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}


if (isset($_POST['send'])) {
    sendMail($_POST['from'],$_POST['subject'],$_POST['to'],$_POST['message']);
}

?>