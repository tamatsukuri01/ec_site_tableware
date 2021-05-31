<h2 class="my-4">Categories</h2>
<div class="list-group">
  <?php foreach($categories as $category) {?>
    <a class="list-group-item list-group-item-action " href="category.php?category_id=<?php print h($category['item_type']); ?>&sort=<?php print h($sort); ?>">
      <?php print h($category['item_type']); ?>
    </a>
  <?php } ?>
</div>
