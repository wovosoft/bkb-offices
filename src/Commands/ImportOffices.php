<?php

namespace Wovosoft\BkbOffices\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Office;
use Wovosoft\BkbOffices\Models\OfficeType;

class ImportOffices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:offices';

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
        $dos = json_decode(File::get(base_path("packages/wovosoft/bkb-offices/assets/divisional_offices.json")));

        $doType = new  OfficeType();
        $doType->forceFill([
            "name" => "Divisional Office",
            "bn_name" => "বিভাগীয় কার্যালয়",
            "type" => OfficeTypes::DivisionalOffice
        ])->saveOrFail();

        $crType = new OfficeType();
        $crType->forceFill([
            "name" => "CRM/RM Office",
            "bn_name" => "মুখ্য আঞ্চলিক / আঞ্চলিক কার্যালয়",
            "type" => OfficeTypes::CRM_RMOffice
        ])->saveOrFail();

        $brType = new OfficeType();
        $brType->forceFill([
            "name" => "Branch",
            "bn_name" => "শাখা",
            "type" => OfficeTypes::Branch
        ])->saveOrFail();

        foreach ($dos as $do) {
            $doOffice = (new Office());
            $doOffice->forceFill([
                "name" => $do->name,
                "bn_name" => $do->bn_name ?? null,
                "code" => $do->code ?? null,
                "address" => $do->address ?? null,
                "recommended_manpower" => $do->recommended_manpower_quantity ?? null,
                "description" => $do->division ?? null,
                "office_type_id" => $doType->id
            ])->saveOrFail();
            foreach ($do->crm_offices as $crm_office) {
                $croOffice = new Office();
                $croOffice->forceFill([
                    "name" => $crm_office->name,
                    "bn_name" => $crm_office->bn_name ?? null,
                    "code" => $crm_office->code ?? null,
                    "address" => $crm_office->address ?? null,
                    "recommended_manpower" => $crm_office->recommended_manpower_quantity ?? null,
                    "description" => $crm_office->division ?? null,
                    "office_type_id" => $crType->id,
                    "parent_id" => $doOffice->id
                ])->saveOrFail();
                foreach ($crm_office->branches as $branch) {
                    $brOffice = new Office();
                    $brOffice->forceFill([
                        "name" => $branch->branch_name,
                        "bn_name" => $branch->bn_branch_name ?? null,
                        "code" => $branch->branch_code ?? null,
                        "address" => $branch->address ?? null,
                        "recommended_manpower" => $branch->recommended_manpower_quantity ?? null,
                        "office_type_id" => $brType->id,
                        "parent_id" => $croOffice->id
                    ])->saveOrFail();
                }
            }
        }
        return 0;
    }
}
