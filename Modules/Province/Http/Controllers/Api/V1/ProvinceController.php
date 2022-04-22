<?php

namespace Modules\Province\Http\Controllers\Api\V1;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Province\Entities\Province;
use Modules\Province\Http\Requests\StoreRequest;
use Modules\Province\Http\Requests\UpdateRequest;
use Modules\Province\Repositories\ProvincesRepositoryInterface;
use Modules\Province\Transformers\ProvinceResource;

class ProvinceController extends Controller
{
    private $repository;

    public function __construct(ProvincesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * Return All Provinces with paginate
     */
    public function index()
    {
        $provinces = $this->repository->paginate(10);
        return successResponse([
            'provinces' => ProvinceResource::collection($provinces->load('cities')),
            'links' => ProvinceResource::collection($provinces)->response()->getData()->links,
            'meta' => ProvinceResource::collection($provinces)->response()->getData()->meta,
        ], 200);
    }

    /**
     * store Province
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $province = $this->repository->create([
            'name' => $request->name,
        ]);
        DB::commit();
        return successResponse(['province' => new ProvinceResource($province)], 201, 'استان با موفقیت با موفقیت ایجاد شد.');
    }

    /**
     * Show the specified resource.
     * @param $province
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($province)
    {
        $province = $this->repository->find($province);
        return successResponse(['province' => new ProvinceResource($province)], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param $province
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $province)
    {
        $province = $this->repository->find($province);
        $this->repository->update($province, [
            'name' => $request->name,
        ]);
        return successResponse(['province' => new ProvinceResource($province)], 201, 'استان مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     * @param $province
     */
    public function destroy($province)
    {
        $province = $this->repository->find($province);
        $this->repository->delete($province);
        return successResponse(['province' => new ProvinceResource($province)], 200, 'استان مورد نظر با موفقیت حذف شد.');
    }
}
