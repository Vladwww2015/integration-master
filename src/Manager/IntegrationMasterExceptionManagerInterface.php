<?php

namespace IntegrationHelper\IntegrationMaster\Manager;

use IntegrationHelper\IntegrationMaster\Config\Config;
use IntegrationHelper\IntegrationMaster\Model\CollectionInterface;
use IntegrationHelper\IntegrationMaster\Model\IntegrationMasterExclusionInterface;

interface IntegrationMasterExclusionManagerInterface
{
    /**
     * @param Config $config
     * @return IntegrationMasterExclusionManagerInterface
     */
    public static function getInstance(Config $config): IntegrationMasterExclusionManagerInterface;

    /**
     * @param int $masterId
     * @param CollectionInterface $sourceModel
     * @return void
     */
    public function createOrIgnore(
        int $masterId,
        CollectionInterface $sourceModel
    ): void;

    /**
     * @param int $masterId
     * @param CollectionInterface $sourceModel
     * @return void
     */
    public function updateOrCreate(
        int $masterId,
        CollectionInterface $sourceModel
    ): void;

    /**
     * @param int $id
     * @return IntegrationMasterExclusionInterface
     */
    public function get(int $id): IntegrationMasterExclusionInterface;

    /**
     * @param int $masterId
     * @param CollectionInterface $sourceModel
     * @return IntegrationMasterExclusionInterface[]
     */
    public function find(int $masterId, CollectionInterface $sourceModel): array;

    /**
     * @param int $masterId
     * @param CollectionInterface $sourceModel
     * @return void
     */
    public function delete(int $masterId, CollectionInterface $sourceModel): void;
}
