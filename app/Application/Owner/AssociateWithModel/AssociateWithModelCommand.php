<?php

namespace App\Application\Owner\AssociateWithModel;

final readonly class AssociateWithModelCommand
{
    public function __construct(
        public string $ownerId,
        public string $relatedModelType,
        public string $relatedModelId
    ) {}
}
