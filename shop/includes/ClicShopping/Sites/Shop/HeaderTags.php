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

  namespace ClicShopping\Sites\Shop;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTTP;

  class HeaderTags {

/**
* Function to return the metatag in the footer
* public function
* @param string $footer
* @return string metatag in the footer
* get_submit_footer
*/

    public static function geFooterTag() {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');

      $Qsubmit_footer = $CLICSHOPPING_Db->prepare('select submit_defaut_language_footer
                                                    from :table_submit_description
                                                    where language_id = :language_id
                                                  ');
      $Qsubmit_footer->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
      $Qsubmit_footer->execute();

      if($Qsubmit_footer->fetch()) {
        $footer = HTML::outputProtected($Qsubmit_footer->value('submit_defaut_language_footer'));

        $delimiter = ',';
        $footer = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $footer));
        $footer1 = explode(",", $footer);

        $footer_content = '';

        foreach ($footer1 as $value) {
          $footer_content .= '#<a href="' . CLICSHOPPING::link(null, 'Search&Q&keywords=' . $value . '&search_in_description=1', 'rel="nofollow"') . '">' . $value . '</a> ';
        }

        return $footer_content;
      }
    }


/*
 * Function to return the canonical URL

 * @version 1.0
 * public function
 * @param string $canonical_link
 * @return string url of the website
 */
    public static function getCanonicalUrl()  {

      $domain = HTTP::typeUrlDomain(); // gets the base URL minus the trailing slash
      $string = $_SERVER['REQUEST_URI'];   // gets the url
      $search = '\&clicshopid.*|\?clicshopid.*'; // searches for the session id in the url
      $replace = '';   // replaces with nothing i.e. deletes
      $str = $string;
      $chars = preg_split('/&/', $str, -1);

      if ($chars[1]) {
        $newstring = "?" . $chars[1];
      }

      if ($chars[2]) {
        $newstring = $newstring . "&" . $chars[2];
      }

      if ($newstring) {
        $canonical_link = $domain . preg_replace('#$search#', $replace, $string) . $newstring; // merges the variables and echoing them
      } else {
        $canonical_link = $domain . preg_replace('#$search#', $replace, $string);   // merges the variables and echoing them
      }
      return $canonical_link;
    }
  }
