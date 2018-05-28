<?php require VIEW_ROOT . '/templates/header.php'; ?>
<!-- Sind keine pages vorhanden, Message ausgeben. Ansonsten werden die Daten entsprechend angezeigt. -->
    <?php if(!$page): ?>
        <p>No page found, sorry.</p>
    <?php else: ?>
        <h2><?php echo e($page['title']); ?></h2>

        <?php echo e($page['body']); ?>

        <p style="color: #000;" class="faded">
            Created on <?php echo $page['created']->format('d M Y'); ?>
            <?php if($page['updated']): ?>
                Last updated <?php echo $page['updated']->format('d M Y H:i:s'); ?>
            <?php endif; ?>
        </p>
    <?php endif; ?>

<?php require VIEW_ROOT . '/templates/footer.php'; ?>