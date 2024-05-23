
<?php
    $dsn = "mysql:host=localhost;dbname=pets;charset=utf8";
    $user = "testuser";
    $pass = "testpass";

    $namae1 = $_GET["namae1"];
    $namae2 = $_GET["namae2"];
    $syurui = $_GET["syurui"];
    $seibetu = $_GET["seibetu"];
    $age = $_GET["age"];
    $weight = $_GET["weight"];
    $time = $_GET["time"];
    $current_date = date("Y-m-d"); 

    // DBに接続します
    try {
        $dbh = new PDO($dsn, $user, $pass);
        // SQL文の用意
        $sql = <<<SQL
        INSERT INTO pet (
            `name`,
            `name of pet`, 
            `type of pet`,
            `gender of pet`,
            `age of pet`,
            `weight of pet`,
            `time of vaccine`,
            `time of register`
        ) VALUES (
            '$namae1',
            '$namae2', 
            '$syurui', 
            '$seibetu', 
            '$age',
            '$weight',
            '$time',
            '$current_date'
        )
SQL;
        $dbh->query($sql);

        echo "<p>以下の内容が登録されました。</p>";
        echo"<br>";
        echo "<p>ユーザー名:$namae1 </p>";
        echo "<p>ペットの名前:$namae2</p> ";
        echo "<p>ペットの種類:$syurui</p>";
        echo "<p>ペットの性別：$seibetu </p>";
        echo "<p>ペットの体重:$weight </p>";
        echo "<p>前回のワクチン接種時間:$time </p>";
        echo"<p>登録日付：$current_date</p>";
    } catch (PDOException $e) {
        echo "接続失敗...";
        echo "エラー内容:" . $e->getMessage();
    }
?>
   
<a href="user_input1.html">戻る</a> 

