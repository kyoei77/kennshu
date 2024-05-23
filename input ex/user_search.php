<?php
//DB接続に必要な情報をまとめておきます。
$dsn = "mysql:host=localhost;dbname=pets;charset=utf8";
$user = "testuser";
$pass = "testpass";

//htmlから送られてきた値を格納
if(isset($_GET["namae1"])){
    $name = $_GET["namae1"];

}
if(isset($_GET["id"])){
    $id = $_GET["id"];

}
//データベースへ接続
try{
    $dbh = new PDO($dsn, $user, $pass);

    
    if(isset($_GET["mode"]) && $_GET["mode"] == "delete"){
        delete();//削除処理
    }
    display();//表示処理
        
} catch(PDOException $e){
    echo "接続失敗...";
    echo "エラー内容:".$e->getMessage();    
}

/////////////////////////////////////////////////////////
//関数(機能)を別々に作っていきます

function display(){
    global $dbh;
    global $name;

    //sql文を用意
    $sql = <<<SQL
    SELECT * FROM pet WHERE name=?&& flag=1 ;
SQL;
    $stmt = $dbh->prepare($sql);//sqlの結果を保留
    $stmt->bindParam(1, $name);//プレイスホルダー(値が未確定だったところに、値を紐づける)
    $stmt->execute();//保留していたsqlを実行
    $rows = $stmt->fetchAll(); // 全ての行を取得

    if (count($rows) > 0) { // 1つ以上の行が取得された場合
        //$blockがテキストかつ中身がないことを定義
        $block = "";

        //テンプレートファイルの読み込み
        $fh = fopen("user_search.tmpl", "r+");//読み込みモードで、tmplを開く
        $fs = filesize("user_search.tmpl");//ファイルサイズを調べる
        $users_tmpl = fread($fh, $fs);//ファイルの読み込みを行う

        //レコードを1行ずつ繰り返し$blockに詰め込む
        foreach ($rows as $row) {
            //差し込み用テンプレートを初期化する
            $input = $users_tmpl;

            //DBの値を、PHPで使用する値として、変数に入れなおす
            $id = $row["id"];
            $name = $row["name"];
            $name_of_pet = $row["name of pet"];
            $type_of_pet = $row["type of pet"];
            $gender_of_pet = $row["gender of pet"];
            $age_of_pet = $row["age of pet"];
            $weight_of_pet = $row["weight of pet"];
            $time_of_vaccine = $row["time of vaccine"];
            $time_of_register = $row["time of register"];

            //テンプレートファイルの文字置き換え
            $input = str_replace("!id!", $id, $input);
            $input = str_replace("!name!", $name, $input);
            $input = str_replace("!name of pet!", $name_of_pet, $input);
            $input = str_replace("!type of pet!", $type_of_pet, $input);
            $input = str_replace("!gender of pet!", $gender_of_pet, $input);
            $input = str_replace("!age of pet!", $age_of_pet, $input);
            $input = str_replace("!weight of pet!", $weight_of_pet, $input);
            $input = str_replace("!time of vaccine!", $time_of_vaccine, $input);
            $input = str_replace("!time of register!", $time_of_register, $input);
            //stock.htmlに差し込む変数に格納します。
            $block .= $input;//ループするたびに、insert_tmplの値を追記していく
        }

        //stock.htmlの!block!に、$blockを差し込む
        $fh = fopen("user_search.html", "r+");
        $fs = filesize("user_search.html");
        $top = fread($fh, $fs);
        fclose($fh);

        //$top(stock.htmlのデータ)の!block!に$blockを置き換える
        $top = str_replace("!block!", $block, $top);

        //全てを差し替えたデータを、ブラウザ表示
        echo $top;
    } else {
        echo "該当するデータが見つかりませんでした。";
    }
}

function delete(){
    
    global $dbh;
    global $id;


    //sql文を用意
    
    $sql=<<<sql
    update pet set flag = 0 where id=?;
sql;
    $stmt=$dbh -> prepare($sql); 
    $stmt-> bindParam(1,$id);
    
    $stmt->execute();

}
?>