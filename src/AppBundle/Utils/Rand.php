<?php
/**
 * Created by PhpStorm.
 * User: josue
 * Date: 26/11/2018
 * Time: 14:31
 */

namespace AppBundle\Utils;
use Doctrine\ORM\Query\Lexer;

class Rand extends \Doctrine\ORM\Query\AST\Functions\FunctionNode
{
    public function parse(\Doctrine\ORM\Query\Parser $parser){
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
       return 'RAND()';
    }
}