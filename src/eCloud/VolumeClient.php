<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Volume;

class VolumeClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/volumes';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpc_id' => 'vpcId',
            'capacity' => 'capacity',
            'iops' => 'iops',
            'mounted' => 'mounted',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Volume(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getInstances($id)
    {
        $instanceClient = new InstanceClient;
        return $instanceClient->getByVolumeId($id);
    }
}
