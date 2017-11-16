<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php if ($pages > 1 != true) return; ?>

   

<div class="pagination_wrap">
     <?php echo html_entity_decode($paginateForm) ?>
    <aside class="grid_1">
        <ul class="pagination">
            <?php
			
            if ($pages > 1) :
                echo getPageString('<li><a href="javascript:void(0)" onclick="paginate(xxpagexx)">xxpagexx</a></li>', $pages, $page, ' <li class="current"><a class="current" href="javascript:void(0)">xxpagexx</a></li>','',5,'<li class="prev button" ><a href="javascript:void(0);" onclick="paginate(xxpagexx);">Prev</a></li>', 
		'<li class="next button"><a href="javascript:void(0);" onclick="paginate(xxpagexx);">Next</a></li>');
            endif;
            ?>
        </ul>
    </aside>  

    <aside class="grid_2"><span class="info">Showing <?php echo $start_record;?> to <?php echo $end_record;?> of <?php echo $total_records;?> entries</span></aside>
    
</div>