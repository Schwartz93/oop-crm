<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Form</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="contact">
        <div class="panel">
            Errors will go in here
        </div>

        <form action="contact.php" method="post">
            <label for="name">Your Name *
                <input type="text" name="name" autocomplete="off">
            </label>
            <label for="name">Your Name *
                <input type="text" name="name" autocomplete="off">
            </label>
            <label for="name">Your Name *
                <textarea name="message" rows="8"></textarea>
            </label>

            <input type="submit" value="Send E-Mail">

            <p class="muted">* required</p>
        </form>
    </div>
</body>
</html>