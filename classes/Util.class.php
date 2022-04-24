<?php
  class Util {
    static function formatTime(int $timestamp) {
    return sprintf(
      '<time datetime="%s">%s' .
        '<sup>%s</sup> ' .
        '%s' .
      '</time>'
    , date('c', $timestamp), date('j', $timestamp), date('S', $timestamp), date('F Y, H:i e', $timestamp));
    }
  }
?>
