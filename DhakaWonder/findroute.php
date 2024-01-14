<?php
$current = "Paltan";
$destination = "Sadarghat";
$dest_name = "";
$LEVEL_NOW = 0;
$arrr = array();
$arrr2 = array();
if (isset($_POST['dest'])  && $_POST['curnt'] && $_POST['dest_name'] ) {
    $current = $_POST['dest'];
    $destination = $_POST['curnt'];
    $dest_name = $_POST['dest_name'];
    
    $a = new mySingleLevel($current,$destination);
    if ($a->IS_SINGLE_FOUND === TRUE) {
        $arrr = $a->r;        
        $LEVEL_NOW = 1;
    }else {
        $b = new myDoubleLevel($current,$destination);
        $LEVEL_NOW =2;
        $arrr2 = $b->r;
        if ($b->IS_DOUBLE_FOUND === TRUE) {
            $LEVEL_NOW = 2;
        }else {
            $LEVEL_NOW = 3;

        }
    }
}
/*
    Here, we find last dest name using ' => ' delemeter.
*/
function findLastDelimiter($string, $delimiter) {
    // last ' => ' removed from str route.
    $pos = strrpos($string, $delimiter);
    if ($pos === false) {
      return $string;
    } else {
      return substr($string, $pos + 4);
    }


  }


function makeRouteStringFine($ar, $lastSymble){
    $route_str = "";
    if ($lastSymble === TRUE) {
        foreach ($ar as $i) {
            $route_str .= $i." => ";
        }
    }elseif ($lastSymble === FALSE) {
        $c = count($ar);
        for ($i=0; $i < $c; $i++) { 
            if ($i > $c) {
                break;
            }else {
                $route_str .= $ar[$i]." => ";
            }
        }
    }elseif ($lastSymble === "SIGNLE") {
        $c = count($ar);
        for ($i=0; $i < $c; $i++) { 
            if ($i >= $c) {
                break;
            }else {
                $route_str .= $ar[$i]." => ";
            }
        }


    }
    return $route_str;
}
function reformateStr($ar1,$ar2,$ar3){
    $route_str = "";
    $r_str1 = "";
    $r_str2 = "";
    $r_str3 = "";
    if (count($ar1) > 0) {
        $r_str1 = makeRouteStringFine($ar1, TRUE);
    }
    if (count($ar3) > 0) {
        $r_str3 = makeRouteStringFine($ar3, TRUE);     
    }
    // $route_str = $ar2[0]." => ".$r_str1.$ar2[1].$r_str3." => ".$ar2[2];
    // <!-- <p> <span class="first_d">Amet consectetur</span>    adipisicing elit. Excepturi ipsa Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus, illo odio laudantium officia enim velit natus earum accusamus dicta voluptatem.quia illum tenetur porro sunt, iusto quas  <span class="middle_d">laudantium</span>  repellendus laborum molestias culpa tempora! Sit ullam recusandae in dolore non delectus quidem nostrum vero facere laborum praesentium perspiciatis  <span class="last_d">exercitationem</span></p> -->
    $route_str = "<span class='first_d'>".$ar2[0]."</span>"." => ".$r_str1."<span class='middle_d'>".$ar2[1]."</span>"." => ".$r_str3."<span class='last_d'>".$ar2[2]."</span>";
    return $route_str;
}

function reformateStrForSingle($ar1){
    $route_str = "";
    $r_str1 = "";
    if (count($ar1) > 0) {
        $r_str1 = makeRouteStringFine(array_slice($ar1, 1, -1, true), TRUE);
    }
    $route_str = "<span class='first_d'>".reset($ar1)."</span>"." => ".$r_str1."<span class='last_d'>".end($ar1)."</span>";
    return $route_str;
}




class myFindBegin{
    private $current = "";
    private $destination = "";

    function __construct($d, $c){
        $this->current = $c;
        $this->destination = $d;
    }
    

}

