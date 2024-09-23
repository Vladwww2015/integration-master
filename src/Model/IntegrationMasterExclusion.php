<?php
namespace IntegrationHelper\IntegrationMaster\Model;

class IntegrationMasterExclusion implements IntegrationMasterExclusionInterface
{
    /**
     * @param int $id
     * @param int $masterId
     * @param string|int $entityIdentity
     */
    public function __construct(
        protected int $id,
        protected int $masterId,
        protected string|int $entityIdentity
    ) {}

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMasterId(): int
    {
        return $this->masterId;
    }

    /**
     * @return string|int
     */
    public function getEntityIdentity(): string|int
    {
        return $this->entityIdentity;
    }
}
