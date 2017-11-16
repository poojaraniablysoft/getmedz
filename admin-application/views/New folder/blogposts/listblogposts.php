<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <tr>
        <th width="6%">S. No.</th>
        <th>Post Title</th>
        <th>Post Category</th>
        <th>Publish Date</th>
        <th>Post Status</th>
        <th>Posted On</th>
        <?php if ($canedit === true) {
            echo '<th>Action</th>';
        } ?>
    </tr>
    <?php
    if (!$records || !is_array($records)) {
        echo "<tr><td colspan=4>No Record Found</td></tr>";
    } else {
        ?>
        <?php
        $i = $start_record;
        foreach ($records as $record) {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $record['post_title']; ?></td>
                 <td><?php echo $record['category_name']; ?></td>
                <td><?php echo displayDate($record['post_published']) ?></td>
                <td><?php echo ($record['post_status'] == 1) ? 'Published' : 'Draft'; ?></td>
                <td><?php echo displayDate($record['post_date_time']) ?></td>
                    <?php if ($canedit === true) { ?><td>
                        <?php
                        echo '<ul class = "actions">
               <li><a title = "Edit"  href = "' . generateUrl('blogposts', 'edit', array($record['post_id'])) . '" ><i class ="ion-edit icon"></i></a></li>
               <li><a title = "delete" onclick="return confirmDelete(this);" data-href = "' . generateUrl('blogposts', 'delete', array($record['post_id'])) . '" ><i class ="ion-close-circled icon"></i></a></li>
				</ul>';
                    }
                    ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </table>
    <div class="gap"></div>
    <?php 
    if ($pages > 1) {

      include getViewsPath() . 'backend-pagination.php'; 
    }
}
?>