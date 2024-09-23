<?php

namespace IntegrationHelper\IntegrationMaster\Manager;

use IntegrationHelper\IntegrationMaster\Config\Config;
use IntegrationHelper\IntegrationMaster\Model\CollectionInterface;
use IntegrationHelper\IntegrationMaster\Model\IntegrationMasterExclusionInterface;

class IntegrationMasterExclusionManager implements IntegrationMasterExclusionManagerInterface
{
    protected static $instance = null;

    protected function __construct(
        protected Config $config
    ){}

    /**
     * @return IntegrationMasterExclusionManagerInterface
     */
    public static function getInstance(Config $config): IntegrationMasterExclusionManagerInterface
    {
        if(static::$instance === null) {
            static::$instance = new self($config);
        }

        return static::$instance;
    }


    public function createOrIgnore(
        int $masterId,
        CollectionInterface $sourceModel
    ): void
    {
        $identities = array_map(fn($item) => $item->getIdentity(), $sourceModel->getData());
        $entities = $this->find($masterId, $sourceModel);
        $identities = array_reverse($identities);
        foreach ($entities as $key => $entity) {
            if(array_key_exists($entity->getEntityIdentity(), $identities)) unset($identities[$entity->getEntityIdentity()]);
        }

        if($identities) $this->updateOrCreate($masterId, $sourceModel);
    }

    /**
     * @param int $masterId
     * @param CollectionInterface $sourceModel
     * @return void
     */
    public function updateOrCreate(
        int $masterId,
        CollectionInterface $sourceModel
    ): void
    {
        $this->config->getIntegrationMasterExclusionHandler()->save(
            $masterId,
            array_map(fn($item) => $item->getIdentity(), $sourceModel->getData())
        );
    }

    /**
     * @param int $id
     * @return IntegrationMasterExclusionInterface
     */
    public function get(int $id): IntegrationMasterExclusionInterface
    {
        return $this->config->getIntegrationMasterExclusionHandler()->read($id);
    }

    /**
     * @param int $masterId
     * @param CollectionInterface $sourceModel
     * @return IntegrationMasterExclusionInterface[]
     */
    public function find(int $masterId, CollectionInterface $sourceModel): array
    {
        return $this->config->getIntegrationMasterExclusionHandler()
            ->find(
                $masterId,
                array_map(fn($item) => $item->getIdentity(), $sourceModel->getData())
            );
    }

    /**
     * @param int $masterId
     * @param CollectionInterface $sourceModel
     * @return void
     */
    public function delete(int $masterId, CollectionInterface $sourceModel): void
    {
        $this->config->getIntegrationMasterExclusionHandler()
            ->delete(
                $masterId,
                array_map(fn($item) => $item->getIdentity(), $sourceModel->getData())
            );
    }
}
