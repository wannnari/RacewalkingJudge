<?php
$dsn = 'mysql:host=localhost;dbname=******;charsetr=utf8';
$user = '******';
$password = '******';
$mode = htmlspecialchars(filter_input(INPUT_POST,'mode'));
$reload = htmlspecialchars(filter_input(INPUT_POST,'reload'));
if($reload == "リロード"){
    $_POST['pF'] = "";
}



// 1.データベースをテーブルに反映→２に続く
try {
    $pdo = new PDO($dsn, $user, $password);
    $table_data = array();
    $sql = "SELECT DISTINCT j1.ord, j1.id, j1.name, j1.Belongs,j1.YellowBent AS j1_YB, j1.YellowLoss AS j1_YL,
    j1.RedCard AS j1_RC, j1.RedTime AS j1_RT,
    j2.YellowBent AS j2_YB, j2.YellowLoss AS j2_YL, j2.RedCard AS j2_RC, j2.RedTime AS j2_RT,
    j3.YellowBent AS j3_YB, j3.YellowLoss AS j3_YL, j3.RedCard AS j3_RC, j3.RedTime AS j3_RT,
    j4.YellowBent AS j4_YB, j4.YellowLoss AS j4_YL, j4.RedCard AS j4_RC, j4.RedTime AS j4_RT,
    j5.YellowBent AS j5_YB, j5.YellowLoss AS j5_YL, j5.RedCard AS j5_RC, j5.RedTime AS j5_RT,
    cj.RedCard AS cj_RC, cj.RedTime AS cj_RT
    FROM judge1 AS j1 INNER JOIN judge2 AS j2
    ON j1.id = j2.id 
    INNER JOIN judge3 AS j3 ON j1.id = j3.id
    INNER JOIN judge4 AS j4 ON j1.id = j4.id
    INNER JOIN judge5 AS j5 ON j1.id = j5.id
    INNER JOIN chiefJudge AS cj ON j1.id = cj.id
    ORDER BY j1.ord;";
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
        <h1>サマリー</h1>   
        <form method="POST">
            <input type="submit" id="reloadBtn" name="reload" value="リロード"/>
        </form>

        <table class="csv_list" id="csv_table">
                <thead class="judgeNo">
                <th class="_sticky" colspan="4"></th>
                <th colspan="4">審判NO.1</th>
                <th colspan="4">審判NO.2</th>
                <th colspan="4">審判NO.3</th>
                <th colspan="4">審判NO.4</th>
                <th colspan="4">審判NO.5</th>
                <th colspan="2">主審</th>
                <th colspan="3">枚数</th>
                </thead>
                <thead class="table_head">
                    <th class="info _sticky1" id="ord">ORD.</th>
                    <th class="info _sticky2" id="no">NO.</th>
                    <th class="info _sticky3" id="name_table">選手名</th>
                    <th class="info _sticky4">所属</th>
                    <th id="yellow">></th>
                    <th id="yellow">~</th>
                    <th id="red">RC</th>
                    <th id="red">Time</th>
                    <th id="yellow">></th>
                    <th id="yellow">~</th>
                    <th id="red">RC</th>
                    <th id="red">Time</th>
                    <th id="yellow">></th>
                    <th id="yellow">~</th>
                    <th id="red">RC</th>
                    <th id="red">Time</th>
                    <th id="yellow">></th>
                    <th id="yellow">~</th>
                    <th id="red">RC</th>
                    <th id="red">Time</th>
                    <th id="yellow">></th>
                    <th id="yellow">~</th>
                    <th id="red">RC</th>
                    <th id="red">Time</th>
                    <th id="red">RC</th>
                    <th id="red">Time</th>
                    <th id="red">枚数</th>
                    <th id="red">理由</th>
                    <th id="red">Time</th>
                </thead>
            
            <tbody>
                <?php
                // 2.データベースをテーブルに反映させる
                $num = 0;
                while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
                    $cnt = 0;
                    $bCnt = 0;
                    $lCnt = 0;
                    $num++;
                ?>
                    <tr>
                            <td class="_sticky1"> <?= htmlspecialchars($row['ord']) ?></td>
                            <td class="_sticky2"><div id=<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['id']) ?></td>
                            <td class="textcenter _sticky3"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="textcenter _sticky4"><?= htmlspecialchars($row['Belongs']) ?></td>
                        <td class="textcenter">
                            <div id=Bent<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j1_YB'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Loss<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j1_YL'],0,5) ?>                    
                        </td>
                        <td class="textcenter">
                            <?php 
                            if($row['j1_RC'] == "～"){
                                $lCnt++;
                            }else if($row['j1_RC'] == ">"){
                                $bCnt++;
                            }
                            ?>
                            <div id=Red<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['j1_RC']) ?>
                        </td>
                        <td class="textcenter">

                            <div id=Time<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j1_RT'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Bent<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j2_YB'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Loss<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j2_YL'],0,5) ?>                    
                        </td>
                        <td class="textcenter">
                            <?php 
                            if($row['j2_RC'] == "～"){
                                $lCnt++;
                            }else if($row['j2_RC'] == ">"){
                                $bCnt++;
                            }
                            ?>
                            <div id=Red<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['j2_RC']) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Time<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j2_RT'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Bent<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j3_YB'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Loss<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j3_YL'],0,5) ?>                    
                        </td>
                        <td class="textcenter">
                            <?php 
                            if($row['j3_RC'] == "～"){
                                $lCnt++;
                            }else if($row['j3_RC'] == ">"){
                                $bCnt++;
                            }
                            ?>
                            <div id=Red<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['j3_RC']) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Time<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j3_RT'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Bent<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j4_YB'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Loss<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j4_YL'],0,5) ?>                    
                        </td>
                        <td class="textcenter">
                            <?php 
                            if($row['j4_RC'] == "～"){
                                $lCnt++;
                            }else if($row['j4_RC'] == ">"){
                                $bCnt++;
                            }
                            ?>
                            <div id=Red<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['j4_RC']) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Time<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j4_RT'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Bent<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j5_YB'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Loss<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j5_YL'],0,5) ?>                    
                        </td>
                        <td class="textcenter">
                            <?php
                            if($row['j5_RC'] == "～"){
                                $lCnt++;
                            }else if($row['j5_RC'] == ">"){
                                $bCnt++;
                            }
                            ?>
                            <div id=Red<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['j5_RC']) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Time<?= htmlspecialchars($num) ?>></div><?php echo substr($row['j5_RT'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <?php
                             if($row['cj_RC'] != ""){
                                $cnt++;
                            }
                            ?>
                            <div id=Red<?= htmlspecialchars($num) ?>></div><?= htmlspecialchars($row['cj_RC']) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Time<?= htmlspecialchars($num) ?>></div><?php echo substr($row['cj_RT'],0,5) ?>
                        </td>
                        <td class="textcenter">
                            <div id=Count></div>
                            <?php
                            $cntTotal = $lCnt + $bCnt + $cnt; 
                            echo $cntTotal; 
                            ?>
                        </td>
                        <td class="textcenter">
                            <div id=Reason>
                            <?php 
                            if($lCnt >= 3 && $bCnt == 0){
                                echo "K1";
                            }else if($bCnt >= 3 && $lCnt == 0){
                                echo "K2";
                            }else if($cntTotal >= 3 && $bCnt >= 1 && $lCnt >= 1){
                                echo "K3";
                            }else if($row['cj_RC'] == "～"){
                                echo "K4";
                            }else if($row['cj_RC'] == ">"){
                                echo "K5";
                            }
                            ?>
                            </div>
                        </td>
                        <td class="textcenter">
                            <div id=Time<?= htmlspecialchars($num) ?>></div>
                        </td>
                        <?php
                        }
                        // データベース接続解除
                        $pdo = null;
                        ?>            
                    </tr>   
            </tbody>
        </table>
        <script type="text/javascript" src="judge.js"></script>
    </body>
</div>