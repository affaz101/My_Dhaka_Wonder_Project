<?php
static $CONF_BTN_STATUS = 0; // 0: not selected, 1: selected
$selected_dest = "aaa";
static $selected_dest_id = 0;
$sug_array = array();

include 'db.php';
$s = "SELECT c_name FROM dest_category ORDER BY c_id";
$db_obj = new dataExtract($s);




$full_dest_obj = new dataExtract();
$dest_id_array =$full_dest_obj->get_d_id_array();
$dest_name_array =$full_dest_obj->get_d_name_array();
$dest_desc_array = $full_dest_obj->get_d_desc_array();
$dest_addr_array = $full_dest_obj->get_d_loc_array();
$dest_bus_stand_array = $full_dest_obj->get_d_bs_array();
$dest_day_off_array = $full_dest_obj->get_d_off_array();
$dest_day_on_array = $full_dest_obj->get_d_on_array();
$dest_ticket_array =$full_dest_obj->get_d_ticket_array();
$dest_type_array =$full_dest_obj->get_d_type_array();
$dest_img_array = $full_dest_obj->get_d_img_array();

$json_id_str = json_encode($dest_id_array);
$json_name_str = json_encode($dest_name_array);
$json_desc_str = json_encode($dest_desc_array);
$json_addr_str = json_encode($dest_addr_array);
$json_bus_stand_str = json_encode($dest_bus_stand_array);
$json_day_off_str = json_encode($dest_day_off_array);
$json_day_on_str = json_encode($dest_day_on_array);
$json_ticket_str = json_encode($dest_ticket_array);
$json_type_str = json_encode($dest_type_array);
$json_img_str = json_encode($dest_img_array);

// echo var_dump($dest_desc_array);

$category = array();
$sub_category = array();
while ($row = mysqli_fetch_assoc($db_obj->res_obj)) {
    array_push($category, $row);
}
// echo var_dump($category[8]['c_name']);
$len = count($category);
for ($i=0; $i < $len; $i++) { 
    $v = $category[$i]['c_name'];
    $sc = "SELECT dest_name, dest_id FROM destination WHERE dest_type LIKE '%$v%' ";

    // $sc = "SELECT s_name FROM dest_sub ORDER BY dest_sub.s_id";
    $sc_db_obj = new dataExtract($sc);
    $tm = array();
    while ($r = mysqli_fetch_assoc($sc_db_obj->res_obj)) {
        array_push($tm, $r);
    }
    array_push($sub_category, $tm);
}

//Below code is for Route finding current location suggestion list
$unq_loc_str = "SELECT DISTINCT route_name FROM bus_route";
$unq_loc_obj = new dataExtract($unq_loc_str);
$unq_loc_array = [];
while ($r = mysqli_fetch_assoc($unq_loc_obj->res_obj)) {
    array_push($unq_loc_array, $r['route_name']);
}
$json_string = json_encode($unq_loc_array);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dhaka wonder</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <link rel="icon" href="img/logo_fav.png" type="image/png">



