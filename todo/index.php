<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Todo App</title>
</head>
<body>
    <div class="list">
        <h1 class="header">To do.</h1>

        <ul class="items">
            <li> 
                <span class="item">Pick up shopping </span>
                <a href="#" class="done-button">Mark as done</a>
            </li>
            <li> 
                <span class="item done">Learn php </span>
            </li>
        </ul>

        <form action="add.php" class="item-add"  method="post">
            <input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
            <input type="submit" value="Add" class="submit">
        </form>
    </div>
</body> 
</html>