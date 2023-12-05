<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\ColorEnum;
use App\Helpers\HttpHelper;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class VehicleController extends Controller
{
    public function index(Request $request)
    {
        return Vehicle::query()
            ->whereBelongsTo($request->user())
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate(
            array_merge(
                $this->getCommonRules(),
                [Vehicle::PROP_VEHICLE_MODEL_ID => ['required']]
            )
        );

        return Vehicle::query()->create(
            array_merge(
                $request->input(),
                [Vehicle::PROP_USER_ID => $request->user()->id]
            )
        );
    }

    public function show(Request $request, Vehicle $vehicle)
    {
        $this->checkBelongsToUser($vehicle, $request->user());

        return $vehicle->withoutRelations();
    }

    public function update(Vehicle $vehicle, Request $request)
    {
        $request->validate($this->getCommonRules());

        $this->checkBelongsToUser($vehicle, $request->user());

        if (! $vehicle->update($request->input())) {
            abort(HttpHelper::STATUS_SERVER_ERROR);
        }

        return $vehicle;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle, Request $request)
    {
        $this->checkBelongsToUser($vehicle, $request->user());

        $result = $vehicle->delete();

        if (!$result) {
            abort(HttpHelper::STATUS_SERVER_ERROR);
        }

        return response()->noContent();
    }

    private function checkBelongsToUser(Vehicle $vehicle, User $user): void
    {
        if ($vehicle->user->id !== $user->id) {
            abort(HttpHelper::STATUS_FORBIDDEN);
        }
    }

    private function getCommonRules(): array
    {
        return [
            Vehicle::PROP_YEAR => ['nullable', 'integer'],
            Vehicle::PROP_MILEAGE_KM => ['nullable', 'integer'],
            Vehicle::PROP_COLOR => ['nullable', Rule::enum(ColorEnum::class)],
        ];
    }
}

