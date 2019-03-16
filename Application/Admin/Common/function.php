<?php
function getDaysByMonth($unix)
{
  $month = date('m', $unix);
  $year = date('Y', $unix);
  $nextMonth = (($month + 1) > 12) ? 1 : ($month + 1);
  $year = ($nextMonth > 12) ? ($year + 1) : $year;
  $days = date('d', mktime(0, 0, 0, $nextMonth, 0, $year));
  return $days;
}

function cal_totaldays($start_time,$end_time)
{
  return intval((strtotime($end_time)-strtotime($start_time))/3600/24)+1;
}