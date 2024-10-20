<?php

declare(strict_types=1);

namespace RegExp\Common;

use RegExp\Resolver\BackReferenceResolver;

final class Commons extends BackReferenceResolver
{
  private const RANGE = '/%s|\\[(?:(\\d+)-(\\d+|\\*))\\]/';
  public static $output = [];
  private static $commons;

  /**
   * 
   * @param array<string|int|array> $commons [required]
   * @return void
   */
  public function __construct(array $commons)
  {
    self::$commons = $commons;
  }

  /**
   * 
   * @param array<string|int|array> $commons [required]
   * @return \RegExp\Common\Commons
   */
  public static function store(array $commons)
  {
    return new self(BackReferenceResolver::resolve($commons, null));
  }

  /*
  |-------------------------------------------------------------------------------------
  | Method get() of Commons
  |-------------------------------------------------------------------------------------
  |
  |
  */
  public static function fetch(?string $expression = null)
  {
    // Returns all stored commons if $expression is null
    if ($expression===null)
    {
      return self::$commons;
    }

    // Otherwise returns the specific commons value with custom [Range] or [BackReference]
    preg_replace_callback(\sprintf(self::RANGE, \trim(self::rReference('\\$'), '/')), function($matched)
    {
      $start = (int)($matched[1]);
      \array_push(self::$output,
        ...(\count($matched) >= 3 ? self::getRange($matched[2], $matched[3], self::makeGroup(self::$commons)) :
        [self::findMatcher($start, self::makeGroup(self::$commons))])
      );
    }, $expression);

    return self::$output;
  }
}
?>