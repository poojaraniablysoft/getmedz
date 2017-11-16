
<ul class="service-list">

<?php if(!empty($arr_listing))
{
	foreach($arr_listing as $service) {?>
	<li>
	<a href="javascript:;">
	  <div class="service--box">
		<i class="service--icon"> <img src="<?php echo generateUrl('image', 'medical_category', array($service['category_id'], 45, 45) ) ?>" alt=""> </i>
		<div class="service--title"><?php echo $service['category_name'];?> </div>
		<div class="service--description">
		  <p><?php echo $service['category_description'];?></p>
		</div>
	  </div>
	</a>
	</li>
<?php } } ?>
	
  </ul>
  <?php include getViewsPath() . 'pagination.php'; ?>
  <!--div class="pagination_wrap">
  <ul class="pagination">
	<li class="button"><a href="#">Prev</a></li>
	<li><a class="current" href="#">1</a></li>
	<li><a href="#">2</a></li>
	<li><a href="#">3</a></li>
	<li><a href="#">4</a></li>
	<li class="button"><a href="#">Next</a></li>
  </ul>
</div-->