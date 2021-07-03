<?php
/*
* Smarty plugin
* -------------------------------------------------------------
* Type: function
* Name: date_diff
* Version: 2.0
* Date: June 22, 2008
* Author: Matt DeKok
* Purpose: factor difference between two dates in days, weeks,
*          or years
* Input: date1 = "mm/dd/yyyy" or "yyyy/mm/dd" or "yyyy-mm-dd"
*        date2 = "mm/dd/yyyy" or "yyyy/mm/dd" or "yyyy-mm-dd" or $smarty.now
*        assign = name of variable to assign difference to
*        interval = "days" (default), "weeks", "years"
* Examples: {date_diff date1="5/12/2003" date2=$smarty.now interval="weeks"}
*           {date_diff date1="5/12/2003" date2="5/10/2008" assign="diff"}{$diff}
* -------------------------------------------------------------
*/
function smarty_function_hour_diff($params, &$smarty) {
   $assign = null;
   $interval = "days";
   
   extract($params);
   
	$hours =  round((strtotime($enddate) - strtotime($startdate))/(60*60));
	
   if($assign != null) {
      $smarty->assign($assign,$hours);
   } else {
      return $hours;
   }
}
?> 