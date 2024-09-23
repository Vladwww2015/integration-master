<?php

namespace IntegrationHelper\IntegrationMaster\Manager;

use IntegrationHelper\IntegrationMaster\Config\Config;
use IntegrationHelper\IntegrationMaster\Model\CollectionInterface;
use IntegrationHelper\IntegrationMaster\Model\IntegrationMasterInterface;

class IntegrationMasterManager implements IntegrationMasterManagerInterface
{
    protected static $instance = null;

    /**
     * @param Config $config
     */
    protected function __construct(
        protected Config $config
    ){}

    /**
     * @return IntegrationMasterManagerInterface
     */
    public static function getInstance(Config $config): IntegrationMasterManagerInterface
    {
        if(static::$instance === null) {
            static::$instance = new self($config);
        }

        return static::$instance;
    }

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
    ): IntegrationMasterInterface
    {
        $entity = $this->find($entityType, $externalSourceIdentity);
        if($entity->getId()) {
            return $entity;
        }

        return $this->updateOrCreate($collection, $isMaster, $entityType, $externalSourceIdentity);
    }

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
    ): IntegrationMasterInterface
    {
        $model = $this->config->getIntegrationMasterModel();
        $integrationMaster = new $model($collection::class, $isMaster, $entityType, $externalSourceIdentity);
        $this->config->getIntegrationMasterHandler()->save($integrationMaster);

        return $this->find($entityType, $externalSourceIdentity);
    }

    /**
     * @param int $id
     * @return IntegrationMasterInterface
     */
    public function get(int $id): IntegrationMasterInterface
    {
        return $this->config->getIntegrationMasterHandler()->read($id);
    }

    /**
     * @param string $entityType
     * @param string $externalIdentity
     * @return IntegrationMasterInterface
     */
    public function find(string $entityType, string $externalIdentity)
    {
        return $this->config->getIntegrationMasterHandler()->find($entityType, $externalIdentity);
    }

    /**
     * @param string $entityType
     * @param string $externalIdentity
     * @return void
     */
    public function delete(string $entityType, string $externalIdentity): void
    {
        $this->config->getIntegrationMasterHandler()->delete(
            $this->config->getIntegrationMasterHandler()->find($entityType, $externalIdentity)
        );
    }
}
