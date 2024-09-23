<?php

namespace IntegrationHelper\IntegrationMaster\Config;

use IntegrationHelper\IntegrationMaster\Handlers\IntegrationMasterExclusionHandlerInterface;
use IntegrationHelper\IntegrationMaster\Handlers\IntegrationMasterHandlerInterface;
use IntegrationHelper\IntegrationMaster\Model\IntegrationMasterExclusionInterface;
use IntegrationHelper\IntegrationMaster\Model\IntegrationMasterInterface;

class Config
{
    public function __construct(
        protected string $integrationMasterModel,
        protected string $integrationMasterExclusionModel,
        protected IntegrationMasterHandlerInterface $integrationMasterHandler,
        protected IntegrationMasterExclusionHandlerInterface $integrationMasterExclusionHandler,
    ) {
        if(!in_array(IntegrationMasterInterface::class, class_implements($integrationMasterModel))) {
            throw new \Exclusion(
                sprintf(
                    'Class: %s must to implement interface: %s',
                    $integrationMasterModel,
                    IntegrationMasterInterface::class
                )
            );
        }

        if(!in_array(IntegrationMasterExclusionInterface::class, class_implements($integrationMasterExclusionModel))) {
            throw new \Exclusion(
                sprintf(
                    'Class: %s must to implement interface: %s',
                    $integrationMasterExclusionModel,
                    IntegrationMasterExclusionInterface::class
                )
            );
        }
    }

    public function getIntegrationMasterHandler(): IntegrationMasterHandlerInterface
    {
        return $this->integrationMasterHandler;
    }

    public function getIntegrationMasterExclusionHandler(): IntegrationMasterExclusionHandlerInterface
    {
        return $this->integrationMasterExclusionHandler;
    }

    /**
     * @return string
     */
    public function getIntegrationMasterModel(): string
    {
        return $this->integrationMasterModel;
    }

    /**
     * @return string
     */
    public function getIntegrationMasterExclusionModel(): string
    {
        return $this->integrationMasterExclusionModel;
    }
}
