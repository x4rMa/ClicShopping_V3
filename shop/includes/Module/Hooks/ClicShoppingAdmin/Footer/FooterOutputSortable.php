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

  namespace ClicShopping\OM\Module\Hooks\ClicShoppingAdmin\Footer;

  class FooterOutputSortable
  {
    /**
     * @return string
     */
    public function display(): string
    {
      $params = $_SERVER['QUERY_STRING'];

      if (empty($params)) {
        return false;
      }

      $output = '';

      if (isset($_SESSION['admin'])) {
        if (isset($_GET['cPath'])) {
          $output .= '<!-- Sortable Script start-->' . "\n";
          $output .= '<script defer src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.1/Sortable.min.js"></script>' . "\n";
          $output .= '<!--Sortable end -->' . "\n";
        }
      }

      return $output;
    }
  }