<?php

namespace Common\Utility;

use Closure;
use Phalcon\Mvc\Model\Transaction\Manager;

class TrxClosure
{
    public static function execute(Closure $closure)
    {
        $trx = (new Manager())->get();

        try {
            $closure();
            $trx->commit();
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
    }
}