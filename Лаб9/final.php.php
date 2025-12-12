<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты вычислений</title>
    <?php

    $color = $_POST['color'] ?? 'white';
    ?>
    <style>
        body {
            background-color: <?= htmlspecialchars($color) ?>;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>

<?php
$num1 = $_POST['num1'] ?? 0;
$num2 = $_POST['num2'] ?? 0;
$num3 = $_POST['num3'] ?? 0;

$average = ($num1 + $num2 + $num3) / 3;

$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (stripos($user_agent, 'Chrome') !== false) {
    $browser = "Google Chrome";
} elseif (stripos($user_agent, 'Safari') !== false) {
    $browser = "Safari";
} elseif (stripos($user_agent, 'MSIE') !== false || stripos($user_agent, 'Trident') !== false) {
    $browser = "Internet Explorer";
} else {
    $browser = "Неизвестный браузер";
}
?>

<h2>Результаты</h2>
<p>Среднее арифметическое чисел (<?= $num1 ?>, <?= $num2 ?>, <?= $num3 ?>): <strong><?= round($average, 2) ?></strong></p>
<p>Вы выбрали цвет фона: <strong><?= htmlspecialchars($color) ?></strong></p>
<p>Вы используете браузер: <strong><?= $browser ?></strong></p>

</body>
</html>