<?php
/**
  @package    catalog::admin::applications
  @author     Loaded Commerce
  @copyright  Copyright 2003-2014 Loaded Commerce, LLC
  @copyright  Portions Copyright 2003 osCommerce
  @copyright  Template built on Developr theme by DisplayInline http://themeforest.net/user/displayinline under Extended license 
  @license    https://github.com/loadedcommerce/loaded7/blob/master/LICENSE.txt
  @version    $Id: edit.php v1.0 2013-08-08 datazen $
*/
?>
<style>
#editAddon { padding-bottom:20px; }
</style>
<script>
function editAddon(code, name, id) {
  mask();
  var accessLevel = '<?php echo $_SESSION['admin']['access'][$lC_Template->getModule()]; ?>';
  if (parseInt(accessLevel) < 3) {
    $.modal.alert('<?php echo $lC_Language->get('ms_error_no_access');?>');
    return false;
  }
  // check if template or language and redirect accordingly
  if (name == 'templates') {
    var url = "<?php echo lc_href_link_admin(FILENAME_DEFAULT, 'templates&action=edit&code=CODE&id=ID'); ?>";
    $(location).attr('href',url.replace('CODE', code).replace('ID', id));    
    return;
  }
  if (name == 'languages') {
    var url = "<?php echo lc_href_link_admin(FILENAME_DEFAULT, 'languages&action=edit&code=CODE&id=ID'); ?>";
    $(location).attr('href',url.replace('CODE', code).replace('ID', id));
    return;    
  }
  var jsonLink = '<?php echo lc_href_link_admin('rpc.php', $lC_Template->getModule() . '&action=getFormData&code=CODE'); ?>';
  $.getJSON(jsonLink.replace('CODE', code),
    function (data) {
      unmask();
      if (data.rpcStatus == -10) { // no session
        var url = "<?php echo lc_href_link_admin(FILENAME_DEFAULT, 'login'); ?>";
        $(location).attr('href',url);
      }
      if (data.rpcStatus != 1) {
        $.modal.alert('<?php echo $lC_Language->get('ms_error_retrieving_data'); ?>');
        return false;
      }
      $.modal({
          content: '<span id="logo-image"></span>'+
                   '<fieldset class="fieldset fields-list">'+
                   '  <form name="mEdit" id="mEdit" autocomplete="off" action="" method="post">'+
                   '    <div class="field-block relative" id="editAddonFormKeys">'+
                   '    </div>'+
                   '  </form>'+
                   '</fieldset>',
          title: '<?php echo sprintf($lC_Language->get('modal_heading_setup_addon'), 'TITLE'); ?>'.replace('TITLE', name.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } )),
          width: 530,
          scrolling: true,
          actions: {
            'Close' : {
              color: 'red',
              click: function(win) { win.closeModal(); }
            }
          },
          buttons: {
            '<?php echo $lC_Language->get('button_cancel'); ?>': {
              classes:  'glossy',
              click:    function(win) { win.closeModal(); }
            },
            '<?php echo $lC_Language->get('button_save'); ?>': {
              classes:  'blue-gradient glossy',
              click:    function(win) {
                var nvp = $("#mEdit").serialize();
                var jsonLink = '<?php echo lc_href_link_admin('rpc.php', $lC_Template->getModule() . '&action=saveAddon&name=NAME&NVP'); ?>'
                $.getJSON(jsonLink.replace('NAME', code).replace('NVP', nvp),
                  function (rdata) {
                    if (rdata.rpcStatus == -10) { // no session
                      var url = "<?php echo lc_href_link_admin(FILENAME_DEFAULT, 'login'); ?>";
                      $(location).attr('href',url);
                    }
                    if (rdata.rpcStatus != 1) {
                      $.modal.alert('<?php echo $lC_Language->get('ms_error_action_not_performed'); ?>');
                      return false;
                    }
                    
                    var currentType = '<?php echo $_GET['type']; ?>';
                    var url = window.location.href;
                    var rUrl = '';
                    if (currentType == '') {
                      rUrl = url + '&type=' + name;
                    } else if (currentType != name) {
                      rUrl = url.replace('&type=' + currentType, '&type=' + name);
                    } 
                    window.location.href = rUrl;
                  }
                );
                win.closeModal();
              }
            }
          },
          buttonsLowPadding: true
      });
      $("#logo-image").html(data.desc);   
      $("#editAddonFormKeys").html(data.keys);   
      $(".label").addClass('small-margin-top');   
      $.modal.all.centerModal();
      
    }
  );
}
</script>