<?php
declare(strict_types = 1);

namespace MaximeGosselin\Rainbow\Test;

use MaximeGosselin\Rainbow\MiddlewareStack;
use MaximeGosselin\Rainbow\MiddlewareStackInterface;

class MiddlewareStackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MiddlewareStackInterface
     */
    private $stack;

    public function setUp()
    {
        $this->stack = new MiddlewareStack();
    }

    public function testLastMiddlewarePushedIsFirstCalled()
    {
        $mw1 = function ($in, $out, $next) {
            $out .= 'mw1';

            return $next($in, $out);
        };

        $mw2 = function ($in, $out, $next) {
            $out .= 'mw2';

            return $next($in, $out);
        };

        $mw3 = function ($in, $out, $next) {
            $out .= 'mw3';

            return $next($in, $out);
        };

        $this->stack->push($mw1)->push($mw2)->push($mw3);
        $out = $this->stack->call('');

        $this->assertEquals($out, 'mw3mw2mw1');
    }
}
