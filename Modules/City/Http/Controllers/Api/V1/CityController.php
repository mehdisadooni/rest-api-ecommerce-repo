<?php

namespace Modules\City\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\StoreRequest;
use Modules\City\Http\Requests\UpdateRequest;
use Modules\City\Repositories\CitiesRepositoryInterface;
use Modules\City\Transformers\CityResource;
use Modules\Province\Entities\Province;
use Modules\Province\Repositories\ProvincesRepositoryInterface;

class CityController extends Controller
{
    private $repository;
    private $provincesRepository;

    public function __construct(CitiesRepositoryInterface $repository,ProvincesRepositoryInterface $provincesRepository)
    {
        $this->repository = $repository;
        $this->provincesRepository = $provincesRepository;
    }

    /**
     * Return All Cities with paginate
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $provinces = $this->repository->paginate(10);
        return successResponse([
            'cities' => CityResource::collection($provinces->load('province')),
            'links' => CityResource::collection($provinces)->response()->getData()->links,
            'meta' => CityResource::collection($provinces)->response()->getData()->meta,
        ], 200);
    }

    /**
     * store city
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $province =  $this->provincesRepository->findOrFail($request->province_id);
        $city = $province->cities()->create([
            'name' => $request->name,
        ]);
        DB::commit();
        return successResponse(['city' => new CityResource($city)], 201, 'شهرستان با موفقیت ایجاد شد.');
    }

    /**
     * Show the specified resource.
     * @param $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($city)
    {
        $city = $this->repository->find($city);
        return successResponse(['city' => new CityResource($city)], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $city)
    {
        $city = $this->repository->find($city);
        $this->repository->update($city, [
            'name' => $request->name,
        ]);
        return successResponse(['city' => new CityResource($city)], 201, 'شهرستان مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     * @param $city
     */
    public function destroy($city)
    {
        $city = $this->repository->find($city);
        $this->repository->delete($city);
        return successResponse(['city' => new CityResource($city)], 200, 'شهرستان مورد نظر با موفقیت حذف شد.');
    }

}
