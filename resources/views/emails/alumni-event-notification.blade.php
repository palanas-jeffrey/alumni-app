<!-- Email Template: Event Notification -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Notification</title>
    <style>
        /* Basic styling for the email template */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .content {
            padding: 20px;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Event Notification</h2>
        </div>
        <div>
            <p>
                Dear {{ $name }},
            </p>
        </div>
        <div class="content">
            <p>
                {{ $messageContent }}
            </p>
        </div>
        <div class="footer">
            <p>
                Best regards,           
            </p>
            <p>
                CCI Alumni            
            </p>

        </div>
    </div>
</body>
</html>