class mySingleLevel{
    function __construct($d, $c){
        $this->d = $d;
        $this->c = $c;
        $this->all_func_obj = new myAllFunction();
        $this->r = $this->begin();
        if (!is_null($this->r)) {
            if (count($this->r) > 0) {
                $this->IS_SINGLE_FOUND = TRUE;
            }else {
                $this->IS_SINGLE_FOUND = FALSE;
                
            }
        }else {
            $this->IS_SINGLE_FOUND = FALSE;
        }


    }
    function begin(){
        $ret_arr = array();
        $bus_list = $this->all_func_obj->getBusIDList($this->d, $this->c);
        if (count($bus_list) > 0) {
            for ($i=0; $i < count($bus_list); $i++) { 
                $b = $this->all_func_obj->getBusNameByID($bus_list[$i]);
                $a = $this->all_func_obj->routeIndexCount($bus_list[$i]);            
                // echo var_dump($b);  
                // echo $b[$i];  
                $res_arr = $this->all_func_obj->singleLevelRouteFind($this->c, $this->d, $a);              
                // echo var_dump($res_str);  
                $ret_arr[$i] = array($b[$i], $res_arr );
                // echo "<br><br><br>";
            }
        }else {
            return [];
            // echo "There is no bus found that has both...";
        }
        // $arrr = $ret_arr;
        return $ret_arr;
    }
    

}
class myDoubleLevel{
    public $r = array();
    function __construct( $c,$d){
        $this->d = $d;
        $this->c = $c; 
        $this->all_func_obj = new myAllFunction();
        $this->r = $this->findStart();
        if (!is_null($this->r)) {
            if (count($this->r) > 0) {
                $this->IS_DOUBLE_FOUND = TRUE;
            }else {
                $this->IS_DOUBLE_FOUND = FALSE;
                
            }
        }else {
            $this->IS_DOUBLE_FOUND = FALSE;
        }
    }
    function findStart(){
        $arr_rec = $this->all_func_obj->doubleLevelRouteFind($this->d, $this->c, $this->all_func_obj);
        // echo var_dump($arr_rec);
        return $arr_rec ;

    }



}

class myAllFunction{   
    
    function __construct(){
        
    }


