<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма GET</title>
</head>
<body>
    <h2>Передача данных методом GET</h2>
    <form action="process_get.php" method="get">
        <label>Введите имя:</label><br>
        <input type="text" name="username"><br><br>
        <label>Возраст:</label><br>
        <input type="number" name="age"><br><br>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>