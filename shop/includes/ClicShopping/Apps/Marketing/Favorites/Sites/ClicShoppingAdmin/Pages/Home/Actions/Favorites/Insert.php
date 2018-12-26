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


  namespace ClicShopping\Apps\Marketing\Favorites\Sites\ClicShoppingAdmin\Pages\Home\Actions\Favorites;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  class Insert extends \ClicShopping\OM\PagesActionsAbstract {
    public function execute() {

      $CLICSHOPPING_Favorites = Registry::get('Favorites');
      $CLICSHOPPING_Hooks = Registry::get('Hooks');

      $products_id = HTML::sanitize($_POST['products_id']);
      $expdate = HTML::sanitize($_POST['expdate']);
      $schdate = HTML::sanitize($_POST['schdate']);
      $customers_group_id = HTML::sanitize($_POST['customers_group']);

      $expires_date = '';
      if (!empty($expdate)) {
        $expires_date = substr($expdate, 0, 4) . substr($expdate, 5, 2) . substr($expdate, 8, 2);
      }

      $scheduled_date = '';
      if (!empty($schdate)) {
        $schedule_date = substr($schdate, 0, 4) . substr($schdate, 5, 2) . substr($schdate, 8, 2);
      }

      $CLICSHOPPING_Favorites->db->save('products_favorites', [
                                                            'products_id' => (int)$products_id,
                                                            'products_favorites_date_added' => 'now()',
                                                            'scheduled_date' => !empty($schedule_date) ? $schedule_date : 'null',
                                                            'expires_date' => !empty($expires_date) ? $expires_date : 'null',
                                                            'status' => 1
                                                          ]
                                );

      $CLICSHOPPING_Hooks->call('Favorites','Insert');

      $CLICSHOPPING_Favorites->redirect('Favorites');
    }
  }