    function cutArray($ar1, $ar2, $cm, $c, $d,$obj){
    
        $cp = array_search($c, $ar1);
        $cp_f = array_search(reset($cm), $ar1);
        $cp_l = array_search(end($cm), $ar1);
        $cp_small = $cp_f<$cp_l?$cp_f:$cp_l;
        $cp_big = $cp_f>$cp_l?$cp_f:$cp_l;
        $dp = array_search($d, $ar2);
        $dp_f = array_search(reset($cm), $ar2);
        $dp_l = array_search(end($cm), $ar2);
        $dp_small = $dp_f<$dp_l?$dp_f:$dp_l;
        $dp_big = $dp_f>$dp_l?$dp_f:$dp_l;
        $final_array = array();
        // echo $c;
        // echo"<br>";
        // echo $cp;
        // echo" : ";
        // echo $cp_f;
        // echo" : ";
        // echo $cp_l;
        // echo"<br>";
        // echo $d;
        // echo"<br>";
        // echo $dp;
        // echo" : ";
        // echo $dp_f;
        // echo" : ";
        // echo $dp_l;
        // echo"<br>";
        // array_push($final_array,[reset($cm)]);//this line will add common array in between arrays
        if ($cp < $cp_f && $cp < $cp_l && $dp < $dp_f && $dp < $dp_l) {//this line will add first portion of arrays
            //A is ok...
            $temp1 = $obj->cuttOffArray($ar1, $cp+1, $cp_f - $cp-1);
            $temp2 = $obj->cuttOffArray($ar2, $dp+1, $dp_f - $dp-1);
            array_push($final_array,  $temp1);
            array_push($final_array,[$c,reset($cm), $d]);
            array_push($final_array,  array_reverse($temp2));
            // echo "A";
        }else if($cp < $cp_f && $cp < $cp_l && $dp > $dp_f && $dp > $dp_l) {//this line will add first portion of arrays
            //B is ok...
            $temp1 = $obj->cuttOffArray($ar1, $cp+1, $cp_f - $cp-1 );       
            $temp2 = $obj->neededPortion($ar2, $d, reset($cm), 4);
            array_push($final_array,  $temp1);
            array_push($final_array,[$c,reset($cm), $d]);
            array_push($final_array,  $temp2);
            // echo "B";
        }else if ($cp > $cp_f && $cp > $cp_l && $dp < $dp_f && $dp < $dp_l) {//this line will add last portion of arrays
            //C is ok...
            $temp1 = $obj->cuttOffArray($ar1, $cp_l, $cp - $cp_l );       
            $temp2 = $obj->cuttOffArray($ar2, $dp+1, $dp - $dp_f );       
            array_push($final_array,  array_reverse($temp1));
            array_push($final_array,[$c,reset($cm), $d]);
            array_push($final_array,  array_reverse($temp2));
            // echo "C";
        }else if ($cp > $cp_f && $cp > $cp_l && $dp > $dp_f && $dp > $dp_l) {//this line will add last portion of arrays
            //D is ok...
            $temp1 = $obj->neededPortion($ar1, $c, reset($cm), 4);
            $temp2 = $obj->neededPortion($ar2, $d, reset($cm), 4);
            array_push($final_array,  array_reverse($temp1));
            array_push($final_array,[$c,reset($cm), $d]);
            array_push($final_array,  $temp2);
            // echo "D";
        }else {      
            array_push($final_array,  []);
            array_push($final_array,  []);
            // echo "E";
        }
    
        // echo var_dump($final_array);
        // echo var_dump($final_array[1]);
        // echo var_dump($final_array[2]);
        // echo var_dump(count($cm));
        // echo "<br><br>";
        if (count($cm) > 0) {
            if (count($final_array[0]) >0 &&   count($final_array[1]) >0  && count($final_array[2]) >0  ) {
                $compelete_array = array_merge($final_array[0] ,$final_array[1],array_diff($final_array[2],$final_array[1]) );
                if (in_array($c, $compelete_array) && in_array($d,  $compelete_array)   ) {
                    // return $compelete_array;
                    // print_r($compelete_array);
                    // echo var_dump($final_array);
                    return $final_array;
                }else {
                    return FALSE;
                }
            }
            
    
        }else {
            return FALSE;
        }
    
    
    }
    function cuttOffArray($ar, $i, $e){
        $t_array = array_slice($ar, $i, $e);
        return $t_array;
    
    }
    function neededPortion($arr, $cd, $m, $specify){
        
        if ($specify === 4) {// 4 is for c and d is bigger than middle
            $cd_ind = array_search($cd,$arr);
            $m_ind = array_search($m,$arr);
            $m_ind +=1;//mid remove from array
            $big_ind = $cd_ind>$m_ind?$cd_ind:$m_ind;
            $small_ind = $cd_ind<$m_ind?$cd_ind:$m_ind;
            $t_array = array_slice($arr, $small_ind, $big_ind - $small_ind);
            return $t_array;
        }elseif ($specify === 3) {
            $cd_ind = array_search($cd,$arr);
            $m_ind = array_search($m,$arr);
            // $m_ind -3;//mid remove from array
            $big_ind = $cd_ind>$m_ind?$cd_ind:$m_ind;
            $small_ind = $cd_ind<$m_ind?$cd_ind:$m_ind;
            $t_array = array_slice($arr, $small_ind, $big_ind - $small_ind);
            return $t_array;
        }
    }
    function displayBusArray($ar, $a,$b){
        echo "<br>";
        echo "<br> Via ".$a." and $b Bus Service. <br>";
        print_r($ar);
        echo "<br>";
        
        // echo "<br>";
        // echo "<br>";
        // print_r($ar);
        // echo "<br>";
        echo "You will change bus $a to $b on these green bus stopage location.. <br>";
    
        echo "<br>";
    
    }
    // doubleLevelRouteFind($current, $destination);
    function doubleLevelRouteFind($curnt,$dest, $obj){
    
        include_once 'db.php';
        $drt_obj = new dataExtract("route");
    
        $s1 = "(SELECT DISTINCT bus_route.bus_id FROM bus_route WHERE bus_route.route_name LIKE '%$curnt%')
        EXCEPT    
        ((SELECT bus_route.bus_id FROM bus_route WHERE LOWER(bus_route.route_name) LIKE LOWER('%$curnt%')) 
        INTERSECT 
        (SELECT bus_route.bus_id FROM bus_route WHERE LOWER(bus_route.route_name) LIKE LOWER('%$dest%'))) ";
    
        $s2 = "(SELECT DISTINCT bus_route.bus_id FROM bus_route WHERE bus_route.route_name LIKE '%$dest%')
        EXCEPT    
        ((SELECT DISTINCT bus_route.bus_id FROM bus_route WHERE LOWER(bus_route.route_name) LIKE LOWER('%$curnt%')) 
        INTERSECT 
        (SELECT DISTINCT bus_route.bus_id FROM bus_route WHERE LOWER(bus_route.route_name) LIKE LOWER('%$dest%'))) ";
    
        $obj1 = mysqli_query($drt_obj->dbcon->con, $s1);
        $obj2 = mysqli_query($drt_obj->dbcon->con, $s2);
    
        $id_ar1 = [];
        $id_ar2 = [];
        while ($r = mysqli_fetch_assoc($obj1)) {
            array_push($id_ar1, $r['bus_id']);
        }
        while ($r = mysqli_fetch_assoc($obj2)) {
            array_push($id_ar2, $r['bus_id']);
        }
    
        $r1 = array();
        $r2 = array();
        
        static $cn = 0;
        static $bus_count = 0;
        for ($i=0; $i <count($id_ar1); $i++) { 
            // if ($bus_count >=5) {
            //     $bus_count = 0;
            //     break;
            // }
            $r1 = $obj->routeIndexCount($id_ar1[$i]);
            
            $arr_to_return = array();
            // $arr_to_return[0] = TRUE;
            // $arr_to_return[$bus_count][0] = TRUE;
            for ($j=0; $j < count($id_ar2); $j++) { 
                
                // if ($j >=1) {
                //     break;
                // }
                $r2 = $obj->routeIndexCount($id_ar2[$j]);
                $cuttedArray = $obj->cutArray($r1, $r2,  $obj->commonBetweenArray($r1, $r2), $curnt, $dest , $obj);
                // echo var_dump($cuttedArray);
                $b1 = $obj->getBusNameByID($id_ar1[$i] );
                $b2 = $obj->getBusNameByID($id_ar2[$j] );
                if ($cuttedArray !== FALSE) {
                    // if (in_array($curnt, $cuttedArray) && in_array($dest, $cuttedArray) ) {
                        // echo "ki";
                    // $margeArray = array_merge($cuttedArray[0], $cuttedArray[1], array_diff($cuttedArray[2],$cuttedArray[1])     );
                    // // print_r($margeArray);
                    // if ( ( reset($margeArray) == $curnt) && ( end($margeArray) == $dest)  ) {

                    // }else {
                    //     // continue;
                    // } 
                    // array_push($arr_to_return, $cuttedArray[1]);
                    // array_push($arr_to_return, $cuttedArray[2]);
                    if (!is_null($b1[0]) && !is_null($b1[1]) && !is_null($cuttedArray) ) {
                        $arr_to_return[$bus_count][0] = $b1[0];
                        $arr_to_return[$bus_count][1] = $b2[0];
                        $arr_to_return[$bus_count][2] = $cuttedArray;
                        echo is_null($b1[0]);
                        $bus_count++;
                    }
                    // $obj->displayBusArray($cuttedArray, $b1[0],$b2[0]);                    
                    // $obj->justPrintBusRoute($r1, $r2, $curnt, $dest,$id_ar1[$i],$id_ar2[$j],$obj );  

                }else {
                    // echo "Sorry, We didn't find a best route service for you. Our team are still working to resolve the issue.";

                }
                          
            }
    
            return $arr_to_return;
            
        }
    }
    function justPrintBusRoute($a1, $a2, $f, $l,$id1, $id2,$obj){
        
        $a = $obj->getBusNameByID($id1);
        $b = $obj->getBusNameByID($id2);
    
        $intersectArray = $obj->commonBetweenArray($a1, $a2);
        if (sizeof($intersectArray) > 0) {
            echo str_repeat("=", 50);
            echo "<br><br>".count($a1)." bus found that has $f <br>";
            echo $a[0]." : ";          
            echo var_dump($a1);
            
            echo "<br><br><br>";
            echo count($a2)." bus found that has $l <br>";
            echo $b[0]." : ";
            echo var_dump($a2);
            
            echo "<br><br>";
            print_r($intersectArray);
            echo "<br><br>";
            echo str_repeat("=", 50);
            echo "<br>";
        }
    
        
    }
    function commonBetweenArray($ar1, $ar2){
        $inter = array_intersect($ar1,$ar2);
        return $inter;
    }
    
    
    

// ===================================================================================================================================










