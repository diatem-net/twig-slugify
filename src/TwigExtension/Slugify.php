<?php

namespace Drupal\twig_slugify\TwigExtension;

use Drupal\drupal_front\Helpers\Slug;

class Slugify extends \Twig_Extension
{

  /**
   * @return string
   */
  public function getName() {
    return 'slugify';
  }

  /**
   * Generates a list of all Twig filters that this extension defines.
   */
  public function getFilters() {
    return array(
      new \Twig_SimpleFilter('slugify', array($this, 'slugify')),
    );
  }

  /**
   * Truncate text after n chars
   */
  public static function slugify($value) {
    $slug = $value;
    $rules = <<<'RULES'
    :: Any-Latin;
    :: NFD;
    :: [:Nonspacing Mark:] Remove;
    :: NFC;
    :: [^-[:^Punctuation:]] Remove;
    :: Lower();
    [:^L:] { [-] > ;
    [-] } [:^L:] > ;
    [-[:Separator:]]+ > '-';
RULES;

    if (is_string($value)) {
      $slug = \Transliterator::createFromRules($rules)->transliterate($value);

    }
    return $slug;
  }


}
