<?php

/*
 * Opulence
 *
 * @link      https://www.aphiria.com
 * @copyright Copyright (C) 2019 David Young
 * @license   https://github.com/aphiria/console/blob/master/LICENSE.md
 */

namespace Aphiria\Console\Responses\Compilers\Parsers;

use Aphiria\Console\Responses\Compilers\Lexers\Tokens\Token;
use RuntimeException;

/**
 * Defines the interface for response parsers to implement
 */
interface IResponseParser
{
    /**
     * Parses tokens into an abstract syntax tree
     *
     * @param Token[] $tokens The list of tokens to parse
     * @return AbstractSyntaxTree The abstract syntax tree made from the tokens
     * @throws RuntimeException Thrown if there was an error in the tokens
     */
    public function parse(array $tokens): AbstractSyntaxTree;
}