    /*
        it will take dest and curnt position, and return all bus ids
        those route have any of d or c.     
    */
    function getBusIDList($curntRouteName, $destRouteName=NULL){ 
        include_once 'db.php';
        $rt_obj = new dataExtract("route");

        $str = "";
        if ($destRouteName === NULL) {
            // echo "Hered Enterd";
            $str = "SELECT bus_route.bus_id FROM bus_list INNER JOIN bus_route ON bus_list.bus_id = bus_route.bus_id WHERE bus_route.route_name LIKE LOWER('%$routeName%') ";
        }else { 
            $str = "(SELECT bus_route.bus_id FROM bus_route WHERE LOWER(bus_route.route_name) LIKE LOWER('%$curntRouteName%')) 
            INTERSECT 
            (SELECT bus_route.bus_id FROM bus_route WHERE LOWER(bus_route.route_name) LIKE LOWER('%$destRouteName%')) ";
        } 
        $res = mysqli_query($rt_obj->dbcon->con,$str);
        $busList = array();
        while($row = mysqli_fetch_assoc($res)){
            array_push($busList, $row['bus_id']);
        }
        return $busList;
    }


    /*
        it will return a compelete route indexs  from a bus_id
    */ 
    function routeIndexCount($b_id=0){
        include_once 'db.php';
        $rt_obj = new dataExtract("route");
    
        $s = "SELECT route_index from bus_route where bus_route.bus_id = $b_id";
    
        $c = mysqli_query($rt_obj->dbcon->con, $s);
        $cn = 0;
        while($row = mysqli_fetch_assoc($c)){
            $cn++;
        }
        if ($cn <=0) {
            echo "This busId has 0 Route";
        }else {
            return $this->getRouteListNames($b_id,$cn);
        }
    }
    
