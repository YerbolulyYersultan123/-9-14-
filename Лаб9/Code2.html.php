<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Форма POST</title>
</head>
<body>
  <h2>Передача данных методом POST</h2>
  <form action="process_post.php" method="post">
    <label>Введите логин:</label><br>
    <input type="text" name="login"><br><br>
    <label>Введите пароль:</label><br>
    <input type="password" name="password"><br><br>
    <input type="submit" value="Войти">
  </form>
</body>

<head>
    <meta charset="UTF-8">
    <title>Вычисление среднего и выбор цвета</title>
</head>

<h2>1. Вычисление среднего арифметического</h2>
<form action="result.php" method="post">
    <label>Число 1: <input type="number" name="num1" step="any" required></label><br><br>
    <label>Число 2: <input type="number" name="num2" step="any" required></label><br><br>
    <label>Число 3: <input type="number" name="num3" step="any" required></label><br><br>
    
    <h2>2. Выберите цвет фона</h2>
    <select name="color">
        <option value="white">Белый</option>
        <option value="lightblue">Голубой</option>
        <option value="lightgreen">Зелёный</option>
        <option value="lightyellow">Жёлтый</option>
        <option value="lightpink">Розовый</option>
    </select><br><br>

    <input type="submit" value="Отправить">
</form>

</body>
</html>