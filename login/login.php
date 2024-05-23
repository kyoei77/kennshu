<?php
    //ログインのため
    $input_id = $_POST["id"];
    $input_pass = $_POST["pass"];

    $db_id = "kyoei";
    $db_pass = "1234";

    $new_location = "../input ex/user_input.html";
    $old_location = "../login/login.html";
    

    if ($input_id == $db_id && $input_pass == $db_pass) {
        header("Location: $new_location");
        exit; 
    } else {
        echo"<p>ユーザー名もしくはパスワード間違っています</p>";

    }
    
?>
    <a href="login.html">ログインページへ移動</a>

