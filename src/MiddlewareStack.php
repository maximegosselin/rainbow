<?php
declare(strict_types = 1);
namespace MaximeGosselin\Rainbow;

use RuntimeException;
use SplDoublyLinkedList;
use SplStack;

class MiddlewareStack implements MiddlewareStackInterface
{
    /**
     * @var SplStack
     */
    private $middlewares;

    /**
     * @var bool
     */
    private $isCalled;

    public function __construct(callable $core = null)
    {
        $this->middlewares = new SplStack;
        $this->middlewares->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO | SplDoublyLinkedList::IT_MODE_KEEP);
        $this->middlewares[] = $core ?? function($in, $out) {
                return $out;
            };

        $this->isCalled = false;
    }

    public function push(callable $middleware):MiddlewareStackInterface
    {
        if ($this->isCalled) {
            throw new RuntimeException('Cannot push middleware while stack is beeing called.');
        }

        $next = $this->middlewares->top();
        $this->middlewares[] = function($in, $out) use ($middleware, $next) {
            return call_user_func($middleware, $in, $out, $next);
        };

        return $this;
    }

    public function call($in, $out = null)
    {
        $start = $this->middlewares->top();
        $this->isCalled = true;
        $out = $start($in, $out);
        $this->isCalled = false;

        return $out;
    }
}
