<body style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
        <tr>
            <td align="center" valign="top" style="padding:20px 0 20px 0">
                <!-- [ header starts here] -->
                <table bgcolor="FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
                    <tr>
                        <td valign="top">
                           <!-- <a href="{{store url=""}}"><img src="{{var logo_url}}" alt="{{var logo_alt}}" style="margin-bottom:10px;" border="0"/></a> -->
                          </td>
                    </tr>
                <!-- [ middle starts here] -->
                    <tr>
                        <td valign="top">
                            <h1 style="font-size:22px; font-weight:normal; line-height:22px; margin:0 0 11px 0;"">Dear <?php echo $firstname .' '. $lastname;?>,</h1>
                            <p style="font-size:12px; line-height:16px; margin:0 0 16px 0;">An admin user has request to reset your login password, to confirm this action please visit the link below to set your new password.</p>
                            <p style="font-size:12px; line-height:16px; margin:0 0 16px 0;"><a href="<?php echo $url;?>" style="color:#1E7EC8;"><?php echo $url;?></a></p>
                            <p style="font-size:12px; line-height:16px; margin:0;">Please note, if you don't want to change your password, you can ignore this email. </p>
                        </td>
                    </tr>
                    <tr>
					    <td bgcolor="#EAEAEA" align="center" style="background:#EAEAEA; text-align:center;"><center><p style="font-size:12px; margin:0;"><strong><?php echo __(EMAIL_SIGNATURE)?></strong></p></center></td>
					</tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>