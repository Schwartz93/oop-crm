<?php require VIEW_ROOT . '/templates/header.php'; ?>
<!-- Head, Body und Footer sind aufgesplittet und werden eingebunden. Hier: Body -->
    <?php if(empty($pages)): ?>
        <p>Sorry, no pages at the moment.</p>
    <?php else: ?>
<!-- Ausgabe der pages als liste -->
        <ul>
            <?php foreach($pages as $page): ?>
                <li><a href="<?php echo BASE_URL; ?>/page.php?page=<?php echo $page['slug'] ?>"><?php echo $page['label']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

<?php require VIEW_ROOT . '/templates/footer.php'; ?>