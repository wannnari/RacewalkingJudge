<?php
$dsn = 'mysql:host=localhost;dbname=******;charsetr=utf8';
$user = '******';
$password = '******';
$mode = htmlspecialchars(filter_input(INPUT_POST,'mode'));

// 黄色パドルなどジャッジ入力情報を全テーブルリセット
if($mode === "reset"){
    try{
        $pdo = new PDO($dsn, $user, $password);
        $sql = "UPDATE judge1 SET YellowBent = NULL,YellowLoss = NULL, RedCard = NULL, RedTime = NULL;
        UPDATE judge2 SET YellowBent = NULL,YellowLoss = NULL, RedCard = NULL, RedTime = NULL;
        UPDATE judge3 SET YellowBent = NULL,YellowLoss = NULL, RedCard = NULL, RedTime = NULL;
        UPDATE judge4 SET YellowBent = NULL,YellowLoss = NULL, RedCard = NULL, RedTime = NULL;
        UPDATE judge5 SET YellowBent = NULL,YellowLoss = NULL, RedCard = NULL, RedTime = NULL;
        UPDATE chiefjudge SET RedCard = NULL, RedTime = NULL;";
        $stmh = $pdo->prepare($sql);
        $stmh->execute();
        $pdo = null;
    } catch (PDOException $e) {
        echo 'データベースにアクセスできません!' . $e->getMessage();
        exit;
    }   
}

// データベースにスタートリストを登録
if(isset($_POST['go'])){
    try{
        $pdo = new PDO($dsn, $user,$password);
        $fname = $_FILES['inputFile']['tmp_name'];
        $fp = fopen($fname,"r");
        while(! feof($fp)){
            $csv = fgets($fp);
            $csv = trim($csv,'"');
            $csv = mb_convert_encoding($csv,"UTF-8","utf-8");
            $csv = str_replace('"',"",$csv);
            $csv_array = explode(",",$csv);
            $stmt = $pdo->prepare("INSERT INTO judge1(ord,id,name,belongs) VALUES(:ord, :id, :name, :belongs);
            INSERT INTO judge2(ord,id,name,belongs) VALUES(:ord, :id, :name, :belongs);
            INSERT INTO judge3(ord,id,name,belongs) VALUES(:ord, :id, :name, :belongs);
            INSERT INTO judge4(ord,id,name,belongs) VALUES(:ord, :id, :name, :belongs);
            INSERT INTO judge5(ord,id,name,belongs) VALUES(:ord, :id, :name, :belongs);
            INSERT INTO chiefJudge(ord,id,name,belongs) VALUES(:ord, :id, :name, :belongs);");
            $stmt->bindParam('ord', $csv_array[0],PDO::PARAM_STR);
            $stmt->bindParam('id', $csv_array[1],PDO::PARAM_STR);
            $stmt->bindParam('name', $csv_array[2],PDO::PARAM_STR);
            $stmt->bindParam('belongs', $csv_array[3],PDO::PARAM_STR);
            $stmt->execute();
        }
    }catch(PDOException $e){
        echo 'データベースにアクセスできません!'. $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width">

</head>

<div class="wrap">
    <link rel="stylesheet" href="judge.css">

    <body>
        <form action="judge.php"  enctype="multipart/form-data" method="post">
            <input type="file" name="inputFile" id="register">
            <input type="submit" id="Gosign" name="go" value="アップロード">
        </form>
        <form method="POST">
            <button id="tableDelete" disabled>スタートリストを消す</button>
            <input type="hidden" name="mode" value="delete">
        </form>
        <form method="POST">
            <button id="tableReset">リセット</button>
            <input type="hidden" name="mode" value="reset">
        </form>
        <form action="group1.php">
            <button id="go" >審判No.1へ</button>
        </form>
        <form action="group2.php">
            <button id="go" >審判No.2へ</button>
        </form>
        <form action="group3.php">
            <button id="go" >審判No.3へ</button>
        </form>
        <form action="group4.php">
            <button id="go" >審判No.4へ</button>
        </form>
        <form action="group5.php">
            <button id="go" >審判No.5へ</button>
        </form>
        <form action="chiefJudge.php">
            <button id="go" >主審へ</button>
        </form>
        <form action="summary.php">
            <button id="go" >サマリーへ</button>
        </form>
        <?php 
            if($mode === "delete"){
                try{
                    $pdo = new PDO($dsn, $user, $password);
                    $sql = "TRUNCATE table judge1; TRUNCATE table judge2; TRUNCATE table judge3;
                    TRUNCATE table judge4; TRUNCATE table judge5; TRUNCATE table chiefJudge;";
                    $stmh = $pdo->prepare($sql);
                    $stmh->execute();
                    echo "スタートリストを削除しました";
                    $pdo = null;
                } catch (PDOException $e) {
                    echo 'データベースにアクセスできません!' . $e->getMessage();
                    exit;
                }   
            }
        ?>
        <script type="text/javascript" src="judge.js"></script>
    </body>