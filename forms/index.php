<?php
require 'create-post.php';
?>
<?php
$result = 0;
$arg1 = 0;
$arg2 = 0;


//Напишем 4 математические функции:
function add($a, $b)
{
    return $a + $b;
}
function sub($a, $b)
{
    return $a - $b;
}
function mul($a, $b)
{
    return $a * $b;
}
function div($a, $b)
{
    //проверим деление на 0
    if ($b == 0) {
        return 'ошибка';
    }
    return $a / $b;
}

//Напишем функцию calculate
function calculate($arg1, $arg2, $operation)
{
    switch ($operation) {
        case "+":
            return add($arg1, $arg2);
        case '-':
            return sub($arg1, $arg2);
        case '*':
            return mul($arg1, $arg2);
        case '/':
            return div($arg1, $arg2);
        default:
            return 0;
    }
}
if (!empty($_POST)) {
    $arg1 = (float) ($_POST['arg1'] ?? 0);
    $arg2 = (float) ($_POST['arg2'] ?? 0);

    //TODO 1. сделайте 4 математические функции + - * /
    //TODO 2. сделайте одну общую функцию calculate(2,2,'+') которая вычислит нужное значение используя эти 4 функции
    if (isset($_POST['operation'])) {
        $operation = $_POST['operation'];
        $result = calculate($arg1, $arg2, $operation);
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <h3>Введите значения</h3>
        <input type="text" name="arg1" size="5" value="<?= $arg1 ?>">
        <input type="text" name="arg2" size="5" value="<?= $arg2 ?>">
        =
        <input type="text" readonly size="5" value="<?= $result ?>">
        <br>
        <h3>Выберите действие</h3>
        <input type="submit" name="operation" value="+">
        <input type="submit" name="operation" value="-">
        <input type="submit" name="operation" value="*">
        <input type="submit" name="operation" value="/">
    </form>
</body>
</html>