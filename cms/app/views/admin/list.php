<?php require VIEW_ROOT . '/templates/header.php'; ?>

    <?php if(empty($pages)): ?>
        <p>No pages at the moment.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pages as $page): ?>
                    <tr>
                        <td><?php echo e($page['label']); ?></td>
                        <td><?php echo e($page['title']); ?></td>
                        <td><a href="<?php echo BASE_URL; ?>/page.php?page=<?php echo e($page['slug']); ?>"><?php echo e($page['slug']); ?></a></td>
                        <td><a href="">Edit</a></td>
                        <td><a href="">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>    

    <a href="<?php echo BASE_URL; ?>/admin/add.php">Add new page</a> 
<?php require VIEW_ROOT . '/templates/footer.php'; ?>