<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\StoreRequest;
use Modules\Category\Http\Requests\UpdateRequest;
use Modules\Category\Repositories\CategoriesRepositoryInterface;
use Modules\Category\Transformers\V1\CategoryResource;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

    private $repository;

    public function __construct(CategoriesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->paginate(10);
        return successResponse([
            'categories' => CategoryResource::collection($categories),
            'links' => CategoryResource::collection($categories)->response()->getData()->links,
            'meta' => CategoryResource::collection($categories)->response()->getData()->meta,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $category = $this->repository->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
        ]);
        DB::commit();
        return successResponse(['category' => new CategoryResource($category)], Response::HTTP_CREATED, 'دسته بندی با موفقیت ایجاد شد.');

    }

    /**
     * Display the specified resource.
     */
    public function show($category)
    {
        $category = $this->repository->find($category);
        return successResponse(['category' => new CategoryResource($category)], Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $category)
    {
        $category = $this->repository->find($category);
        DB::beginTransaction();
        $this->repository->update($category, [
            'name' => $request->name,
            'parent_id' => $request->parent_id ?: 0,
            'description' => $request->description,
        ]);
        DB::commit();
        return successResponse(['category' => new CategoryResource($category)], Response::HTTP_OK, 'دسته بندی با موفقیت ویرایش شد.');
    }

    /**
     * Display the children  resource from storage.
     * @param $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function children($category)
    {
        $category = $this->repository->find($category);
        return successResponse(['category' => new CategoryResource($category->load('children'))], Response::HTTP_OK);
    }

    /**
     * Display the parent  resource from storage.
     * @param $category
     * @return mixed
     */
    public function parent($category)
    {
        $category = $this->repository->find($category);
        return successResponse(['category' => new CategoryResource($category->load('parent'))], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param $category
     */
    public function destroy($category)
    {
        $category = $this->repository->find($category);
        $this->repository->delete($category);
        return successResponse(['category' => new CategoryResource($category)], Response::HTTP_OK, 'برند مورد نظر با موفقیت حذف شد.');
    }
}
