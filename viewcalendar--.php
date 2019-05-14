<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/default.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .container {
            margin-top:80px;
        }

        th{
            height:30px;
            text-align:center;
            font-weight:700;
        }

        td{
            height:100px;
        }

        .today{
            background:orange;
        }

        th:nth-of-type(7),td:nth-of-type(7){
            color:blue;
        }

        th:nth-of-type(1),td:nth-of-type(1){
            color:red;
        }
    </style>

</head>

<?php
// Set your timezone
date_default_timezone_set('Asia/Tokyo');
// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}
// Check format
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}
// Today
$today = date('Y-m-j', time());
// For H3 title
$html_title = date('Y / m', $timestamp);
// Create prev & next month link     mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
// You can also use strtotime!
// $prev = date('Y-m', strtotime('-1 month', $timestamp));
// $next = date('Y-m', strtotime('+1 month', $timestamp));
// Number of days in the month
$day_count = date('t', $timestamp);
 
// 0:Sun 1:Mon 2:Tue ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
//$str = date('w', $timestamp);
// Create Calendar!!
$weeks = array();
$week = '';
// Add empty cell
$week .= str_repeat('<td></td>', $str);
for ( $day = 1; $day <= $day_count; $day++, $str++) {
     
    $date = $ym . '-' . $day;
     
    if ($today == $date) {
        $week .= '<td class="today"><a href="managetask.php">' . $day.'</a><p class="label">task</p>';
    } else {
        $week .= '<td><a href="managetask.php">' . $day.'</a> <br/>task 1 <br/>task 2 <br/>task 3';
    }
    $week .= '</td>';
     
    // End of the week OR End of the month
    if ($str % 7 == 6 || $day == $day_count) {
        if ($day == $day_count) {
            // Add empty cell
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }
        $weeks[] = '<tr>' . $week . '</tr>';
        // Prepare for new week
        $week = '';
    }
}
?>

<body>
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <!-- side menu -->
            <?php include('./fragments/side-navigation.html');?>

            <!-- main content area -->
            <div class="col-md-10 col-sm-11 display-table-cell valign-top">
                <?php include('./fragments/top-bar.html');?>

                    <!-- Content Section Starts here -->
                    <div id="content">
                   

                   <div class="content-inner">
                   <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
                   <br>
                   <table class="table table-bordered">
                       <tr>
                           <th>S</th>
                           <th>M</th>
                           <th>T</th>
                           <th>W</th>
                           <th>T</th>
                           <th>F</th>
                           <th>S</th>
                       </tr>
           
                       <?php
foreach($weeks as $week){
    echo $week;
}
                       ?>

                   </table>
                   </div>
               </div>
               <!-- Content Section Ends here -->

                <?php include('./fragments/footer.html');?>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/default.js"></script>
</body>

</html>