<?php
  class Util {
    static function formatTime(int $timestamp) {
      date_default_timezone_set('UTC');

      return sprintf(
        '<time datetime="%s">%s' .
          '<sup>%s</sup> ' .
          '%s' .
        '</time>',
        date('c', $timestamp), date('j', $timestamp), date('S', $timestamp),
        date('F Y, H:i e', $timestamp)
      );
    }

    static function makeExcerpt(string $text, int $maxLength) : string {
      $excerpt = preg_replace('/(<br>\n){3,}/' , "<br><br>\n",
        strip_tags($text, ['<br>', '<a>', '<strong>', '<em>']));
      return substr($excerpt, 0, $maxLength) .
        (strlen($excerpt) > $maxLength ? '...' : '');
    }

    static function swap(array &$array, int $index1, int $index2) {
      $temp = $array[$index1];
      $array[$index1] = $array[$index2];
      $array[$index2] = $temp;
    }

    /**
     * In-place quick-sort sorting algorithm
     *
     * Can compare values that can be natively compared, or objects by calling
     * a specified callbackMethod on each object to get a value that can be
     * natively compared.
     */
    static function quickSort(array &$items, bool $reverse = false,
                              ?string $callbackMethod = null,
                              int $start = 0, ?int $end = null) : void {
      if ($end === null) {
        $end = count($items);
      }

      if ($end - $start <= 1) {
        return;
      }

      $pivot = self::partition($items, $reverse, $callbackMethod, $start, $end);

      self::quickSort($items, $reverse, $callbackMethod, $start, $pivot);
      self::quickSort($items, $reverse, $callbackMethod, $pivot + 1, $end);
    }

    private static function compare($element1, $element2, ?string $callbackMethod) : int {
      if ($callbackMethod !== null) {
        return $element1->{$callbackMethod}() - $element2->{$callbackMethod}();
      } else {
        return $element1 - $element2;
      }
    }

    private static function partition(array &$items, bool $reverse,
                   ?string $callbackMethod, int $start = 0, int $end) : int {
      $pivot = rand($start, $end - 1);
      self::swap($items, $start, $pivot);

      $left = $start + 1;
      $right = $end - 1;

      while (true) {
        while ($left < $end - 1
        && ($reverse xor self::compare($items[$left], $items[$start], $callbackMethod) <= 0)) {
          $left++;
        }
        while ($right > $start
        && ($reverse xor self::compare($items[$right], $items[$start], $callbackMethod) >= 0)) {
          $right--;
        }

        if ($left >= $right) {
          break;
        }
        self::swap($items, $left, $right);
      }

      self::swap($items, $right, $start);
      return $right;
    }
  }
?>
