<?php

declare(strict_types=1);

use RegExp\RegExp;

/*
│––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
│ Regular Expression [RegExp]
│––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
│
│ Create a Regular Expression RegExp fn instance use to without new keyword
│ A PHP regular expression is a pattern of characters. The pattern is used for
│ searching and replacing characters in strings.
│
*/

if (!\function_exists('RegExp'))
{
  /**
   * Create a Regular Expression RegExp fn instance use to without new keyword
   * 
   * @param string|null $source  [required]
   * @param string|null $flags   [optional]
   * @param string|int  $commons [optional]
   * 
   * @return string RegExp
   */
  function RegExp(?string $source = null, ?string $flags = null, ...$commons)
  {
    return (string) new RegExp($source, $flags, ...$commons);
  }
}