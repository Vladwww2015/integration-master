<?php

namespace IntegrationHelper\IntegrationMaster\Manager;

use IntegrationHelper\IntegrationMaster\Config\Config;
use IntegrationHelper\IntegrationMaster\Model\CollectionInterface;
use IntegrationHelper\IntegrationMaster\Model\IntegrationMasterInterface;

interface IntegrationMasterManagerInterface
{
    /**
     * @return IntegrationMasterManager
     */
    public static function getInstance(Config $config): IntegrationMasterManagerInterface;

    /**
     * @param CollectionInterface $collection
     * @param bool $isMaster
     * @param string $entityType
     * @param string $externalSourceIdentity
     * @return IntegrationMasterInterface
     */
    public function createOrIgnore(
        CollectionInterface $collection,
        bool $isMaster,
        string $entityType,
        string $externalSourceIdentity
    ): IntegrationMasterInterface;

    /**
     * @param CollectionInterface $collection
     * @param bool $isMaster
     * @param string $entityType
     * @param string $externalSourceIdentity
     * @return IntegrationMasterInterface
     */
    public function updateOrCreate(
        CollectionInterface $collection,
        bool $isMaster,
        string $entityType,
        string $externalSourceIdentity
    ): IntegrationMasterInterface;

    /**
     * @param int $id
     * @return IntegrationMasterInterface
     */
    public function get(int $id): IntegrationMasterInterface;

    /**
     * @param string $entityType
     * @param string $externalIdentity
     * @return IntegrationMasterInterface
     */
    public function find(string $entityType, string $externalIdentity);

    /**
     * @param string $entityType
     * @param string $externalIdentity
     * @return void
     */
    public function delete(string $entityType, string $externalIdentity): void;
}
