<?php

namespace App\Application\Owner\AssociateWithModel;

interface AssociateWithModelInterface
{
    public function __invoke(AssociateWithModelCommand $command): void;
}
