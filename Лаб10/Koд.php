<?php
function add($a, $b) { return $a + $b; }
function sub($a, $b) { return $a - $b; }
function mul($a, $b) { return $a * $b; }
function div($a, $b) {
    if ($b == 0) return "Ошибка: деление на ноль!";
    return $a / $b;
}

$a = 10;
$b = 5;

echo "Сложение: " . add($a, $b) . "<br>";
echo "Вычитание: " . sub($a, $b) . "<br>";
echo "Умножение: " . mul($a, $b) . "<br>";
echo "Деление: " . div($a, $b) . "<br>";
?>
<?php
function isPrime($n) {
    if ($n <= 1) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

echo "Проверка числа 7: " . (isPrime(7) ? "простое" : "непростое") . "<br>";
echo "Проверка числа 10: " . (isPrime(10) ? "простое" : "непростое") . "<br>";
?>
<?php
function reverseString($str) {
    $reversed = '';
    $len = mb_strlen($str, 'UTF-8');
    for ($i = $len - 1; $i >= 0; $i--) {
        $reversed .= mb_substr($str, $i, 1, 'UTF-8');
    }
    return $reversed;
}

echo "Оригинал: Саида<br>";
echo "Перевёрнутая: " . reverseString("Саида") . "<br>";
?>
<?php
function average($arr) {
    if (count($arr) === 0) return 0;
    return array_sum($arr) / count($arr);
}

// Тест:
$numbers = [2, 4, 6, 8];
echo "Среднее значение массива [2,4,6,8]: " . average($numbers) . "<br>";
?>
<?php
function convertToUpper($arr) {
    return array_map('strtoupper', $arr);
}

$words = ["привет", "мир", "php"];
$result = convertToUpper($words);
echo "Результат: ";
print_r($result);
echo "<br>";
?>
<?php
$numbers = [1, 2, 3, 4, 5];
$squares = array_map(fn($n) => $n ** 2, $numbers);

echo "Квадраты чисел: ";
print_r($squares);
echo "<br>";
?>
