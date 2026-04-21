<?php
// Initialize variables BEFORE any HTML output
$errorNum1 = '';
$errorNum2 = '';
$result = '';
$operation = '';
$num1 = $num2 = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = isset($_POST['num1']) ? $_POST['num1'] : '';
    $num2 = isset($_POST['num2']) ? $_POST['num2'] : '';

    $valid = true;

    if ($num1 === '') {
        $errorNum1 = "First number is required.";
        $valid = false;
    }

    if ($num2 === '') {
        $errorNum2 = "Second number is required.";
        $valid = false;
    }

    if ($valid && is_numeric($num1) && is_numeric($num2)) {
        $num1 = floatval($num1);
        $num2 = floatval($num2);

        if (isset($_POST['add'])) {
            $result = $num1 + $num2;
            $operation = "Addition";
        } elseif (isset($_POST['subtract'])) {
            $result = $num1 - $num2;
            $operation = "Subtraction";
        } elseif (isset($_POST['divide'])) {
            if ($num2 != 0) {
                $result = $num1 / $num2;
                $operation = "Division";
            } else {
                $result = "Error: Division by zero!";
            }
        } elseif (isset($_POST['multiply'])) {
            $result = $num1 * $num2;
            $operation = "Multiplication";
        }
    } elseif ($valid) {
        $result = "Error: Please enter valid numbers!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
        }
        .calculator {
            width: 300px;
            background-color: #f5f5f5;
            padding: 20px;
            border: 1px solid #000;
            border-radius: 5px;
            text-align: center;
        }
        .input-field input {
            box-sizing: border-box;
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 5px;
        }
        .error {
            color: red;
            font-size: 0.9em;
            text-align: left;
            display: block;
            margin-bottom: 10px;
        }
        .result {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
            text-align: left;
        }
        .input-container {
            display: grid;
            margin-top: 20px;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .input-container input[type="submit"] {
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <form method="POST" action="#" novalidate>
            <div class="input-field">
                <input type="number" name="num1" value="<?php echo htmlspecialchars($num1); ?>" placeholder="Enter first number">
                <span class="error"><?php echo $errorNum1; ?></span>

                <input type="number" name="num2" value="<?php echo htmlspecialchars($num2); ?>" placeholder="Enter second number">
                <span class="error"><?php echo $errorNum2; ?></span>
            </div>

            <?php
            if ($operation && is_numeric($result)) {
                echo "<div class='result'>$operation: $result</div>";
            } elseif ($result) {
                echo "<div class='result'>$result</div>";
            }
            ?>

            <div class="input-container">
                <input type="submit" name="add" value="Add">
                <input type="submit" name="subtract" value="Subtract">
                <input type="submit" name="divide" value="Divide">
                <input type="submit" name="multiply" value="Multiply">
            </div>
        </form>
    </div>
</body>
</html>
