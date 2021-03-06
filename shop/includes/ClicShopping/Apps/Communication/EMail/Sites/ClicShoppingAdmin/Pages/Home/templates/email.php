<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  use ClicShopping\Sites\ClicShoppingAdmin\HTMLOverrideAdmin;

  $CLICSHOPPING_Template = Registry::get('TemplateAdmin');
  $CLICSHOPPING_Mail = Registry::get('Mail');
  $CLICSHOPPING_EMail = Registry::get('EMail');
  $CLICSHOPPING_MessageStack = Registry::get('MessageStack');

  // dropdown
  $customers = [];
  $customers[] = ['id' => '', 'text' => $CLICSHOPPING_EMail->getDef('text_select_customer')];
  $customers[] = ['id' => '***', 'text' => $CLICSHOPPING_EMail->getDef('text_all_customers')];
  $customers[] = ['id' => '**D', 'text' => $CLICSHOPPING_EMail->getDef('text_newsletter_customers')];

  $QmailCustomers = $CLICSHOPPING_EMail->db->prepare('select customers_email_address,
                                                             customers_firstname,
                                                             customers_lastname
                                                      from :table_customers
                                                      where customers_email_validation = 0
                                                      order by customers_lastname
                                                    ');
  $QmailCustomers->execute();

  while ($QmailCustomers->fetch()) {
    $customers[] = ['id' => $QmailCustomers->value('customers_email_address'),
      'text' => $QmailCustomers->value('customers_lastname') . ', ' . $QmailCustomers->value('customers_firstname') . ' (' . $QmailCustomers->value('customers_email_address') . ')'
    ];
  }

  if ($CLICSHOPPING_MessageStack->exists('main')) {
    echo $CLICSHOPPING_MessageStack->get('main');
  }

  echo HTMLOverrideAdmin::getCkeditor();
?>
<!-- body //-->
<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <div
            class="col-md-1"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'categories/mail.gif', $CLICSHOPPING_EMail->getDef('heading_title'), '40', '40'); ?></div>
          <div class="col-md-5 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_EMail->getDef('heading_title'); ?></div>
<?php
   if (SEND_EMAILS == 'true') {
?>
              <div class="col-md-6 text-md-right">
<?php
                  echo HTML::form('mail', $CLICSHOPPING_EMail->link('SendEmailToUser&Process'));
                  echo HTML::button($CLICSHOPPING_EMail->getDef('button_send'), null, null, 'success');
?>
              </div>
<?php
   }
?>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <div id="emailTab">
    <ul class="nav nav-tabs flex-column flex-sm-row" role="tablist" id="myTab">
      <li
        class="nav-item"><?php echo '<a href="#tab1" role="tab" data-toggle="tab" class="nav-link active">' . $CLICSHOPPING_EMail->getDef('tab_general') . '</a>'; ?></li>
    </ul>
    <div class="tabsClicShopping">
      <div class="tab-content">
        <div class="col-md-12 mainTitle"><?php echo $CLICSHOPPING_EMail->getDef('text_email'); ?></div>
        <div class="adminformTitle">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group row">
                <label for="<?php echo $CLICSHOPPING_EMail->getDef('text_customer'); ?>"
                       class="col-5 col-form-label"><?php echo $CLICSHOPPING_EMail->getDef('text_customer'); ?></label>
                <div class="col-md-5">
                  <?php echo HTML::selectMenu('customers_email_address', $customers, (isset($_GET['customer']) ? $_GET['customer'] : '')); ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-5">
              <div class="form-group row">
                <label for="<?php echo $CLICSHOPPING_EMail->getDef('text_from'); ?>"
                       class="col-5 col-form-label"><?php echo $CLICSHOPPING_EMail->getDef('text_from'); ?></label>
                <div class="col-md-5">
                  <?php echo HTML::inputField('from', '', 'required aria-required="true" id="textFrom" placeholder="' . $CLICSHOPPING_EMail->getDef('email_text_from') . '"', 'email'); ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-5">
              <div class="form-group row">
                <label for="<?php echo $CLICSHOPPING_EMail->getDef('text_subject'); ?>"
                       class="col-5 col-form-label"><?php echo $CLICSHOPPING_EMail->getDef('text_subject'); ?></label>
                <div class="col-md-5">
                  <?php echo HTML::inputField('subject', '', 'required aria-required="true" id="subject" placeholder="' . $CLICSHOPPING_EMail->getDef('subject') . '"'); ?>
                </div>
              </div>
            </div>
          </div>

          <script>
              var options = {
                  'defaultView': 'list',
                  'onlyMimes': ["image"], // display all images
                  lang: 'fr'
              }
              $('#elfinder').elfinder(options);
          </script>

          <div class="row">
            <div class="col-md-5">
              <div class="form-group row">
                <label for="<?php echo $CLICSHOPPING_EMail->getDef('text_message'); ?>"
                       class="col-5 col-form-label"><?php echo $CLICSHOPPING_EMail->getDef('text_message'); ?></label>
                <div class="col-md-5">
                  <?php echo HTMLOverrideAdmin::textAreaCkeditor('message', null, '750', '300'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
  <div class="separator"></div>
  <div class="alert alert-info" role="alert">
    <div><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/help.gif', $CLICSHOPPING_EMail->getDef('title_help_description')) . ' ' . $CLICSHOPPING_EMail->getDef('title_help_description') ?></div>
    <div class="separator"></div>
    <div class="row">
      <span class="col-sm-12">
        <blockquote><i><a data-toggle="modal"
                          data-target="#myModalWysiwyg"><?php echo $CLICSHOPPING_EMail->getDef('text_help_wysiwyg'); ?></a></i></blockquote>
        <div class="modal fade" id="myModalWysiwyg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                    aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"
                    id="myModalLabel"><?php echo $CLICSHOPPING_EMail->getDef('text_help_wysiwyg'); ?></h4>
              </div>
              <div class="modal-body text-md-center">
                <img class="img-fluid"
                     src="<?php echo $CLICSHOPPING_Template->getImageDirectory() . '/wysiwyg.png'; ?>">
              </div>
            </div>
          </div>
        </div>
      </span>
    </div>
  </div>
</div>