<?php
/**
  @package    catalog::templates::boxes
  @author     Loaded Commerce
  @copyright  Copyright 2003-2014 Loaded Commerce, LLC
  @copyright  Portions Copyright 2003 osCommerce
  @copyright  Template built on DevKit http://www.bootstraptor.com under GPL license 
  @license    https://github.com/loadedcommerce/loaded7/blob/master/LICENSE.txt
  @version    $Id: html_four.php v1.0 2013-08-08 datazen $
*/
?>
<!--modules/boxes/html_four.php start-->
<div class="well" >
    <ul class="box-search list-unstyled list-indent-large">
      <li class="box-header small-margin-bottom"><?php echo $lC_Box->getTitle(); ?></li>
        <?php echo $lC_Box->getContent(); ?>
    </ul>
</div>
<!--modules/boxes/html_four.php end-->