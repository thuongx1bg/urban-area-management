<?php

namespace App\Repositories\Building;

use App\Models\Building;
use App\Repositories\BaseRepository;

class BuildingRepository extends BaseRepository implements BuildingRepositoryInterface {

    public function getModel()
    {
        return Building::class;
    }
}
