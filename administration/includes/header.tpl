<div id="header">
<!-- Start Heading -->
<div id="heading">
	<div id="ct_logo">
	</div>
</div><!-- End Heading -->
{if isset($administratorData)}
<!-- Start Top Nav -->
<div id="topnav"> 
	<ul>
		<li><a href="/administration/" title="Home" {if $page eq 'default.php' or $page eq ''} class="active"{/if}>Home</a></li>
		<li><a href="/administration/participant/" title="Members" {if $page eq 'participant'} class="active"{/if}>Members</a></li>
		<li><a href="/administration/campaign/" title="Campaign" {if $page eq 'campaign'} class="active"{/if}>Campaign</a></li>
		<li><a href="/administration/calendar/" title="Calendar" {if $page eq 'calendar'} class="active"{/if}>Calendar</a></li>
		<li><a href="/administration/communication/" title="communication" {if $page eq 'communication'} class="active"{/if}>Communication</a></li>
	</ul>
</div><!-- End Top Nav -->
{/if}
<div class="clearer"><!-- --></div>
</div><!--header-->
{if isset($administratorData)}
<div class="logged_in">
	<ul>
		<li><a href="/administration/logout.php" title="Logout">Logout</a></li>
	</ul>
</div><!--logged_in-->
{/if}
<br />