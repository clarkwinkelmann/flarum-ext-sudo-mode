<?php

namespace ClarkWinkelmann\SudoMode\Policy;

use ClarkWinkelmann\SudoMode\SudoGate;

class UserPolicy extends AbstractSudoPolicy
{
    public function editCredentials()
    {
        return $this->denyIfNotSudo();
    }

    public function editGroups()
    {
        return $this->denyIfNotSudo();
    }

    public function delete()
    {
        return $this->denyIfNotSudo();
    }
}
