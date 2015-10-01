<? 
include('config.php');
include('database.php');
include('setting.php');
error_reporting(E_ERROR);
$output = '';
$month = $_GET['month'];
$year = $_GET['year'];
	
if($month == '' && $year == '') { 
	$time = time();
	$month = date('n',$time);
    $year = date('Y',$time);
}

$date = getdate(mktime(0,0,0,$month,1,$year));
$today = getdate();
$hours = $today['hours'];
$mins = $today['minutes'];
$secs = $today['seconds'];

if(strlen($hours)<2) $hours="0".$hours;
if(strlen($mins)<2) $mins="0".$mins;
if(strlen($secs)<2) $secs="0".$secs;

$days=date("t",mktime(0,0,0,$month,1,$year));
$start = $date['wday']+1;
$name = $date['month'];
$year2 = $date['year'];
$offset = $days + $start - 1;
 
if($month==12) { 
	$next=1; 
	$nexty=$year + 1; 
} else { 
	$next=$month + 1; 
	$nexty=$year; 
}

if($month==1) { 
	$prev=12; 
	$prevy=$year - 1; 
} else { 
	$prev=$month - 1; 
	$prevy=$year; 
}

if($offset <= 28) $weeks=28; 
elseif($offset > 35) $weeks = 42; 
else $weeks = 35; 

$output .= "<table class='cal' cellspacing='1' style='border-collapse: collapse'>
<tr>
	<td colspan='7'>
		<table class='calhead' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='left' width='240' valign='center'>
				$name $year2
			</td>
			<td align='right' width='60' valign='center'>
				<a href='javascript:navigate($prev,$prevy)' title='previous month'><i class='icon-chevron-left'></i></a> 
				<a href='javascript:navigate(\"\",\"\")' title='current month'><i class='icon-circle'></i></a> 
				<a href='javascript:navigate($next,$nexty)' title='next month'><i class='icon-chevron-right'></i></a>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr class='dayhead'>
	<td>Sun</td>
	<td>Mon</td>
	<td>Tue</td>
	<td>Wed</td>
	<td>Thu</td>
	<td>Fri</td>
	<td>Sat</td>
</tr>";

$col=1;
$cur=1;
$next=0;

for($i=1;$i<=$weeks;$i++) { 
	if($next==3) $next=0;
	if($col==1) $output.="<tr class='dayrow'>"; 
  	
	$output.="<td valign='top' onMouseOver=\"this.className='dayover'\" onMouseOut=\"this.className='dayout'\">";

	if($i <= ($days+($start-1)) && $i >= $start) {
		if ($friendly_urls == 1) {
		$output.="<div class='day'><a href='date-".$cur."-".$month."-".$year."_page1'><b";
		} else {
		$output.="<div class='day'><a href='items_by_date.php?date=".$cur."-".$month."-".$year."&page=1'><b";
		}

		if(($cur==$today[mday]) && ($name==$today[month])) $output.=" class='today'";

		$output.=">$cur</b></a></div></td>";

		$cur++; 
		$col++; 
		
	} else { 
		$output.="</td>"; 
		$col++; 
	}  
	    
    if($col==8) { 
	    $output.="</tr>"; 
	    $col=1; 
    }
}

$output.="</table>";
  
echo $output;

?>