</head>
<body>
    
    <div class="main_container">
        <div class="top_ceiling"></div>

        <div class="header">

            <div class="logo">
                <div class="logo_left">
                    <img class="logo_img" src="img/logo_img.svg" alt="logo">
                </div>
                <div class="logo_right">
                    <img class="logo_dhaka" src="img/logo_dhaka.svg" alt="dhaka">
                    <img class="logo_wonder" src="img/logo_wonder.svg" alt="wonder">
                </div>
            </div>
            <div class="nav">
                <ul>
                    <li><a href="index.php">Category</a>
                        <ul>
                            <?php 
                                $cat_len = count($category);
                                for ($i=0; $i < $cat_len; $i++) {                                 
                            ?>
                            <li><a href="#"><?php echo $category[$i]['c_name'];?></a>
                                <ul>
                                    <?php 
                                        $sub_len = count($sub_category[$i]);
                                        for ($j=0; $j < $sub_len; $j++) { 
                                            
                                        
                                    ?>
                                    <li onclick = "nav_item_clicked(<?php $selected_dest_id = $sub_category[$i][$j]['dest_id']; echo $selected_dest_id; ?>)"  ><a><?php echo $sub_category[$i][$j]['dest_name']; ?></a></li>
                                    <?php 
                                        }
                                    ?>
                                </ul>
                            </li>
                            <?php 
                                }
                            ?>
                        </ul>
                    </li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>

            </div>

        </div>



        <div class="slide_list">
            <ul id="slidingList">
                


                <li class="slid_item hd">
                    <div class="slide">
                        <div class="slide_left">
                            <div class="h_title">
                                <h1 id="#title"> Headding 1</h1>
                            </div>
                            <div class="h_desc">
                                <p id="#desc" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate enim debitis rem adipisci et aliquid necessitatibus asperiores unde voluptate at reprehenderit eveniet porro voluptatem quo fugit, qui tenetur sapiente! Porro id ad aliquid et dolorem nihil vel placeat dignissimos. <br> <br> Provident id, quam ratione consequatur, voluptatibus reprehenderit dolorum iure sapiente ea debitis doloremque fuga libero cupiditate mollitia impedit numquam minus nihil possimus sunt quo eius? Possimus dolor necessitatibus nemo nisi facere ea, consequuntur reprehenderit rem deserunt ullam. In cupiditate dolorem nesciunt, fugiat illum nam libero ab repellat accusamus saepe dolor quia quos architecto ducimus veniam sit labore incidunt vel deserunt consequatur.</p>
                            </div>
                            <div class="h_other">
                                <div class="off_day">
                                    <h4 class="h_head">Off Day :</h4>
                                    <h4 class="h_text" id ="#off_day" >Lorem, ipsum.</h4>
                                </div>
                                <div class="on_day">
                                    <h4 class="h_head">On Day :</h4>
                                    <h4 class="h_text" id="#on_day">Lorem, ipsum.</h4>
                                </div>
                                <div class="ticket_fare">
                                    <h4 class="h_head">Ticket Fare :</h4>
                                    <h4 class="h_text" id="#ticket"> 540</h4>
                                </div>
                            </div>

                        </div>
                        <div class="slide_right">
                            <div class="slide_right_bottom">
                                <img id="#slide_img" src="img/lalbagh.jpg" alt="">
                                <img id="#slide_img" src="img_db/ct1_A2.jpg" alt="">
                                <img id="#slide_img" src="img_db/ct1_A3.jpg" alt="">
                            </div>
                            <div class="slide_right_top">
                                <div class="slide_right_top_text_area">
                                    <h2 id="#title2"> Lorem ipsum dolor sdgfs sit amet.</h2>
                                    <p id="#addr">Lorem ipsum dolor sit.</p>
                                </div>
                                <div class="slide_right_top_arrow">
                                    <div class="arrow_left" id="#next" >
                                        <img src="img/left_right_arrow.svg" alt="">
                                    </div>
                                    <div class="arrow_right" id="#prev">
                                        <img src="img/left_right_arrow.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> 
                
                

            </ul>
        </div>
        <!-- <?php include 'slide.php'?> -->
        <div class="slide_item_pointer">
            <ul>
                <?php 
                    for ($i=0; $i < 5; $i++) { 
                ?>
                <li onclick='clickedwewew(<?php echo $i;?>)'><div class="bullet_point"></div></li>
                
                <?php 
                    }
                    ?>
            </ul>
        </div>
        
        <!-- <li onclick='clicked(1)'><div class="bullet_point special_dot1"></div></li> -->

        <div class="confirm_area">
            <div class="conf_left">
                <img src="img/side_line.svg" alt="">
            </div>
            <div onclick='conf_btn()' class="conf_mid">
                <!-- img txt img -->
                <div class="conf_btn_bg">
                    <img src="img/confirm_btn.svg" alt="">
                </div>
                <div class="conf_btn_top">
                    <img class="cbt_left" id="#btn_left" src="img/up_down_arrow.svg" alt="">
                    <p id="conf_p">Confirm Your Destination</p>
                    <img class="cbt_right" id="#btn_right" src="img/up_down_arrow.svg" alt="">
                </div>

            </div>
            <div class="conf_right">
                <img src="img/side_line.svg" alt="">
            </div>
        </div>
       

        
        <div class="conf_result">
            <div class="conf_result_left">
                <div class="conf_res_left_bg">
                    <img src="img/route_bg.svg" alt="">
                </div>
                <div class="conf_res_left_heading">
                    <h1>Find Your Destination Route</h1>
                </div>
                <div class="conf_res_left_find">
                    <form action="ttr"  method="post">
                        <div class="route_find_left_selected_dest">
                        <p>Title of Selected dest</p>
                        <input type="text" name="route_dest_selected"  id="#input_selected_dest" readonly> 

                        </div>
                        <div class="route_find_mid_cloc">
                            <p>Your Current Location</p>
                            <input type="text"  name="route_current_loc" id="#input_current_dest">
                        </div>
                        
                        <ul class="sug_list"></ul>

                        <input onclick="route_find()" type="button" value="Find" class="route_find_right_find_btn">
              
                    </form>

                              

                </div>
                <div class="conf_res_left_result">
                    <ul id="#res_list">
                        <li>
                            <div class="left_result_bus"><h5>Bus Name :</h5></div>
                            <div  class="left_result_route"><p id = "#left_result_route">Bus Route will be placed here. From your Current Location to Destination Location. Enjoy your jurney.</p></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="conf_result_right">
                <div class="guid_area">
                    <div class="guid_area_bg">
                        <img src="img/guid_bg.svg" alt="">
                    </div>
                    <div class="guid_heading">
                        <h1>Find Your Guide</h1>
                    </div>
                    <div class="guid_find">

                        <div class="guid_find_top">
                            <div class="guide_find_selected_dest">
                                <p>Title of Selected dest</p>
                                <input type="text" name="route_dest_selected"  id="#g_selected_dest"  readonly>
    
                            </div>
                            <div class="guide_find_gender">
                                <p>Gender</p>
                                <select name="gender" id="#g_gender">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>    
                            </div>
                            <div class="guide_find_age_range">
                                <p>Age Range</p>
                                <select name="Age" id="#g_age">
                                    <option>12-20</option>
                                    <option>21-35</option>
                                    <option>35-50</option>
                                    <option>51+ </option>
                                </select>    
                            </div>
                            <div class="guide_find_fees">
                                <p>Fees/hour</p>
                                <select name="fees" id="#g_fees">
                                    <option>50-100</option>
                                    <option>101-150</option>
                                    <option>151-200</option>
                                    <option>201-250</option>
                                    <option>250+</option>
                                </select>    
                             
                            </div>
                            
                        </div>
                        <div class="guid_find_bottom">
                            <div class="guide_find_name">
                                <p>Your Name</p>
                                <input type="text" name="g_name" id="#g_name">
                            </div>
                            <div class="guide_find_phone">
                                <p>Phone Number</p>
                                <input type="number" maxlength="10" require  name="g_phone" id="#g_phone">
                            </div>
                            <div class="guide_find_btn" onclick="find_guid()">
                                <p>Find</p>
                            </div>

                        </div>
                    </div>
                    <div class="guid_result" id="#guid_res">
                        <!-- <div class="guid_result_left">
                            <p></p>
                        </div>
                        <div class="guid_result_right" id="#g_res_right">
                            <p>Md. Robiul. <br> Gender: <br>Male. Age: 54. <br>Charge: 100 BDT/hr <br>Phone: +880111111111</p>
                        </div> -->
                    </div>
                </div>
            
            </div>
            
        </div>
        
        <?php 
            // print_r($d_name); 
            
            $json_d_name_string = json_encode($d_name);
            
            ?>

    </div>
    
    <div class="bottom_footer">
        <p>&copy; 2023 Dhaka wonder. All right reserved.</p>
    </div>


    <script src="js/jquery.js"></script>
    <script type="text/javascript">
        
        function find_guid() {
            var g_selected = document.getElementById("#g_selected_dest").value;
            var g_gender = document.getElementById("#g_gender").value;
            var g_age = document.getElementById("#g_age").value;
            var g_fees = document.getElementById("#g_fees").value;
            var g_name = document.getElementById("#g_name").value;
            var g_phone = document.getElementById("#g_phone").value;

            var guid_res = document.getElementById("#guid_res");
            var guid_res_right = document.getElementById("#g_res_right");

            if (var_validate(g_selected) &&  var_validate(g_gender) &&  var_validate(g_age) &&  var_validate(g_fees) &&  var_validate(g_name) &&  var_validate(g_phone) ) {      
                $.ajax({
                    url:"guid.php",
                    type:"POST",
                    data:{s:g_selected, g:g_gender,a:g_age,f:g_fees,n:g_name,p:g_phone},
                    success:function(data) {
                        guid_res.innerHTML=data;
                    }
                });
            }
            
        }
        function var_validate(v) {
            if (v !=="" || v !== null) {
                return true;
            }
        }






        var selected_dest_positon_id =0;
        var js_id_array = JSON.parse('<?php echo $json_id_str;?>');
        var js_name_array =JSON.parse('<?php echo $json_name_str;?>');
        var js_desc_array = JSON.parse('<?php echo $json_desc_str;?>');
        var js_addr_array = JSON.parse('<?php echo $json_addr_str;?>');
        var js_bus_stand_array = JSON.parse('<?php echo $json_bus_stand_str;?>');
        var js_day_off_array = JSON.parse('<?php echo $json_day_off_str;?>');
        var js_day_on_array = JSON.parse('<?php echo $json_day_on_str;?>');
        var js_ticket_array = JSON.parse('<?php echo $json_ticket_str;?>');
        var js_type_array = JSON.parse('<?php echo $json_type_str;?>');
        var js_img_array = JSON.parse('<?php echo $json_img_str;?>');
        function nav_item_clicked(i) {
            itemChang(i-1);
            // alert(js_name_array[i-1]);
        }
        var title1 = document.getElementById('#title');
        var title2 = document.getElementById('#title2');
        var desc = document.getElementById('#desc');
        var addr = document.getElementById('#addr');
        var on_day = document.getElementById('#on_day');
        var off_day = document.getElementById('#off_day');
        var ticket = document.getElementById('#ticket');
        var img = document.getElementById('#slide_img');

        function onLeft() {
            
        }
        const slides = document.getElementById('#slide_img');
        const prevBtn = document.getElementById('#prev');
        const nextBtn = document.getElementById('#next');

        let currentSlide = 0;

        function slideTo(index) {
            slides.style.left = `-${index * 100}%`;
        }

        slideTo(currentSlide);

        prevBtn.addEventListener('click', () => {
        if (currentSlide === 0) {
            currentSlide = slides.children.length - 1;
        } else {
            currentSlide--;
        }
        slideTo(currentSlide);
        });

        nextBtn.addEventListener('click', () => {
        if (currentSlide === slides.children.length - 1) {
            currentSlide = 0;
        } else {
            currentSlide++;
        }
        slideTo(currentSlide);
        });

        setInterval(() => {
            nextBtn.click();
        }, 3000);



        // window.onload = itemChang(2);
        // Below code Change randomly home page value when refresshing...
        window.onload = getRandomInt(0, 62);
        function getRandomInt(min, max) {
            var r = Math.floor(Math.random() * (max - min) + min);
            itemChang(r);
        }
        function changeImg(img_name) {
            var n = "img_db/"+img_name+"";
            img_str = "img_db/"+img_str+"1.jpg";
        }
        function itemChang(index) {
            title1.innerHTML = js_name_array[index];
            title2.innerHTML = js_name_array[index];
            desc.innerHTML = js_desc_array[index];
            addr.innerHTML = js_addr_array[index];
            on_day.innerHTML = js_day_on_array[index];
            off_day.innerHTML = js_day_off_array[index];
            ticket.innerHTML = js_ticket_array[index];
            var img_str = js_img_array[index];
            img_str = img_str.split('.')[0];
            img_str = "img_db/"+img_str+"1.jpg";
            img.src = img_str;
            routeFindInputTextSet(index);
            selected_dest_positon_id = index;
            
            console.log(js_bus_stand_array[index]);
        }

        function route_find() {
            
            var input_selected_dest = document.getElementById("#input_selected_dest").value;
            var input_selected_dest_index = js_name_array.indexOf(input_selected_dest);
            var input_current_dest = document.getElementById("#input_current_dest").value;
            
            var selected_dest = js_bus_stand_array[input_selected_dest_index];
            var selected_current = input_current_dest;
            var selected_dest_name = input_selected_dest;
            
            
            var a = document.getElementById("#left_result_route");
            var lst = document.getElementById("#res_list");
            
            console.log("selected dest is: "+selected_dest+" and len: "+selected_dest.length);
            console.log(selected_current.length);
            
            $.ajax({
                url:"findroute.php",
                type:"POST",
                data:{dest: selected_dest, curnt: selected_current, dest_name:selected_dest_name},
                success:function(data) {
                    lst.innerHTML=data;
                }
                // console.log(js_bus_stand_array[input_selected_dest_index])
            });

        }

        var json_d_name_array = JSON.parse('<?php echo $json_d_name_string;?>');
        console.log(json_d_name_array);
        var t = 1000;
        var firstIndex = 0;
        var des_posi = 0;
        clicked(0);
        function clicked(v) {
            firstIndex = v;

            var i;
            const items = document.querySelectorAll('.slid_item');
            for (i = 0; i < items.length; i++) {
                items[i].style.display = "none";
            }
            items[v].style.display = "block";
            des_posi = v;
        }

        var conf_val=0;
        
        var ar1 = document.getElementById('#btn_left');
        var ar2 = document.getElementById('#btn_right');
        var conf_res = document.querySelector('.conf_result');
        var conf_p = document.getElementById('conf_p');
        
        function conf_res_default() {
            conf_res.style.display="none";      //default conf result hide by this line      
        }
        window.onload = conf_res_default;
        conf_btn(0);
        function conf_btn(p) {
            console.log(selected_dest_positon_id);
            if (conf_val == 0) {
                conf_val = 1;
                console.log(conf_val);
                ar1.style.transform = 'rotate('+0+'deg)';
                ar2.style.transform = 'rotate('+0+'deg)';
                conf_p.innerHTML="Confirm Your Destination";
                //inp.value=json_d_name_array[des_posi]; //in route find first input box setted the selected name
                
                
                conf_res.style.display="none";
            }else{
                conf_val = 0;
                console.log(conf_val);
                ar1.style.transform = 'rotate('+180+'deg)';
                ar2.style.transform = 'rotate('+180+'deg)';
                conf_p.innerHTML="Confirmed as Your Destination";
                
                
                
                conf_res.style.display='block';
            }
            // console.log(js_name_array[selected_dest_positon_id]);
            routeFindInputTextSet(selected_dest_positon_id);

        }
        function routeFindInputTextSet(index) {
            
            var inp = document.getElementById('#input_selected_dest');
            var inpRight = document.getElementById('#g_selected_dest');
            inp.value=js_name_array[index];            
            inpRight.value=js_name_array[index];            
        }


        
        //Suggestion location array getting ready from php to js
        let js_sug_array = JSON.parse('<?php echo $json_string;?>');  

        //Sort names in ascending order
        let sortedNames = js_sug_array.sort();

        //reference
        let input = document.getElementById("#input_current_dest");

        //Execute function on keyup
        input.addEventListener("keyup", (e) => {
            //loop through above array
            //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
            removeElements();
            for (let i of sortedNames) {
                //convert input to lowercase and compare with each string

                if (
                i.toLowerCase().startsWith(input.value.toLowerCase()) &&
                input.value != ""
                ) {
                    //create li element
                    let listItem = document.createElement("li");
                    //One common class name
                    listItem.classList.add("list-items");
                    listItem.style.cursor = "pointer";
                    listItem.setAttribute("onclick", "displayNames('" + i + "')");
                    //Display matched part in bold
                    let word = "<b>" + i.substr(0, input.value.length) + "</b>";
                    word += i.substr(input.value.length);
                    //display the value in array
                    listItem.innerHTML = word;
                    document.querySelector(".sug_list").appendChild(listItem);
                }
            }
        });
        function displayNames(value) {
            input.value = value;
            removeElements();
        }
        function removeElements() {
        //clear all the item
            let items = document.querySelectorAll(".list-items");
            items.forEach((item) => {
                item.remove();
            });
        }

    </script>

