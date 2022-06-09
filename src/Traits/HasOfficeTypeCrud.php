<?php
/**
 * This trait should be used in Controllers only, which will manage CRUD Operation of Offices
 */

namespace Wovosoft\BkbOffices\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Annotation\Route;
use Wovosoft\BkbOffices\Models\OfficeType;

trait HasOfficeTypeCrud
{
    /**
     * Selectable Columns in options
     * @var array|string[]
     */
    private array $optionsSelectableCols = [
        "id", "name", "bn_name", "description"
    ];
    private array $officesSelectableCols = [
        "id", "name", "bn_name", "code", "address"
    ];

    /**
     * Form Submit Validation Rules for store/update Operation
     * @var array|\string[][]
     */
    private array $formValidations = [
        "name" => ["required", "string"],
        "bn_name" => ["nullable", "string"],
        "description" => ["nullable", "string"]
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
            ->orWhere("bn_name", "LIKE", "%$filter%");
        return $builder;
    }

    private function officesQuery(Builder $builder, string $filter): Builder
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate($this->formValidations);
            $officeType = new OfficeType();
            $officeType->forceFill($validatedData);
            $officeType->saveOrFail();
            DB::commit();
            return response()->json([
                "message" => "Office Type Created Successfully"
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
     * @param OfficeType $officeType
     * @param Request $request
     * @return JsonResponse
     */
    public function update(OfficeType $officeType, Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate($this->formValidations);
            $officeType->forceFill($validatedData);
            $officeType->saveOrFail();
            DB::commit();
            return response()->json([
                "message" => "Office Type Updated Successfully"
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                "message" => $exception->getMessage()
            ], 403);
        }
    }

    /**
     * $request can contain pagination variables as
     * ['per_page'=> int,'columns' => array,'page_name' => string,'page'=> int]
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return OfficeType::query()
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
     * @param OfficeType $officeType
     * @return JsonResponse
     */
    public function destroy(OfficeType $officeType): JsonResponse
    {
        DB::beginTransaction();
        try {
            $officeType->deleteOrFail();
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
        return OfficeType::query()
            ->when($request->post("filter"), function (Builder $builder, string $filter) {
                $this->optionsQuery($builder, $filter);
            })
            ->limit($request->post("limit") ?? 25)
            ->select($this->optionsSelectableCols)
            ->get();
    }

    public function offices(OfficeType $officeType, Request $request)
    {
        return $officeType
            ->offices()
            ->when($request->post("filter"), function (Builder $builder, string $filter) {
                $this->officesQuery($builder, $filter);
            })
            ->limit($request->post("limit") ?? 25)
            ->select($this->officesSelectableCols)
            ->get();
    }
}
