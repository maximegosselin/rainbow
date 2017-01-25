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
    private $stack;

    /**
     * @var bool
     */
    private $isCalled;

    public function __construct(callable $core = null)
    {
        $this->stack = new SplStack;
        $this->stack->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO | SplDoublyLinkedList::IT_MODE_KEEP);
        $this->stack[] = $core ?? function ($in, $out) {
                return $out;
        };

        $this->isCalled = false;
    }

    public function push(callable $middleware): MiddlewareStackInterface
    {
        if ($this->isCalled) {
            throw new RuntimeException('Cannot push middleware while stack is beeing called.');
        }

        $next = $this->stack->top();
        $this->stack[] = function ($in, $out) use ($middleware, $next) {
            $result = call_user_func($middleware, $in, $out, $next);

            return $result;
        };

        return $this;
    }

    public function call($in = null, $out = null)
    {
        $start = $this->stack->top();
        $this->isCalled = true;
        $out = $start($in, $out);
        $this->isCalled = false;

        return $out;
    }
}
