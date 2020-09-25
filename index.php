<?php
    $comments = file_get_contents('comments/comments.txt');
    $error = false;
    if (isset($_POST['submit'])) {
        $name = htmlspecialchars($_POST['name']);
        $text = htmlspecialchars($_POST['text']);
        if ($name && $text) {
            $text = str_replace("\r\n", "<br/>", $text);
            file_put_contents('comments/comments.txt', $comments . "\n" . $name . "\"" . $text);
            header("Location: index.php");
            exit;
        } else {
            $error = true;
        }
    }
    $comments = explode("\n", $comments);
    $result = [];
    $i = 0;
    foreach ($comments as $comment) {
        $temp = explode("\"", $comment);
        $result[$i]['name'] = $temp[0];
        $result[$i]['text'] = $temp[1];
        $i++;
    }
    $result = array_reverse($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гостевая книга</title>
</head>
<body>
    <h1>Оставить запись</h1>
    <?php if ($error) { ?> <p>Зополните все поля!</p> <?php } ?>
    <form name="add_comment" action="index.php" method="post">
        <div>Ваше имя: <input type="text" name="name" id="name"></div>
        <div>Ваш комментарий: <br/> <textarea name="text" id="text" cols="30" rows="10"></textarea></div>
        <div><input type="submit" name="submit" value="Отправить"></div>
    </form>
    <h2>Оставленные комментарие:</h2>
    <?php foreach($result as $r) { ?>
        <p><b><?=$r['name']?></b>: <?=$r['text']?></p>
    <?php } ?>
</body>
</html>