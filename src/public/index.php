<form method="post">
    <label for="infix" style="font-weight: bold;">Infix:</label>
    <input type="text" name="infix" id="infix" required>
    <button type="submit">Calculate</button>
</form>

<?php

require __DIR__ . '/../vendor/autoload.php';

use Calculator\Calculator;

try {
    if (!empty($_POST['infix'])) {
        $calculator = new Calculator();
        $result = $calculator->calculate($_POST['infix'], Calculator::EVAL_CALCULATOR_TYPE);
        echo $_POST['infix'] . ' = ' . $result;
    }
} catch (Exception $exception) {
    echo $exception->getMessage();
}