    /*
        it take bus_id, and count of routeIdexs. and return those index names.
    */
    function getRouteListNames($b_id,$r_count){
        include_once 'db.php';
        $rt_obj = new dataExtract("route");
    
        $sq = "SELECT route_name from bus_route where bus_route.bus_id = $b_id and bus_route.route_index >0 and  bus_route.route_index <=$r_count ";
    
        $cr = mysqli_query($rt_obj->dbcon->con, $sq);
        $routeList = array();
        while($row = mysqli_fetch_assoc($cr)){
            array_push($routeList, $row['route_name']);
        }
        return $routeList;
    }
    





    /*
        here cut extra part except curent and destination from given array 
        of that contain both c and d.
    */ 
    function singleLevelRouteFind($curnt, $dest, $curntArray){
        $isFound = FALSE;
        $isCurntFound = in_array($curnt, $curntArray);
        $isDestFound = in_array($dest, $curntArray);
        if ($isCurntFound && $isDestFound) {
            $dst_indx = array_search($dest, $curntArray);
            $curnt_indx = array_search($curnt, $curntArray);
            $out_str = "";
            $out_arr = array();
            if ($dst_indx !== false && $curnt_indx !== false) {
                if ($dst_indx >= $curnt_indx) {
                    for ($i=$dst_indx; $i >=$curnt_indx ; $i--) { 
                        array_push($out_arr, $curntArray[$i]);
                    }
                }else {
                    for ($i=$curnt_indx; $i >=$dst_indx; $i--) { 
                        array_push($out_arr, $curntArray[$i]);
                    }
                }
                
                // if ($dst_indx >= $curnt_indx) {
                //     for ($i=$dst_indx; $i >=$curnt_indx ; $i--) { 
                //         $out_str .= $curntArray[$i]; 
                //         // print($curntArray[$i]);
                //         if ($i > $curnt_indx) {
                //             $out_str .= " => ";
                //         }
                //     }
                // }else {
                //     for ($i=$curnt_indx; $i >=$dst_indx; $i--) { 
                //         $out_str .= $curntArray[$i];
                //         // print($curntArray[$i]);
                //         if ($i > $dst_indx) {
                //             $out_str .= " => ";
                //         }
                //     }
                // }
                
            }else {
                echo "cur or dest not in single level 1";
            }
            return $out_arr;
        }else {
            // echo "Didn't found in Level 1.";
        }
    }

