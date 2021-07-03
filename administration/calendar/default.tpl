<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMB COUNCIL</title>
{include_php file='administration/includes/css.php'}
{include_php file='administration/includes/javascript.php'} 
</head>

<body>
<!-- Start Main Container -->
<div id="container">

    <!-- Start Content Section -->
  <div id="content">
    {include_php file='administration/includes/header.php'}
	<div id="breadcrumb">
        <ul>
            <li><a href="/administration/" title="Home">Home</a></li>
			<li><a href="/administration/calendar/" title="Calendar">Calendar</a></li>
        </ul>
	</div><!--breadcrumb--> 	
  <div class="inner">  
   <h2>Manage Calendar</h2>	

  <div class="section">
  	<a href="/administration/calendar/view/" title="Manage Schedules"><img src="/administration/images/users.gif" alt="Manage Schedules" height="50" width="50" /></a>
  	<a href="/administration/calendar/view/" title="Manage Schedules" class="title">Manage  Schedules</a>
  </div>
  <div class="section mrg_left_50">
  	<a href="/administration/calendar/types/" title="Manage Schedule Types"><img src="/administration/images/projects.gif" alt="Manage Schedule Types" height="50" width="50" /></a>
  	<a href="/administration/calendar/types/" title="Manage Schedule Types" class="title">Manage Schedule Types</a>
  </div>
  <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
	
 {include_php file='administration/includes/footer.php'}


</div>
<!-- End Main Container -->
</body>
</html>
