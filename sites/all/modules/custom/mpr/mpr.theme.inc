<?php

/**
 * @file
 * used.theme.inc
 */

/**
 * Theme used full page.
 */
function theme_mpr_full($variables) {

  $output = '';

  if (!empty($mpr->quran_daily)) {
    $output .= ' ' . $mpr->quran_daily . '';
  }

  if (!empty($mpr->hadith_daily)) {
    $output .= ' ' . $mpr->hadith_daily . '';
  }

  $output .= '';

  return $output;
}