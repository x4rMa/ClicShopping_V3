<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\ObjectInfo;

  use ClicShopping\Apps\Communication\Newsletter\Module\ClicShoppingAdmin\Newsletter\Newsletter as NewsletterModule;

  $CLICSHOPPING_Template = Registry::get('TemplateAdmin');
  $CLICSHOPPING_Language = Registry::get('Language');
  $CLICSHOPPING_Newsletter = Registry::get('Newsletter');
  $CLICSHOPPING_Hooks = Registry::get('Hooks');

  if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
    $_GET['page'] = 1;
  }

  $nID = HTML::sanitize($_GET['nID']);
  $nlID = HTML::sanitize($_GET['nlID']);
  $cgID = HTML::sanitize($_GET['cgID']);
  $ac = HTML::sanitize($_GET['ac']);

  $Qnewsletter = $CLICSHOPPING_Newsletter->db->get('newsletters', [
                                                            'newsletters_id',
                                                            'title',
                                                            'content',
                                                            'module',
                                                            'languages_id',
                                                            'customers_group_id',
                                                            'newsletters_accept_file',
                                                            'newsletters_twitter',
                                                            'newsletters_customer_no_account'
                                                          ], [
                                                              'newsletters_id' => (int)$nID
                                                            ]
                                                          );

  $nInfo = new ObjectInfo($Qnewsletter->toArray());

  $module_name = $nInfo->module;
  $module = new NewsletterModule($nInfo->title, $nInfo->content);
?>

<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <span class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . '/categories/newsletters.gif', $CLICSHOPPING_Newsletter->getDef('heading_title'), '40', '40'); ?></span>
          <span class="col-md-5 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_Newsletter->getDef('heading_title'); ?></span>
          <span class="col-md-6 text-md-right"><?php echo HTML::button($CLICSHOPPING_Newsletter->getDef('button_cancel'), null,  $CLICSHOPPING_Newsletter->link('Newsletter&page=' . $_GET['page'] . '&nID=' . $_GET['nID']), 'danger', null, 'xs'); ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>

  <div>&nbsp;</div>
  <div class="text-md-center"><strong><?php echo $CLICSHOPPING_Newsletter->getDef('text_please_wait'); ?></strong></div>

<?php
// delete the timeout
  flush();

  $module->sendCkeditor($nInfo->newsletters_id);
?>
  <meta http-equiv="refresh" content="5; URL=<?php echo $CLICSHOPPING_Newsletter->link('ConfirmSendValid'); ?>">
</div>