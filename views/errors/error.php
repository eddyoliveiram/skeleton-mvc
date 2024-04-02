<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }
        .error-container {
            text-align: center;
        }
        .error-message {
            font-size: 2em;
            /*color: #ff6b6b;*/
        }
        .error-details {
            margin-top: 16px;
            font-size: 1.2em;
            color: #333;
        }
    </style>
</head>
<body>
<div class="error-container">
    <div class="error-message">
        <?php echo ($message); ?>
    </div>
    <div class="error-details">
        <p>Something went wrong.</p>
    </div>
</div>
</body>
</html>
