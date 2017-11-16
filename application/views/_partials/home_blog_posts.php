 <div class="section section--blog--post"  >
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12 span--center">
          <hgroup>
            <h5 class="heading-text text--center "><?php echo getLabel('L_Latest_Posts');?></h5>
            <h6 class="sub-heading-text text--center "><?php echo getLabel('L_Recent_News');?></h6>
          </hgroup>
        </div>
        <div class="blog--media ">
		<?php foreach ($blog_posts as $record) {
        ?>
          <div class="blog__post">
            <div class="blog__post_content"> <a href="<?php echo generateUrl('blog', 'post', array($record['post_seo_name'])); ?>" class="post__image"> <img src="<?php echo generateUrl('image', 'post', array('large', $record['post_image_file_name'])); ?>" alt=""> </a>
              <div class="post__content">
                <div class="post__date"><?php $date_pub = strtotime($record['post_published']); echo date("F j, Y", $date_pub); ?> </div>
                <a href="<?php echo generateUrl('blog', 'post', array($record['post_seo_name'])); ?>" class="post__title"><?php echo ucfirst(subStringByWords($record['post_title'], 40)); ?> </a>
                <div class="post__description">
                  <p><?php echo subStringByWords($record['post_short_description'], 150); ?></p>
                </div>
                <a class="button button--fill button--orange" href="<?php echo generateUrl('blog', 'post', array($record['post_seo_name'])); ?>"><?php echo getLabel('L_Read_More');?></a> </div>
            </div>
          </div>
		<?php } ?>
          
        </div>
      </div>
    </div>
  </div>