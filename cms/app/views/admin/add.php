<?php require VIEW_ROOT . '/templates/header.php'; ?>

    <h2>Add page</h2>

    <form action="<?php echo BASE_URL; ?>/admin/add.php" method="post" autocomplete="Off">
        <label for="title">
            Title
            <input type="text" name="title" id="title">
        </label>

        <label for="label">
            Label
            <input type="text" name="label" id="label">
        </label>

        <label for="slug">
            Slug
            <input type="text" name="slug" id="slug">
        </label>

        <label for="body">
            Body 
            <textarea name="body" id="body" cols="30" rows="10"></textarea>
        </label>

        <input type="submit" value="Add Page">
    </form>

<?php require VIEW_ROOT . '/templates/footer.php'; ?>