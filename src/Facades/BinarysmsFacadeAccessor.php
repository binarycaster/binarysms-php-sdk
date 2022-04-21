<?php

namespace Binarycaster\Binarysms\Facades;

use Illuminate\Support\Facades\Facade;

class BinarysmsFacadeAccessor extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'binarysms';
    }
}
