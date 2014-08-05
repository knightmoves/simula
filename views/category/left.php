        <div id="submaincontent" class="categoriespage">
          <div class="categoriessidenav"><h1>Categories </h1>
            <ul>
				<?php foreach ($categories as $category_items): ?>
					<li><a href="<?=base_url()?>category/show/<?php echo $category_items['cat_id'] ?>"><?php echo $category_items['cat_name'] ?></a></li>
				<?php endforeach ?>
			</ul>
		</div>	
