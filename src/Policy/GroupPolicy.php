<?php

namespace ClarkWinkelmann\SudoMode\Policy;

class GroupPolicy extends AbstractSudoPolicy
{
    public function edit()
    {
        return $this->denyIfNotSudo();
    }

    public function delete()
    {
        return $this->denyIfNotSudo();
    }
}
