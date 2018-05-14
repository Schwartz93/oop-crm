<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="../../authentication/authentication_css/main.css">
    <link rel="stylesheet" href="../css/main.css">
    <title>CMS/Blog</title>
</head>
<body onload="startTime()">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<p class="welcome">CMS/Blog<a class="navbar-brand"></a></p>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../../../../authentication/index.php"><img src="../../img/house.svg" width="30px" height="30px" alt="home_logo"><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    </ul>
    <span class="navbar-text">
        <a href="logout.php"><img width="60px" height="60px" src="../../img/exit.svg" alt="logout_logo"></a>
    </span>
  </div>
</nav>

<div class="date">
  <div class="today"><?php echo "Date: " . date("d/m/Y") . "<br>"; ?></div>
</div>
<script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('current_time').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
<div class="time">
  <div id="current_time"></div>
</div>
<body>
<!-- Fehlermeldung fals $pages leer ist bzw keine pages vorhanden sind. -->
    <?php if(empty($pages)): ?>
        <p>No pages at the moment.</p>
    <?php else: ?>
<!-- Ansonsten wird eine Tablle ausgegeben in der die Seiten (fallsverfügbar) samt titel und label sichtbar sind. -->
    <div class="list-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pages as $page): ?>
                    <tr>
                        <td><?php echo e($page['label']); ?></td>
                        <td><?php echo e($page['title']); ?></td>
<!-- Hier können die pages angzeigt, editiert oder gelöscht werden -->
                        <td><a href="<?php echo BASE_URL; ?>/page.php?page=<?php echo e($page['slug']); ?>"><?php echo e($page['slug']); ?></a></td>
                        <td><a href="<?php echo BASE_URL; ?>/admin/edit.php?id=<?php echo e($page['id']); ?>"><img src="../../img/writer.svg" with="30px" height="30px" alt="edit_logo"></a></td>
                        <td><a href="<?php echo BASE_URL; ?>admin/delete.php?id=<?php echo e($page['id']); ?>"><img src="../../img/delete.svg" with="30px" height="30px" alt="delete_logo"></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>   
<!-- Funktion um eine neue Seite hinzuzufügen -->
    <a href="<?php echo BASE_URL; ?>/admin/add.php"><img src="../../img/file.svg" width="50px" height="50px" alt="add_file_logo"><p>Add new page</p></a> 
    </div> 
<footer>
    <div class="footer">
        <div>
            <p class="copyright">CRM 2018 - Michael Schwartz</p>
        </div>
    </div>
</footer>
  </body>
</html>