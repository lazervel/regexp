<?php

declare(strict_types=1);

namespace RegExp\Resolver;

class BackReferenceResolver
{
  private const RBACK_REFERENCE = '/(?<!\\\)%s(-?\\d+)/';
  private const RSPECIALCHARS   = '/([\/-])/';
  private const DEF_REFERENCE   = '\\$';

  /**
   * 
   * @param int   $index   [required]
   * @param array $entries [required]
   * @param array $extra   [optional]
   * 
   * @return mixed $matched
   */
  protected static function findMatcher(int $index, array $entries, array $extra = [])
  {

    $i = $index < 0 ? \count($entries) + $index : $index - 1;
    return $entries[$i] ?? $extra[$i] ?? '';
  }

  public static function addSlash(string $source)
  {
    return \preg_replace(self::RSPECIALCHARS, '\\\$1', $source);
  }

  /**
   * 
   * @param mixed $target [required]
   * @param mixed $forced [optional]
   * 
   * @return mixed $value
   */
  protected static function force($target, $forced="")
  {
    return !!$target ? $target : $forced;
  }

  /**
   * 
   * @param string|int $start   [required]
   * @param string|int $end     [required]
   * @param array      $groups  [required]
   * 
   * @return array $range
   */
  protected static function getRange($start, $end, array $groups)
  {
    $l = \count($groups) - 1;
    return \array_slice($groups, (int)$start, ($end === '*' ? $l : (int)$end));
  }

  /**
   * 
   * @param string $reference [required]
   * @return string BackReference Regular-Expression
   */
  protected static function rReference(string $reference)
  {
    return \sprintf(self::RBACK_REFERENCE, $reference);
  }

  /**
   * 
   * @param array $groups [required]
   * @param mixed $extra  [required]
   * @return array new-groups
   */
  protected static function makeGroup(array $groups, $extra = null)
  {
    $groups = (array)self::force($groups, (array)$extra);
    return $groups;
  }

  /**
   * 
   * @param array|string $target    [required]
   * @param array|null   $groups    [required]
   * @param string       $reference [optional]
   * 
   * @return array
   */
  public static function resolve($target, ?array $groups, string $reference = self::DEF_REFERENCE)
  {
    $groups  = self::makeGroup((array)$groups, $target);
    $pattern = self::rReference($reference);
    $isArr   = \is_array($target);
    $output  = (array)($target);

    foreach($output as $i=>$value)
    {
      $output[$i] = \preg_replace_callback($pattern, function($matched) use ($groups)
      {
        return self::findMatcher((int)$matched[1], $groups);
      }, (string) $value);
    }
    
    return !$isArr ? \join('', $output) : $output;
  }
}
?>