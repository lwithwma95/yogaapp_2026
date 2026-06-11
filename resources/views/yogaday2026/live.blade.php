<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#0f172a,#1e3a8a,#2563eb);
            color:#fff;
            text-align:center;
        }

        .container{
            max-width:700px;
            padding:40px;
        }

        .logo{
            font-size:70px;
            margin-bottom:20px;
        }

        h1{
            font-size:48px;
            margin-bottom:15px;
            font-weight:700;
        }

        p{
            font-size:20px;
            line-height:1.8;
            opacity:0.95;
        }

        .time{
            display:inline-block;
            margin-top:25px;
            padding:15px 35px;
            background:#ffffff;
            color:#1e3a8a;
            border-radius:50px;
            font-size:32px;
            font-weight:bold;
            box-shadow:0 10px 25px rgba(0,0,0,0.25);
        }

        .footer{
            margin-top:30px;
            font-size:15px;
            opacity:0.8;
        }

        @media(max-width:768px){
            h1{
                font-size:36px;
            }

            .time{
                font-size:24px;
                padding:12px 25px;
            }

            p{
                font-size:18px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="logo">🚀</div>

        <h1>We're Almost Ready!</h1>

        <p>
            The live registration page is currently being prepared.
            Please visit again when it goes live at:
        </p>

        <div class="time">
            12:00 PM
        </div>

        <div class="footer">
            Thank you for your patience.
        </div>
    </div>

</body>
</html>