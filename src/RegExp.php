<?php

declare(strict_types=1);

namespace RegExp;

use RegExp\Resolver\BackReferenceResolver;
use RegExp\Data\RegExpMaker;

class RegExp
{
  /**
   * 
   * 
   * @var bool $dotAll,
   * @var bool $ignoreCase
   * @var bool $multiline
   * @var bool $hasIndices
   * @var bool $sticky
   * @var bool $unicode
   * @var bool $unicodeSets
   */
  public $dotAll, $ignoreCase, $multiline, $hasIndices, $sticky, $unicode, $unicodeSets;

  /**
   * 
   * 
   * @var string $source
   * @var string $flags
   * @var array  $commons
   */
  public $source, $flags, $commons;

  /*
  |-------------------------------------------------------------------------------------
  | Regular Expression [RegExp]
  |-------------------------------------------------------------------------------------
  |
  | Arrange Regular Expression Component core LIKE placeholder and source and flags
  | Returns PHP Regular Expression Object in __toString format for use to searching and
  |   replacing characters in strings
  |
  */
  public function __toString()
  {
    return \sprintf('/%s/%s', $this->source, $this->flags);
  }

  /**
   * Create a Regular Expression RegExp fn instance use to without new keyword
   * A PHP regular expression is a pattern of characters. The pattern is used for
   * searching and replacing characters in strings.
   * 
   * @param string|null $source  [required]
   * @param string|null $flags   [optional]
   * @param string|int  $commons [optional]
   * 
   * @return string RegExp
   */
  public function __construct(?string $source=RegExpMaker::DEF_SRC, ?string $flags = null, ...$commons)
  {
    return new RegExpMaker($this, \get_class_vars($this::class), $source, $flags, $commons);
  }
}
?>