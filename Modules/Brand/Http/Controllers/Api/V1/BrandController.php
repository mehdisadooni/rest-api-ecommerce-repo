<?php

namespace Modules\Brand\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Http\Requests\StoreRequest;
use Modules\Brand\Http\Requests\UpdateRequest;
use Modules\Brand\Repositories\BrandsRepositoryInterface;
use Modules\Brand\Transformers\V1\BrandResource;

class BrandController extends Controller
{

    private $repository;

    public function __construct(BrandsRepositoryInterface $brands)
    {
        $this->repository = $brands;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = $this->repository->paginate(10);
        return successResponse([
            'brands' => BrandResource::collection($brands),
            'links' => BrandResource::collection($brands)->response()->getData()->links,
            'meta' => BrandResource::collection($brands)->response()->getData()->meta,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $brand = $this->repository->create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);
        DB::commit();
        return successResponse(['brand' => new BrandResource($brand)], 201, 'برند با موفقیت ایجاد شد.');
    }

    /**
     * Show the specified resource.
     * @param $brand
     */
    public function show($brand)
    {
        $brand = $this->repository->find($brand);
        return successResponse(['brand' => new BrandResource($brand)], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param $brand
     */
    public function update(UpdateRequest $request, $brand)
    {
        $brand = $this->repository->find($brand);
        $this->repository->update($brand, [
            'name' => $request->name,
            'display_name' => $request->display_name
        ]);
        return successResponse(['brand' => new BrandResource($brand)], 201, 'برند مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     * @param $brand
     */
    public function destroy($brand)
    {
        $brand = $this->repository->find($brand);
        $this->repository->delete($brand);
        return successResponse(['brand' => new BrandResource($brand)], 200, 'برند مورد نظر با موفقیت حذف شد.');
    }
}
