<?php

?>

<div class="wrap">
    <link rel="stylesheet" href="style.css">
<h1>HOME</h1>
    <body>
        <form action="group1v.php">
            <button id="go_group1" >group1</button>
        </form>
        <form action="group2v.php">
            <button id="go_group1" >group2</button>
        </form>
        <form action="group3v.php">
            <button id="go_group1" >group3</button>
        </form>
        <form action="group4v.php">
            <button id="go_group1" >group3</button>
        </form>
        <form action="group5v.php">
            <button id="go_group1" >group4</button>
        </form>
        <form action="group6v.php">
            <button id="go_group1" >group5</button>
        </form>
        <form method="POST">
            <button id="tableDelete">スタートリストを消す</button>
            <input type="hidden" name="mode" value="delete">
        </form>
        <form method="POST">
            <button id="tableReset">リセット</button>
            <input type="hidden" name="mode" value="reset">
        </form>

        <script type="text/javascript" src="judge.js"></script>
    </body>

</div>