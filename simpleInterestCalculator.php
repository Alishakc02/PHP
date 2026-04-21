<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Interest Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #fff;
        }
        .calculator {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            border: 2px solid #4a3c8c;
            border-radius: 15px;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .calculator h2 {
            margin: 0 0 20px 0;
            font-size: 20px;
            text-align: center;
        }
        .input-field label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }
        .input-field input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .result, .total {
            margin: 10px 0;
            font-size: 14px;
            color: #333;
        }
        .error {
            margin: 10px 0;
            color: red;
            font-size: 14px;
        }
        .calculate-btn {
            width: 100%;
            padding: 12px;
            background-color: #4a3c8c;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .calculate-btn:hover {
            background-color: #3a2d6b;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h2>Simple Interest</h2>
        <form method="POST" action="" onsubmit="return validateForm()">
            <div class="input-field">
                <label for="principal">Principal</label>
                <input type="number" name="principal" id="principal" value="<?php echo isset($_POST['principal']) ? htmlspecialchars($_POST['principal']) : ''; ?>" placeholder="Enter principal amount" step="0.01" required>
            </div>
            <div class="input-field">
                <label for="rate">Rate Of Interest</label>
                <input type="number" name="rate" id="rate" value="<?php echo isset($_POST['rate']) ? htmlspecialchars($_POST['rate']) : ''; ?>" placeholder="Enter rate of interest (%)" step="0.01" required>
            </div>
            <div class="input-field">
                <label for="time">Time</label>
                <input type="number" name="time" id="time" value="<?php echo isset($_POST['time']) ? htmlspecialchars($_POST['time']) : ''; ?>" placeholder="Enter time (years)" step="0.01" required>
            </div>

            <?php
            // Initialize variables
            $interest = '';
            $total = '';
            $error = '';

            // Only process the form if it was submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calculate'])) {
                // Get the input values
                $principal = isset($_POST['principal']) ? trim($_POST['principal']) : '';
                $rate = isset($_POST['rate']) ? trim($_POST['rate']) : '';
                $time = isset($_POST['time']) ? trim($_POST['time']) : '';

                // Server-side validation
                if (empty($principal) || empty($rate) || empty($time)) {
                    $error = "Error: All fields are required!";
                }
                elseif (!is_numeric($principal) || !is_numeric($rate) || !is_numeric($time)) {
                    $error = "Error: Please enter valid numbers!";
                }
                elseif ($principal <= 0 || $rate <= 0 || $time <= 0) {
                    $error = "Error: Values must be greater than zero!";
                }
                else {
                    // Convert to float for calculation
                    $principal = floatval($principal);
                    $rate = floatval($rate);
                    $time = floatval($time);

                    // Calculate simple interest
                    $interest = ($principal * $rate * $time) / 100;
                    $total = $principal + $interest;

                    // Format the results
                    $interest = number_format($interest, 2);
                    $total = number_format($total, 2);
                }

                // Display the result or error
                if ($error) {
                    echo "<div class='error'>$error</div>";
                } else {
                    echo "<div class='result'>Interest: $interest</div>";
                    echo "<div class='total'>Total Plus Interest: $total</div>";
                }
            }
            ?>
            <button type="submit" name="calculate" class="calculate-btn">Calculate</button>
        </form>
    </div>

    <script>
        // Client-side validation
        function validateForm() {
            const principal = document.getElementById('principal').value;
            const rate = document.getElementById('rate').value;
            const time = document.getElementById('time').value;

            // Check if inputs are empty
            if (principal === '' || rate === '' || time === '') {
                alert('All fields are required!');
                return false;
            }

            // Check if inputs are valid numbers
            if (isNaN(principal) || isNaN(rate) || isNaN(time)) {
                alert('Please enter valid numbers!');
                return false;
            }

            // Check if values are greater than zero
            if (parseFloat(principal) <= 0 || parseFloat(rate) <= 0 || parseFloat(time) <= 0) {
                alert('Values must be greater than zero!');
                return false;
            }

            return true; // Proceed with form submission if all checks pass
        }
    </script>
</body>
</html>