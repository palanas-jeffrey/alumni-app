<!-- Email Template: Account Activation -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
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
            <h2>Account Activation</h2>
        </div>
        <div class="content">
            <p>
                Dear {{ $name }},
            </p>
            <p>
                We are pleased to inform you that your account has been successfully activated. You can now access your account and start exploring its features.
            </p>
            <p>
                To visit the page, please click the link below and log in with your credentials:
            </p>
            <p>
                <a href="{{ $appLink }}">**Click here to log in**</a>
            </p>
            <p>
                If you encounter any issues during the login process, please don't hesitate to contact our support team.
            </p>
            <p>
                Thank you for joining our Alumni.
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