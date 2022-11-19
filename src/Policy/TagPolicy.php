<?php

namespace ClarkWinkelmann\SudoMode\Policy;

class TagPolicy extends AbstractSudoPolicy
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
