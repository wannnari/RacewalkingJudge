<?php
$dsn = 'mysql:host=localhost;dbname=******;charsetr=utf8';
$user = '******';
$password = '******';
$mode = htmlspecialchars(filter_input(INPUT_POST,'mode'));
$reload = htmlspecialchars(filter_input(INPUT_POST,'reload'));
$flag = 'Y';
if($reload == "リロード"){
    $_POST['pF'] = "";
}

// 報告完了したらフラグをYに変更する
if($mode === 'update'){
    try {
        $pdo = new PDO($dsn, $user, $password);
        $sql = "UPDATE judge1,judge2,judge3,judge4,judge5,chiefJudge SET ReportFlag = :flag WHERE id = :tNum ;";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':flag',$flag,PDO::PARAM_STR);
        $stmh->bindValue(':tNum',$flag,PDO::PARAM_STR);
        $stmh->execute();  
        $pdo = null;
    } catch (PDOException $e) {
        echo 'データベースにアクセスできません!' . $e->getMessage();
        exit;
    }
}

// 1.データベースをテーブルに反映→２に続く
try {
    $pdo = new PDO($dsn, $user, $password);
    $table_data = array();
    $sql = "SELECT id, RedCard, RedTime, '1' AS judgeNo FROM judge1 WHERE RedCard IS NOT NULL
            UNION ALL
            SELECT id, RedCard, RedTime, '2' AS judgeNo FROM judge2 WHERE RedCard IS NOT NULL
            UNION ALL
            SELECT id, RedCard,RedTime, '3' AS judgeNo FROM judge3 WHERE RedCard IS NOT NULL
            UNION ALL
            SELECT id, RedCard,RedTime, '4' AS judgeNo FROM judge4 WHERE RedCard IS NOT NULL
            UNION ALL
            SELECT id, RedCard,RedTime, '5' AS judgeNo FROM judge5 WHERE RedCard IS NOT NULL
            ORDER BY CAST(RedTime AS TIME) ASC;";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
} catch (PDOException $e) { 
    echo 'データベースにアクセスできません!' . $e->getMessage();
    exit;
}
?>

<div class="wrap">
    <link rel="stylesheet" href="summary.css">
    <body>
        <h1>レコーダー</h1>   
        <form method="POST">
            <input type="submit" id="reloadBtn" name="reload" value="リロード"/>
        </form>

        <table class="csv_list" id="csv_table">
                <thead class="judgeNo">
                <th>No.</th>
                <th>審判No.</th>
                <th>選手No.</th>
                <th>理由</th>
                <th>時刻</th>
                </thead>           
            <tbody>
                <?php
                // 2.データベースをテーブルに反映させる
                $num = 0;
                while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
                    $num++;
                ?>
                    <tr >
                        <td class="<?= $num ?>"><?php echo $num; ?></td>
                        <td class="<?= $num ?>"><?= htmlspecialchars($row['judgeNo']) ?></td>
                        <td class="<?= $num ?>"><div id=<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['id']) ?></td>
                        <td class="textcenter <?= $num ?>">
                            <div id=Red<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['RedCard']) ?>
                        </td>
                        <td class="textcenter <?= $num ?>">
                            <div id=Time<?= htmlspecialchars($num) ?>></div><?php echo substr($row['RedTime'],0,5) ?>
                        </td>
                        <td class="<?= $num ?>">
                            <form  method="post">
                                <input type="hidden" name="mode" value="update">
                                <input type="button" id="reportComplete" value="報告完了" onclick="reportComplete_click(<?=$num ?>)">
                            </form>
                        </td>
                        <?php
                        }
                        // データベース接続解除
                        $pdo = null;
                        ?>            
                    </tr>   
            </tbody>
        </table>
        <script type="text/javascript" src="record.js"></script>
    </body>
</div>