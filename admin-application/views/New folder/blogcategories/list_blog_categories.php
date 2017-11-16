<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table" id="category">
    <tr class="nodrag nodrop">       
        <th>Category Title</th>
    <!--    <th>Parent Category</th>
        <th>Category Display Order</th>-->
        <th>Category Status</th>
        <?php
        if ($canedit === true) {
            echo '<th>Action</th>';
        }
        ?>
    </tr>
    <?php
    if (!$records || !is_array($records)) {
        echo ' <tr> <td colspan=5> No Record Found!! </td></tr>';
    }
    $i = $start_record;
    foreach ($records as $record) {
        ?>
        <tr id="<?php echo $record['category_id']; ?>" class="<?php echo ($record['category_status'] == 1) ? '' : 'inactive nodrag nodrop'; ?>">           
            <td><?php echo $record['category_title']; ?></td>
          
            <td><?php echo ($record['category_status'] == 1) ? 'Active' : 'Inactive'; ?></td>

                <?php if ($canedit === true) { ?><td><?php
                    echo'<ul class = "actions">
               <li><a title = "Edit"  href = "' . generateUrl('blogcategories', 'add', array($record['category_id'],$category_parent)) . '" ><i class ="ion-edit icon"></i></a></li>';
                    if ($record['category_status'] == 1) {
                        echo '<li><a title = "Manage Sub Categories"  href = "' . generateUrl('blogcategories', 'blogchildcategories', array($record['category_id'])) . '"><i class ="ion-drag icon"></i></a></li>';
                    }

                    echo '</ul>';
                } echo "</td>";
                ?>
        </tr>
        <?php
        $i++;
    }
    ?>
</table>
<?php  include getViewsPath() . 'backend-pagination.php'; ?>

<script>
    /* $(document).ready(function () {
		if($('#category table').html()){
			
		}
			$('#category').tableDnD({
				onDrop: function (tbody, row) {
					var order = $.tableDnD.serialize('id');
					order += '&catId=' + catId;
					 
					callAjax(generateUrl('blogcategories', 'setCatDisplayOrder'), order, function (t) {

					});
				}

			});
        //Table DND call
    });
 */
</script>