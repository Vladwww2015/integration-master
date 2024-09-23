<?php

namespace IntegrationHelper\IntegrationMaster\Processors;

use IntegrationHelper\IntegrationMaster\Config\Config;
use IntegrationHelper\IntegrationMaster\Manager\IntegrationMasterExclusionManager;
use IntegrationHelper\IntegrationMaster\Manager\IntegrationMasterExclusionManagerInterface;
use IntegrationHelper\IntegrationMaster\Manager\IntegrationMasterManager;
use IntegrationHelper\IntegrationMaster\Manager\IntegrationMasterManagerInterface;
use IntegrationHelper\IntegrationMaster\Model\CollectionInterface;
use IntegrationHelper\IntegrationMaster\Model\IntegrationMasterInterface;

class IntegrationMasterDataProcess
{
    /**
     * @var IntegrationMasterManagerInterface
     */
    protected IntegrationMasterManagerInterface $integrationMasterManager;

    /**
     * @var IntegrationMasterExclusionManagerInterface
     */
    protected IntegrationMasterExclusionManagerInterface $integrationMasterExclusionManager;

    /**
     * @param Config $config
     */
    public function __construct(
        protected Config $config
    ) {
        $this->integrationMasterManager = IntegrationMasterManager::getInstance($this->config);
        $this->integrationMasterExclusionManager = IntegrationMasterExclusionManager::getInstance($this->config);
    }

    public function processNewMaster(
        CollectionInterface $sourceModel,
        bool $isMaster,
        string $entityType,
        string $externalSourceIdentity
    )
    {
        $integrationMaster = $this->integrationMasterManager->createOrIgnore(
            $sourceModel,
            $isMaster,
            $entityType,
            $externalSourceIdentity
        );
    }

    public function processUpdateMaster(
        CollectionInterface $sourceModel,
        bool $isMaster,
        string $entityType,
        string $externalSourceIdentity
    ): void
    {
        $integrationMaster = $this->integrationMasterManager->updateOrCreate(
            $sourceModel,
            $isMaster,
            $entityType,
            $externalSourceIdentity
        );

        if($sourceModel->isCount()) {
            $this->integrationMasterExclusionManager->updateOrCreate($integrationMaster->getId(), $sourceModel);
        }
    }

    public function processDeleteMaster(
        string $entityType,
        string $externalSourceIdentity
    ): void
    {
        $this->integrationMasterManager->delete(
            $entityType,
            $externalSourceIdentity
        );
    }

    public function processDeleteExclusionMaster(
        IntegrationMasterInterface $integrationMaster,
        CollectionInterface $sourceModel
    ): void
    {
        $this->integrationMasterExclusionManager->delete(
            $integrationMaster->getId(),
            $sourceModel
        );
    }

    public function processAddExclusionMaster(
        IntegrationMasterInterface $integrationMaster,
        CollectionInterface $sourceModel
    )
    {
        if($sourceModel->isCount()) {
            $this->integrationMasterExclusionManager->createOrIgnore($integrationMaster->getId(), $sourceModel);
        }
    }
}
