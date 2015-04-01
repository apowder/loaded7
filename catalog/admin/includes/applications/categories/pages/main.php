<?php
/**
  @package    catalog::admin::applications
  @author     Loaded Commerce
  @copyright  Copyright 2003-2014 Loaded Commerce, LLC
  @copyright  Portions Copyright 2003 osCommerce
  @copyright  Template built on Developr theme by DisplayInline http://themeforest.net/user/displayinline under Extended license 
  @license    https://github.com/loadedcommerce/loaded7/blob/master/LICENSE.txt
  @version    $Id: main.php v1.0 2013-08-08 datazen $
*/
?>
<style scoped="scoped">
  .dataColCheck { text-align: center; }
  .dataColCategory { text-align: left; }
  .dataColStatus { text-align: center; }
  .dataColVisibility { text-align: center; }
  .dataColMode { text-align: left; }
  .dataColSort { text-align: left; }
  .dataColAction { text-align: right; }
  .dataTables_info { bottom: 42px; color:#4c4c4c; }
  .selectContainer { position:absolute; bottom:29px; left:30px }
</style>
<!-- Main content -->
<section role="main" id="main">
  <noscript class="message black-gradient simpler"><?php echo $lC_Language->get('ms_error_javascript_not_enabled_warning'); ?></noscript>
  <hgroup id="main-title" class="thin margin-bottom">
    <h1><?php echo $lC_Template->getPageTitle(); ?></h1>
  </hgroup>
  <div id="breadCrumbContainer">
    <div class="breadCrumbHolder">
      <div id="breadCrumb0" class="breadCrumb">
        <?php echo $breadcrumb_string; ?>
      </div>
    </div>
  </div>
  <div class="with-padding-no-top">
    <form name="batch" id="batch" action="#" method="post">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="table" id="dataTable">
      <thead>
        <tr>
          <th scope="col" class="hide-on-mobile align-left"><input onclick="toggleCheck();" id="check-all" type="checkbox" value="1" name="check-all"></th>
          <th scope="col" class="align-left"><?php echo $lC_Language->get('table_heading_categories'); ?></th>
          <th scope="col" class="align-left hide-on-mobile"><?php echo $lC_Language->get('table_heading_status'); ?></th>
          <th scope="col" class="align-left hide-on-mobile"><?php echo $lC_Language->get('table_heading_visibility'); ?></th>
          <th scope="col" class="align-left hide-on-mobile"><?php echo $lC_Language->get('table_heading_mode'); ?></th>
          <th scope="col" class="align-left hide-on-mobile"><?php echo $lC_Language->get('table_heading_sort_order'); ?></th>
          <th scope="col" class="align-right">
           <span class="button-group compact" style="white-space:nowrap;">
             <a style="display:none;" style="cursor:pointer" class="on-mobile button with-tooltip icon-plus-round green<?php echo (((int)$_SESSION['admin']['access'][$lC_Template->getModule()] < 2) ? ' disabled' : NULL); ?>" href="<?php echo (((int)$_SESSION['admin']['access'][$lC_Template->getModule()] < 2) ? '#' : lc_href_link_admin(FILENAME_DEFAULT, $lC_Template->getModule() . '=' . (isset($_GET['categories']) ? $_GET['categories'] : '') . '&action=new')); ?>" title="<?php echo $lC_Language->get('button_new_category'); ?>"></a>
             <a href="javascript:void(0);" style="cursor:pointer" onclick="oTable.fnReloadAjax();" class="button with-tooltip icon-redo blue" title="<?php echo $lC_Language->get('button_refresh'); ?>"></a>
           </span>
           <span id="actionText">&nbsp;&nbsp;<?php echo $lC_Language->get('table_heading_action'); ?></span>
          </th>        
        </tr>
      </thead>
      <tbody class="sorted_table"></tbody>
      <tfoot>
        <tr>
          <th colspan="7">&nbsp;</th>
        </tr>
      </tfoot>
    </table>
    <div class="selectContainer">
      <select <?php echo (((int)$_SESSION['admin']['access'][$lC_Template->getModule()] < 4) ? NULL : 'onchange="doSelectFunction(this);"'); ?> name="selectAction" id="selectAction" class="select blue-gradient glossy<?php echo (((int)$_SESSION['admin']['access'][$lC_Template->getModule()] < 4) ? ' disabled' : NULL); ?>">
        <!-- VQMOD-hookpoint; DO NOT MODIFY OR REMOVE THE LINE BELOW -->
        <option value="0" selected="selected"><?php echo $lC_Language->get('text_with_selected'); ?></option>
        <option value="move"><?php echo $lC_Language->get('text_move'); ?></option>
        <option value="delete"><?php echo $lC_Language->get('text_delete'); ?></option>
      </select>
    </div>
    </form>
    <div class="clear-both"></div>
    <div class="six-columns twelve-columns-tablet">
      <div id="buttons-menu-div-listing">
        <div id="buttons-container" style="position: relative;" class="clear-both">
          <div style="float:right;">
            <p class="button-height" align="right">
              <?php
              $parentID = lC_Categories_Admin::getParent($_GET['categories']);
              if (!empty($_GET['categories']) && is_numeric($_GET['categories'])) {
                ?>
                <a class="button" href="<?php echo lc_href_link_admin(FILENAME_DEFAULT, $lC_Template->getModule() . (($parentID != '0') ? '=' . $parentID : NULL)); ?>">
                  <span class="button-icon anthracite-gradient">
                    <span class="icon-reply"></span>
                  </span><?php echo $lC_Language->get('button_back'); ?>
                </a>&nbsp;
                <?php
              }
              ?>
              <a class="button<?php echo (((int)$_SESSION['admin']['access'][$lC_Template->getModule()] < 2) ? ' disabled' : NULL); ?>" href="<?php echo (((int)$_SESSION['admin']['access'][$lC_Template->getModule()] < 2) ? '#' : lc_href_link_admin(FILENAME_DEFAULT, $lC_Template->getModule() . '=' . (isset($_GET['categories']) ? $_GET['categories'] : '') . '&action=new')); ?>">
                <span class="button-icon green-gradient">
                  <span class="icon-plus"></span>
                </span><?php echo $lC_Language->get('button_new_category'); ?>
              </a>&nbsp;
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $lC_Template->loadModal($lC_Template->getModule()); ?>
<!-- End main content -->