    /*
        here we get bus name by it's id.
    */
    function getBusNameByID($b_id=0){
        include_once 'db.php';
        $rt_obj = new dataExtract("route");
        $s = "SELECT bus_list.bus_name_en FROM bus_list INNER JOIN bus_route ON bus_list.bus_id = bus_route.bus_id WHERE bus_route.bus_id = $b_id";
        $res = mysqli_query($rt_obj->dbcon->con,$s);
        
        $busNames = array();
        while($row = mysqli_fetch_assoc($res)){
            array_push($busNames, $row['bus_name_en']);
        }
        return $busNames;
    
    }
    








//===================================================================================================




















}












































?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: white;">
<!-- <body style="background-color: #797979;"> -->
    

<?php 
        
        if ($LEVEL_NOW === 1) {
            $c = count($arrr);
            if ($c > 0){
                for ($i=0; $i < $c; $i++) { 
                    if (!is_null($arrr[$i][1])) {
                        
                    
    ?>
                <div class="route_result_text_bg">
                    <li class="list_class2" style="margin: 0 auto;padding: 0;list-style: none;width: fit-content;height: auto;">
                        <div class="left_result_bus">
                            <h5><?php echo $arrr[$i][0];?>:</h5>
                        </div>
                        <div  class="left_result_route">
                            <p id = "#left_result_route"><?php echo reformateStrForSingle($arrr[$i][1]); ?>.<br></p>
                            <p class="suggestion_text"  style = "font-size: 15px;list-style: none;margin: 0 auto;padding: 0;margin-top: 10px;">Get down at <strong>'<?php echo end($arrr[$i][1]); ?>'</strong> and reach the destination <strong>'<?php echo $dest_name?>'</strong> on foot or by rickshaw or vehicle.</p></span>
                        </div>
                    </li>
                </div>

    <?php 
                } }
            }
        }elseif ($LEVEL_NOW === 2) {
            if ( count($arrr2) > 0 ) {
                for ($i=0; $i < count($arrr2); $i++) {                     
    ?>
            <li class="list_class" style="margin: 0 auto;padding: 0 ;list-style: none;width: fit-content;height: auto;">
                <div class="route_result_text_bg">
                            
                <!-- arrr2[0] first element of holl array. bus count. 1 complete from 3 buses
                        arrr2[0][0] start bus name.
                        arrr2[0][1] end bus name.
                        arrr2[0][2] 3 array of route. start, middle, last.
                        arrr2[0][2][0] 1st array of 3rd array of route. start.
                        arrr2[0][2][1] 2nd array of 3rd array of route. middle.
                        arrr2[0][2][2] 3rd array of 3rd array of route. last. -->

                <?php 
                    //  echo var_dump( );
                   
                ?>
         
                    <h5>Via <?php echo $arrr2[$i][0];?> to <?php echo $arrr2[$i][1];?> Bus Survice</h5>
                    <p><?php echo reformateStr($arrr2[$i][2][0],$arrr2[$i][2][1],$arrr2[$i][2][2]);?></p>
                    <!-- <p> <span class="first_d">Amet consectetur</span>    adipisicing elit. Excepturi ipsa Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus, illo odio laudantium officia enim velit natus earum accusamus dicta voluptatem.quia illum tenetur porro sunt, iusto quas  <span class="middle_d">laudantium</span>  repellendus laborum molestias culpa tempora! Sit ullam recusandae in dolore non delectus quidem nostrum vero facere laborum praesentium perspiciatis  <span class="last_d">exercitationem</span></p> -->
                    <h5>On Green Bus Stopage switch bus from <?php echo $arrr2[$i][0];?> to <?php echo $arrr2[$i][1];?></h5>
                    <p class="suggestion_text2" style = "font-size: 15px;list-style: none;margin: 0 auto;padding: 0;margin-top: 10px;">Get down at <strong>'<?php echo $arrr2[$i][2][1][2]; ?>'</strong> and reach the destination <strong>'<?php echo $dest_name?>'</strong> on foot or by rickshaw or vehicle.</p>
                </div>
            </li>
    <?php 
              
                }              
            }  
        }else {
            ?>
                <li><p>Sorry for the inconvenience. Our Team getting work hard to reach out the 'Level3' Route Service.</p></li>
            <?php 
        }
    ?>
   
</body>
</html>
<!-- 

if (isset($_POST['dest']) ) {
    $current = $_POST['dest'];
}
if ($_POST['curnt']  ) {
    $destination = $_POST['curnt'];
}


