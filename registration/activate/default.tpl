<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SMB Council</title>
<meta name="keywords" content="small business, medium business, entrepreneurs, finance">
<meta name="description" content="The Small Medium Business council member account activation ({$participantloginData.participant_name} {$participantloginData.participant_surname})">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="21 days">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta property="og:title" content="SMB Council"> 
<meta property="og:image" content="http://www.smbcouncil.org/img/logo.png"> 
<meta property="og:url" content="http://www.smbcouncil.org">
<meta property="og:site_name" content="SMB Council">
<meta property="og:type" content="website">
<meta property="og:description" content="The Small Medium Business council member account activation ({$participantloginData.participant_name} {$participantloginData.participant_surname})">
{include_php file='includes/css.php'}
</head>
<body>
<section class="container">
    <div class="shieldbox">
        <div class="space cf">
            <div class="leftbox">
                <div class="logobox"><a href="/"><img src="/images/logo.png" width="176" height="200" alt="SMB Council" /></a></div>
                <div class="leftwrap">
                    <p>The Small Medium Business council (SMB | council) is an influential voice and advocate for entrepreneurs and small business owners.</p>
                    <p>We focus on securing policies, resources, and educational initiatives that encourage entrepreneurship and small business growth.</p>
                </div>
            </div>
            <div class="rightbox">
                <div class="rightwrap">
                    <h1>Account Activation Completed</h1> <!--<h1>Thank you for Register</h1> /// after submiting the form-->
					Thank you, <em>{$participantloginData.participant_name} {$participantloginData.participant_surname}</em> your account has been activated.</p>
                    <p>You have joined the informative team that will help you grow as an individual as well as a business.</p>
                    <!--<p>You will be the first in line to recieve information and resources that will help your business grow.</p> /// after submiting the form-->					
                </div>
            </div>
        </div>
        <p class="counttxt">Launching in</p>
        <div class="countbox cf" id="edate"></div>
    </div>
	{include_php file='includes/founders.php'}
</section>
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</body>
</html>