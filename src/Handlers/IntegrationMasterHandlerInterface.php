<?php

namespace IntegrationHelper\IntegrationMaster\Handlers;

use IntegrationHelper\IntegrationMaster\Model\IntegrationMasterInterface;

interface IntegrationMasterHandlerInterface
{
    public function save(IntegrationMasterInterface $integrationMaster): void;

    public function delete(IntegrationMasterInterface $integrationMaster): void;

    public function find(string $entityType, string $externalIdentity): IntegrationMasterInterface;

    public function read(int $id): IntegrationMasterInterface;
}
