<?php

include 'conn.php';


$selected_dest = "";
$gender = "";
$age = "";
$fees = "";
$name = "";
$phone = "";
if (isset($_REQUEST['s']) && isset($_REQUEST['g']) && isset($_REQUEST['a']) && isset($_REQUEST['f']) && isset($_REQUEST['n']) && isset($_REQUEST['p']) ) {
    $selected_dest = $_REQUEST['s'];
    $gender = $_REQUEST['g'];
    $age = $_REQUEST['a'];
    $fees = $_REQUEST['f'];
    $name = $_REQUEST['n'];
    $phone = $_REQUEST['p'];
}

// echo $selected_dest;
// echo $gender;
// echo $age;
// echo $fees;
// echo $name;
// echo $phone;

$age_range = explode('-',$age);
//Age first and last range gen:
$age_fast = reset($age_range) === "51+"?50:(string)reset($age_range);
$age_last = count($age_range) === 1?100:(string)end($age_range);
// echo $age_fast;
// echo $age_last;

$f = explode('-',$fees);
$fees_less = reset($f) === "250+"?250:(string)reset($f);
$fees_more = count($f) === 1?500:(string)end($f);
// echo $fees_less;
// echo $fees_more;

$gen = $gender == "Male"?'M':'F';

$str = "SELECT * FROM guid WHERE guid_gender = '$gen' AND guid_charge > $fees_less AND guid_charge < $fees_more AND guid_age BETWEEN $age_fast and $age_last LIMIT 1";
$obj = new myDbConnect();
$res = mysqli_query($obj->con, $str);

// $res_obj = mysqli_query($dbo_obj->con, $str);
$r = mysqli_fetch_assoc($res);
// echo var_dump($r);

if ($r !== NULL) {

    ?>

                        <div class="guid_result_left">
                            <p>Hi <?php echo $name;?>,<br>Our professional guide <?php echo $r['guid_name'];?> will be your tour guide. <br> <?php echo $gender == "Male"?"He":"She"; ?> will contact you soon.
                            <br><br>Wishing you all the best, Dhaka wonder Team.</p>
                        </div>
                        <div class="guid_result_right" id="#g_res_right">
                            <!-- <p>Md. Robiul. <br> Gender: <br>Male. Age: 54. <br>Charge: 100 BDT/hr <br>Phone: +880111111111</p> -->
                            <p class="guid_result_right"><?php echo $r['guid_name'];?><br> Gender: <?php echo $r['guid_gender'] === 'M'?"Male":"Female";?>.<br>Age: <?php echo $r['guid_age'];?> <br>Charge: <?php echo $r['guid_charge'];?> BDT/hr <br>Phone: <?php echo $r['guid_phone'];?></p>
                        </div>


    <?php
    
}else{
   ?> 
        <div class="guid_result_left">
            <p>As your requirement there are no guide available. Could you please Change the requirement of Age or Gender or Fees. Thanks.</p>
        </div>
   <?php
    
}




?>