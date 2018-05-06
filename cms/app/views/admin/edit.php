<?php require VIEW_ROOT . '/templates/header.php'; ?>
<!-- Ausgabe der Edit Funktion. Input wird weitergeleitet zu /admin/edit.php -->
    <h2>Edit page</h2>

    <form action="<?php echo BASE_URL; ?>/admin/edit.php" method="post" autocomplete="Off">
        <label for="title">
            Title
            <input type="text" name="title" id="title" value="<?php echo e($page['title']); ?>">
        </label>

        <label for="label">
            Label
            <input type="text" name="label" id="label" value="<?php echo e($page['label']); ?>">
        </label>

        <label for="slug">
            Slug
            <input type="text" name="slug" id="slug" value="<?php echo e($page['slug']); ?>">
        </label>

        <label for="body">
            Body 
            <textarea name="body" id="body" cols="30" rows="10"><?php echo e($page['body']); ?></textarea>
        </label>
<!-- Hidden input bekommt die page id als value mit. -->
        <input type="hidden" name="id" value="<?php echo e($page['id']); ?>">

        <input type="submit" value="Edit Page">
    </form>

<?php require VIEW_ROOT . '/templates/footer.php'; ?>