        <span class="categoriessidenavbottom"></span>
        <div class="categoriesthumbs">
        <span class="categoriesthumbstopbg"></span>
            <ul>
				<?php foreach ($videos as $item): 
					$vidID		= $item["vid_id"];
					$vidTitle	= $item["vid_title"];
					$vidEmbedImg	= $item["vid_embed_img"];
					$src = ($vidEmbedImg!="")? $vidEmbedImg : "images/index_sample_thumbs_new.jpg";
				?>
            	<li>
					
					<img src="<?=$src?>" alt="" /></a>
					<span class="categoriesthumbstitle">
						<a href="<?=base_url()?>category/show/<?php echo $item['cat_id'] ?>"><?=$item["cat_name"]?></a>
					</span>
                </li>
				<?php endforeach ?>

			</ul>
		</span>		
