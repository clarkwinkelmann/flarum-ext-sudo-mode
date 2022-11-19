<?php

namespace ClarkWinkelmann\SudoMode\Policy;

use ClarkWinkelmann\SudoMode\SudoGate;
use Flarum\User\Access\AbstractPolicy;

abstract class AbstractSudoPolicy extends AbstractPolicy
{
    protected function denyIfNotSudo()
    {
        if (SudoGate::canUseAdminFeatures()) {
            return null;
        }

        return $this->forceDeny();
    }
}
