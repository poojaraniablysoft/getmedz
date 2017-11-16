<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php /* if ($pages > 1 != true) return; */ ?>

   

<div class="footinfo">
     <?php echo html_entity_decode($paginateForm) ?>
    <aside class="grid_1">
        <ul class="pagination">
            <?php
            if ($pages > 1) :
                echo getPageString('<li><a href="javascript:void(0)" onclick="paginate(xxpagexx)">xxpagexx</a></li>', $pages, $page, ' <li class="selected"><a href="javascript:void(0)">xxpagexx</a></li>');
            endif;
            ?>
        </ul>
    </aside>  

    <aside class="grid_2"><span class="info">Showing <?php echo $start_record;?> to <?php echo $end_record;?> of <?php echo $total_records;?> entries</span></aside>
    
</div>