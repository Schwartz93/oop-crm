<?php 
require_once 'app/init.php';

$itemsQuery = $db->prepare("
    SELECT id, name, done
    FROM items_todo
    WHERE user = :user
");

$itemsQuery->execute([
    'user' => $_SESSION['user_id']
]);

$items = $itemsQuery->rowCount() ? $itemsQuery : [];


?>
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

        <?php if (!empty($items)): ?>
        <ul class="items">
            <?php foreach($items as $item): ?>
                <li> 
                    <span class="item<?php echo $item['done'] ? ' done' : '' ?>"> <?php echo $item['name']; ?></span>
                        <?php if(!$item['done']): ?>
                    <a href="mark.php?as=done&item=<?php echo $item['id']?>" class="done-button">Mark as done</a>
                        <?php elseif(!$item['notdone']): ?>
                    <a href="mark.php?as=notdone&item=<?php echo $item['id']?>" class="not-done-button">UNDO</a>
                    <a href="mark.php?as=delete&item=<?php echo $item['id']?>" class="delete">Delete this Task</a>
                        <?php endif; ?>
                </li>
            <?php endforeach; ?>

        </ul>
        <?php else: ?>
            <p>You haven't added any items yet</p>
        <?php endif; ?>

        <form action="add.php" class="item-add"  method="post">
            <input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
            <input type="submit" value="Add" class="submit">
        </form>
    </div>
</body> 
</html>