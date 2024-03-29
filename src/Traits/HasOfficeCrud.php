<?php

namespace Wovosoft\BkbOffices\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Annotation\Route;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Office;
use Wovosoft\BkbOffices\Requests\StoreOfficeRequest;

trait HasOfficeCrud
{
    /**
     * Selectable Columns in options
     * @var array|string[]
     */
    private array $optionsSelectableCols = [
        "id", "name", "bn_name", "code", "address"
    ];

    /**
     * If needed to modify options, just modify this method.
     * @param Builder $builder
     * @param string $filter
     * @return Builder
     */
    private function optionsQuery(Builder $builder, string $filter): Builder
    {
        $builder
            ->where("id", "=", $filter)
            ->orWhere("name", "LIKE", "%$filter%")
            ->orWhere("bn_name", "LIKE", "%$filter%")
            ->orWhere("code", "LIKE", "%$filter%")
            ->orWhere("address", "LIKE", "%$filter%");
        return $builder;
    }

    /**
     * @Route : "offices/store" as PUT Method
     * @param StoreOfficeRequest $request
     * @return JsonResponse
     */
    public function store(StoreOfficeRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $office = new Office();
            $office->forceFill($request->validated());
            $office->saveOrFail();
            DB::commit();
            return response()->json([
                "message" => "Office Created Successfully"
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                "message" => $exception->getMessage()
            ], 403);
        }
    }

    /**
     * @Route : "offices/update/{office}" as PUT Method
     * @param Office $office
     * @param StoreOfficeRequest $request
     * @return JsonResponse
     */
    public function update(Office $office, StoreOfficeRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $office->forceFill($request->validated());
            $office->saveOrFail();
            DB::commit();
            return response()->json([
                "message" => "Office Updated Successfully"
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                "message" => $exception->getMessage()
            ], 403);
        }
    }

    /**
     * Data Pagination
     * $request can contain pagination variables as
     * ['per_page'=> int,'columns' => array,'page_name' => string,'page'=> int]
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return Office::query()
            ->with(['parent'])
            ->when($request->input("type"), function (Builder $builder, string|OfficeTypes $type) {
                $builder->where("type", $type);
            })
            ->when($request->input("parent_id"), function (Builder $builder, int $parentId) {
                $builder->where("parent_id", $parentId);
            })
            ->when($request->input("filter"), function (Builder $builder, string $filter) {
                $builder->where("id", "=", $filter)
                    ->orWhere("name", "like", "%$filter%")
                    ->orWhere("code", "like", "%$filter%")
                    ->orWhere("bn_name", "like", "%$filter%");
            })
            ->paginate(
                perPage: $request->input("per_page") ?? 15,
                columns: $request->input("columns") ?? ['*'],
                pageName: $request->input("page_name") ?? "page",
                page: $request->input("page") ?? 1
            );
    }

    /**
     * First the office is resolve, cause direct removal without
     * resolving won't trigger delete related events.
     * @Route : "offices/delete/{office}" as DELETE Method
     * @param Office $office
     * @return JsonResponse
     * @throws \Throwable
     */
    public function destroy(Office $office): JsonResponse
    {
        DB::beginTransaction();
        try {
            $office->deleteOrFail();
            DB::commit();
            return response()->json([
                "message" => "Office Deleted Successfully"
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                "message" => $exception->getMessage()
            ], 403);
        }
    }

    /**
     * Provide options for dropdowns in front-end
     * method : POST
     * request params: filter => string, limit => int(25)
     * @param Request $request
     * @return Collection|array
     */
    public function options(Request $request): Collection|array
    {
        return Office::query()
            ->when($request->post("filter"), function (Builder $builder, string $filter) {
                $this->optionsQuery($builder, $filter);
            })
            ->limit($request->post("limit") ?? 25)
            ->select($this->optionsSelectableCols)
            ->get();
    }
}
