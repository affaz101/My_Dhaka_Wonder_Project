<?php
include_once 'db.php';

// if (isset($_REQUEST['s'])) {
//     $new_index = $_REQUEST['s'];
//     $new_index = (int) $new_index;
//     $ARRAY_INDEX = $new_index;
// }
$ARRAY_INDEX = 0;
$ARRAY_INDEX_array = array();
$d_name = array();
$d_desc = array();
$d_loc = array();
$d_bs = array();
$d_off = array();
$d_on = array();
$d_ticket = array();
class gettingData{
    public $data_obj ;
    function __construct(){
        $this->data_obj = new dataExtract("Slide");
        return $this->data_obj;
    }
}
if (isset($_REQUEST['s'])) {
    $i = $_REQUEST['s'];
    $ARRAY_INDEX = $i;
}

$obj = new gettingData();
$obj->data_obj->setArrayIndex($ARRAY_INDEX);
$d_name = $obj->data_obj->get_d_name_array();
$d_loc = $obj->data_obj->get_d_loc_array();
$d_bs = $obj->data_obj->get_d_bs_array();
$d_off = $obj->data_obj->get_d_off_array();
$d_on = $obj->data_obj->get_d_on_array();
$d_ticket = $obj->data_obj->get_d_ticket_array();
$ARRAY_INDEX = (int) $obj->data_obj->getArrayIndex();
// echo var_dump($ARRAY_INDEX);
// echo count($d_name);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="slide_list">
        <ul id="slidingList">
            <?php 
                $cn = count($d_name);
                for ($i=0; $i < $cn; $i++) { 
                    array_push($ARRAY_INDEX_array, $i);
                
            ?>
            <li class="slid_item hd">
                <div class="slide">
                    <div class="slide_left">
                        <div class="h_title">
                            <h1><?php echo $d_name[$i];?></h1>
                        </div>
                        <div class="h_desc">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate enim debitis rem adipisci et aliquid necessitatibus asperiores unde voluptate at reprehenderit eveniet porro voluptatem quo fugit, qui tenetur sapiente! Porro id ad aliquid et dolorem nihil vel placeat dignissimos. <br> <br> Provident id, quam ratione consequatur, voluptatibus reprehenderit dolorum iure sapiente ea debitis doloremque fuga libero cupiditate mollitia impedit numquam minus nihil possimus sunt quo eius? Possimus dolor necessitatibus nemo nisi facere ea, consequuntur reprehenderit rem deserunt ullam. In cupiditate dolorem nesciunt, fugiat illum nam libero ab repellat accusamus saepe dolor quia quos architecto ducimus veniam sit labore incidunt vel deserunt consequatur.</p>
                        </div>
                        <div class="h_other">
                            <div class="off_day">
                                <h4 class="h_head">Off Day :</h4>
                                <h4 class="h_text"><?php echo $d_off[$i];?></h4>
                            </div>
                            <div class="on_day">
                                <h4 class="h_head">On Day :</h4>
                                <h4 class="h_text"><?php echo $d_on[$i];?></h4>
                            </div>
                            <div class="ticket_fare">
                                <h4 class="h_head">Ticket Fare :</h4>
                                <h4 class="h_text"><?php echo $d_ticket[$i];?></h4>
                            </div>
                        </div>

                    </div>
                    <div class="slide_right">
                        <div class="slide_right_bottom">
                            <img src="img/lalbagh.jpg" alt="">
                        </div>
                        <div class="slide_right_top">
                            <div class="slide_right_top_text_area">
                                <h2><?php echo $d_name[$i];?></h2>
                                <p><?php echo $d_loc[$i];?></p>
                            </div>
                            <div class="slide_right_top_arrow">
                                <div class="arrow_left">
                                    <img src="img/left_right_arrow.svg" alt="">
                                </div>
                                <div class="arrow_right">
                                    <img src="img/left_right_arrow.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li> 
            <?php 
                }
            ?>           
        </ul>
    </div>

    <script>
        // var t = 1000;
        // var firstIndex = 0;
        // function automateSlide() {
        //     var i;
        //     const items = document.querySelectorAll('.slid_item');
        //     for (i = 0; i < items.length; i++) {
        //         items[i].style.display = "none";
        //     }
        //     firstIndex++;
        //     if (firstIndex > items.length) {
        //         firstIndex = 1;
        //     }
            
        //     items[firstIndex -1].style.display = "block";
        //     setTimeout(automateSlide, 3000);
        //     // console.log(items);
        //     // alert('hi');
        // }

        // automateSlide();
        // window.onload = automateSlide;

    </script>

</body>
</html>
<?php 

// header('location:index.php');

?>