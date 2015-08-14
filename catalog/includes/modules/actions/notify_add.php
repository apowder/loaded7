<?php
/**
  @package    catalog::modules::actions
  @author     Loaded Commerce
  @copyright  Copyright 2003-2014 Loaded Commerce, LLC
  @copyright  Portions Copyright 2003 osCommerce
  @license    https://github.com/loadedcommerce/loaded7/blob/master/LICENSE.txt
  @version    $Id: notify_add.php v1.0 2013-08-08 datazen $
*/
class lC_Actions_notify_add {
  function execute() {
    global $lC_Database, $lC_Session, $lC_NavigationHistory, $lC_Customer;

    if (!$lC_Customer->isLoggedOn()) {
      $lC_NavigationHistory->setSnapshot();

      lc_redirect(lc_href_link(FILENAME_ACCOUNT, 'login', 'AUTO'));

      return false;
    }

    $notifications = array();

    if (isset($_GET['products']) && !empty($_GET['products'])) {
      $products_array = explode(';', $_GET['products']);

      foreach ($products_array as $product_id) {
        if (is_numeric($product_id) && !in_array($product_id, $notifications)) {
          $notifications[] = $product_id;
        }
      }
    } else {
      $id = false;

      foreach ($_GET as $key => $value) {
        if ( (preg_match('/^[0-9]+(#?([0-9]+:?[0-9]+)+(;?([0-9]+:?[0-9]+)+)*)*$/', $key) || preg_match('/^[a-zA-Z0-9 -_]*$/', $key)) && ($key != $lC_Session->getName()) ) {
          $id = $key;
        }

        break;
      }

      if (($id !== false) && lC_Product::checkEntry($id)) {
        $lC_Product = new lC_Product($id);

        $notifications[] = $lC_Product->getID();
      }
    }

    if (!empty($notifications)) {
      foreach ($notifications as $product_id) {
        $Qcheck = $lC_Database->query('select products_id from :table_products_notifications where customers_id = :customers_id and products_id = :products_id limit 1');
        $Qcheck->bindTable(':table_products_notifications', TABLE_PRODUCTS_NOTIFICATIONS);
        $Qcheck->bindInt(':customers_id', $lC_Customer->getID());
        $Qcheck->bindInt(':products_id', $product_id);
        $Qcheck->execute();

        if ($Qcheck->numberOfRows() < 1) {
          $Qn = $lC_Database->query('insert into :table_products_notifications (products_id, customers_id, date_added) values (:products_id, :customers_id, :date_added)');
          $Qn->bindTable(':table_products_notifications', TABLE_PRODUCTS_NOTIFICATIONS);
          $Qn->bindInt(':products_id', $product_id);
          $Qn->bindInt(':customers_id', $lC_Customer->getID());
          $Qn->bindRaw(':date_added', 'now()');
          $Qn->execute();
        }
      }
    }

    lc_redirect(lc_href_link(basename($_SERVER['SCRIPT_FILENAME']), lc_get_all_get_params(array('action'))));
  }
}
?>