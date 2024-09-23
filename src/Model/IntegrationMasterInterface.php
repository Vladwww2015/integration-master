<?php
namespace IntegrationHelper\IntegrationMaster\Model;

interface IntegrationMasterInterface
{
    public function getId(): int;

    public function getEntityType(): string;

    public function getExternalSourceIdentity(): string;

    public function isMaster(): bool;

    public function getModelCollection(): CollectionInterface;
}