// echo var_dump($current);
// echo var_dump($destination);


if ($current != NULL && $current !="" ) {
    echo "curent is gotted: ".$current;
}else {
    echo "curent is not getted";    
}
echo "<br><br>";
if ($destination != NULL && $destination !="" ) {
    echo "dest is gotted: ".$destination ;
}else {
    echo "dest is not getted";    
}




















if ($cp < $cp_f && $cp < $cp_l) {//this line will add first portion of arrays
        $temp = $obj->cuttOffArray($ar1, $cp, $cp_f - $cp );       
        array_push($final_array,  $temp);
        echo "A";
    }else {
        $temp = $obj->cuttOffArray($ar1, $cp_l+1, $cp  - $cp_l );       
        array_push($final_array,  $temp);
        echo "B";
    }
    array_push($final_array,[reset($cm)]);//this line will add common array in between arrays
    if ($dp < $dp_f && $dp < $dp_l) {//this line will add last portion of arrays
        $temp = $obj->cuttOffArray($ar2, $dp, $dp_f - $dp );       
        array_push($final_array,  array_reverse($temp));
        echo "C";
    }else {
        $temp = $obj->cuttOffArray($ar2, $dp_l+1, $dp  - $dp_l );       
        array_push($final_array,  $temp);
        echo "D";
    }






















    if ($cp < $cp_f && $cp < $cp_l && $dp < $dp_f && $dp < $dp_l) {//this line will add first portion of arrays
            $temp1 = $obj->cuttOffArray($ar1, $cp, $cp_f - $cp );       
            $temp2 = $obj->cuttOffArray($ar2, $dp, $dp_f - $dp );       
            array_push($final_array,  $temp1);
            array_push($final_array,  array_reverse($temp2));
            echo "A";
        }else if($cp < $cp_f && $cp < $cp_l && $dp > $dp_f && $dp > $dp_l) {//this line will add first portion of arrays
            $temp1 = $obj->cuttOffArray($ar1, $cp, $cp_f - $cp );       
            $temp2 = $obj->cuttOffArray($ar2, $dp_l, $dp - $dp_l );       
            array_push($final_array,  $temp1);
            array_push($final_array,  array_reverse($temp2));
            echo "B";
        }else if ($cp > $cp_f && $cp > $cp_l && $dp < $dp_f && $dp < $dp_l) {//this line will add last portion of arrays
            $temp1 = $obj->cuttOffArray($ar1, $cp_l, $cp - $cp_l );       
            $temp2 = $obj->cuttOffArray($ar2, $dp, $dp_f - $dp );       
            array_push($final_array,  array_reverse($temp1));
            array_push($final_array,  array_reverse($temp2));
            echo "C";
        }else if ($cp > $cp_f && $cp > $cp_l && $dp > $dp_f && $dp > $dp_l) {//this line will add last portion of arrays
            $temp1 = $obj->cuttOffArray($ar1, $cp_l, $cp - $cp_l );       
            $temp2 = $obj->cuttOffArray($ar2, $dp_l, $dp - $dp_l );       
            array_push($final_array,  $temp1);
            array_push($final_array,  array_reverse($temp2));
            echo "D";
        }else {      
            array_push($final_array,  []);
            array_push($final_array,  []);
            echo "E";
        }



        if ($cp < $cp_f && $cp < $cp_l) {//this line will add first portion of arrays
            $temp = $obj->cuttOffArray($ar1, $cp, $cp_f - $cp );       
            array_push($final_array,  $temp);
            echo "A";
        }else {
            $temp = $obj->cuttOffArray($ar1, $cp_l+1, $cp  - $cp_l );       
            array_push($final_array,  $temp);
            echo "B";
        }
        array_push($final_array,[reset($cm)]);//this line will add common array in between arrays
        if ($dp < $dp_f && $dp < $dp_l) {//this line will add last portion of arrays
            $temp = $obj->cuttOffArray($ar2, $dp, $dp_f - $dp );       
            array_push($final_array,  array_reverse($temp));
            echo "C";
        }else {
            $temp = $obj->cuttOffArray($ar2, $dp_l+1, $dp  - $dp_l );       
            array_push($final_array,  $temp);
            echo "D";
        }









 -->