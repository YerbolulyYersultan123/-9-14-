<?php
	if(isset($_GET['username'])&&isset($_GET['age'])) {
		$name=htmlspecialchars($_GET['username']);
		$age=(int)$_GET['age'];

		echo"<h3>Здравствуйте, $name!</h3>";
		echo"<p>Вам $age лет.!</p>";
	} else {
		echo"Пожалуйста, введите данные через форму.";
	}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    echo "<h3>Добро пожаловать, $login!</h3>";
    echo "<p>Ваш пароль: $password (никогда не храните так данные!)</p>";
} else {
    echo "Неверный метод запроса!";
}
?>
<?php
$name = htmlspecialchars($_REQUEST['username'] ?? 'Гость');
echo "Привет, $name!";