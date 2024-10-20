<?php

declare(strict_types=1);

namespace RegExp\Data;

use RegExp\Resolver\BackReferenceResolver;
use RegExp\RegExp;

final class RegExpMaker
{
  private const RFLAGS = '/^(?!.*(.).*\1)[dimsuvy]+$/';
  public const DEF_SRC = '(?:)';
  private const FLAGS  = array(
    'dotAll'      => '/(s)/',
    'ignoreCase'  => '/(i)/',
    'multiline'   => '/(m)/',
    'hasIndices'  => '/(d)/',
    'sticky'      => '/(y)/',
    'unicode'     => '/(u)/',
    'unicodeSets' => '/(v)/'
  );

  public function __construct(RegExp $regexp, $resolver, string $source, ?string $flags = null, array $commons)
  {
    $regexp->flags   = $flags;
    $regexp->commons = BackReferenceResolver::resolve($commons, null);
    $regexp->source  = BackReferenceResolver::resolve(BackReferenceResolver::addSlash($source), $regexp->commons, '\\%');
    foreach(self::FLAGS as $prop => $rflag) ($regexp->$prop = @\preg_match($rflag, $regexp->flags ?? ''));
    if ($flags && !@\preg_match(self::RFLAGS, $flags)) throw new \Exception("Invalid regular expression flags");
  }
}
?>