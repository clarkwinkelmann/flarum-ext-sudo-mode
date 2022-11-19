<?php

namespace ClarkWinkelmann\SudoMode\Policy;

class GlobalPolicy extends AbstractSudoPolicy
{
    // This is the permission checked through User::assertAdmin()
    public function administrate()
    {
        return $this->denyIfNotSudo();
    }

    public function createGroup()
    {
        return $this->denyIfNotSudo();
    }

    public function createTag()
    {
        return $this->denyIfNotSudo();
    }
}
