<?php

namespace Hemsfacebook\Fblogin\Facades;

use Illuminate\Support\Facades\Facade;

class HemsfbFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'hemsfb';
    }

}