</body>
</html>




<!-- 


            <div class="nav">
                <ul>
                    <li><a href="#">Category</a>
                        <ul>
                            <li><a href="#">Nature</a></li>
                            <li><a href="#">Entertainment</a>
                                <ul>
                                    <li><a href="#">Shahbag Jadughar</a></li>
                                    <li><a href="#">Novotheator</a></li>
                                    <li><a href="#">Shishu Mela</a></li>
                                    <li><a href="#">Muktijoddha Jadughar</a></li>
                                    <li><a href="#">Nondon</a></li>
                                    <li><a href="#">Jamuna Featur</a>e</li>
                                    <li><a href="#">Sineplex</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Park</a></li>
                            <li><a href="#">Science</a></li>
                            <li><a href="#">Hospital</a></li>
                        </ul>
                    </li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>

            </div>














                    <div class="slide_item_pointer">
            <ul>
                <li onclick='clicked(0)'><div class="bullet_point"></div></li>
                <li onclick='clicked(1)' class="special_dot"><div class="bullet_point special_dot1"></div></li>
                <li onclick='clicked(2)'><div class="bullet_point"></div></li>
                <li onclick='clicked(3)'><div class="bullet_point"></div></li>
                <li onclick='clicked(4)'><div class="bullet_point"></div></li>
            </ul>
        </div>
 -->


 <!-- $full_dest_obj = new dataExtract();
$dest_id_array =$full_dest_obj->get_d_id_array();
$dest_name_array =$full_dest_obj->get_d_name_array();
$dest_desc_array = $full_dest_obj->get_d_desc_array();
$dest_addr_array = $full_dest_obj->get_d_loc_array();
$dest_bus_stand_array = $full_dest_obj->get_d_bs_array();
$dest_day_off_array = $full_dest_obj->get_d_off_array();
$dest_day_on_array = $full_dest_obj->get_d_on_array();
$dest_ticket_array =$full_dest_obj->get_d_ticket_array();
$dest_type_array =$full_dest_obj->get_d_type_array();
$dest_img_array = $full_dest_obj->get_d_img_array(); -->