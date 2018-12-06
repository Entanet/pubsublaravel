<?php
/**
 * Created by PhpStorm.
 * User: markjones
 * Date: 10/09/18
 * Time: 14:57
 */

namespace Entanet\PubSubLaravel;

class PubSubEventFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pubsubevent';
    }
}