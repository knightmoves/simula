<?php foreach ($categories as $category_items): ?>

    <h2><?php echo $category_items['cat_name'] ?></h2>
    <div id="main">
        <?php echo $category_items['cat_name'] ?>
    </div>
    <p><a href="category/<?php echo $category_items['cat_name'] ?>">View article</a></p>
<?php endforeach ?>
