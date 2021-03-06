<?php
declare(strict_types = 1);

namespace MaximeGosselin\Rainbow;

interface MiddlewareStackInterface
{
    /**
     * @param callable $middleware
     * @return MiddlewareStackInterface
     */
    public function push(callable $middleware): MiddlewareStackInterface;

    /**
     * @param mixed $in
     * @param mixed $out
     * @return mixed
     */
    public function call($in = null, $out = null);
}
