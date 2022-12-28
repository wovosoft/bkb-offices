<?php

namespace Wovosoft\BkbOffices\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Wovosoft\BkbOffices\Models\Office;
use Wovosoft\BkbOffices\Models\OfficeType;

class ImportOffices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bkb-offices:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports Offices to Database';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Throwable
     */
    public function handle(): int
    {
        $rows = collect(json_decode(File::get(__DIR__ . "/../../assets/offices.json")));
        $this->info("Importing Offices : ");
        $this->output->progressStart($rows->count());
        $rows->each(function ($row) {
            $office = new Office();
            $office->forceFill([
                "name" => $row->name,
                "bn_name" => $row->bn_name,
                "code" => $row->code ?? null,
                "city" => $row->city ?? null,
                "phone" => $row->phone ?? null,
                "email" => $row->email ?? null,
                "routing_no" => $row->routing_number ?? null,
                "hrms_code" => $row->hrms_code ?? null,
                "address" => $row->mailing_address ?? null,
                "recommended_manpower" => 0,
                "description" => $row->description ?? null,
                "type" => $row->type,
                "parent_id" => null
            ]);
            $office->saveOrFail();
            $this->output->progressAdvance();
        });

        $this->info("\nFixing Parent=>Child Relation\n");
        $rows->each(function ($child) use ($rows) {
            if ($child->parent_id) {
                $parentCode = $rows
                    ->where("id", "=", $child->parent_id)
                    ->first()
                    ->code;

                $childOffice = Office::whereCode($child->code)->first();
                $parentOffice = Office::whereCode($parentCode)->first();

                $childOffice->parent_id = $parentOffice->id;
                $childOffice->save();
            }
        });

        $this->output->progressFinish();

        $types = collect(json_decode(File::get(__DIR__ . "/../../assets/office_types.json")));
        $this->info("Importing Office Types: ");
        $this->output->progressStart($types->count());
        foreach ($types as $type) {
            $ot = new OfficeType();
            $ot->forceFill([
                "name" => $type->OrgBranchType?->description,
                "bn_name" => $type->OrgBranchType?->nameBn,
                "description" => $type->OrgBranchType?->description,
                "type" => $type->OrgBranchType?->name,
            ])->saveOrFail();
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        return 0;
    }
}
