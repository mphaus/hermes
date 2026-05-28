<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentImportRequest;

class EquipmentImportStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreEquipmentImportRequest $request)
    {
        $request->validated();

        return to_route('inertia.equipment-import');
    }
}
