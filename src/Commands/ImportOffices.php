<?php

namespace Wovosoft\BkbOffices\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Wovosoft\BkbOffices\Converters\CsvToCollection;
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

        $this->info("\nFixing Parent=>Child Relation");
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

//        $types = [
//            [
//                "name" => "Divisional Office",
//                "bn_name" => "বিভাগীয় কার্যালয়",
//                "type" => OfficeTypes::DivisionalOffice
//            ],
//            [
//                "name" => "CRM/RM Office",
//                "bn_name" => "মুখ্য আঞ্চলিক / আঞ্চলিক কার্যালয়",
//                "type" => OfficeTypes::CRM_RMOffice
//            ],
//            [
//                "name" => "Branch",
//                "bn_name" => "শাখা",
//                "type" => OfficeTypes::Branch
//            ],
//            [
//                "name" => "Divisional Audit Office",
//                "bn_name" => "বিভাগীয় নিরীক্ষা কার্যালয়",
//                "type" => OfficeTypes::DivisionalAuditOffice
//            ],
//            [
//                "name" => "Regional Audit Office",
//                "bn_name" => "আঞ্চলিক নিরীক্ষা কার্যালয়",
//                "type" => OfficeTypes::RegionalAuditOffice
//            ],
//            [
//                "name" => "Corporate Branch",
//                "bn_name" => "কর্পোরেট শাখা",
//                "type" => OfficeTypes::CorporateBranch
//            ],
//            [
//                "name" => "Head Office",
//                "bn_name" => "প্রধান কার্যালয়",
//                "type" => OfficeTypes::HeadOffice
//            ]
//        ];
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
//
//        $dos = json_decode(File::get(realpath(__DIR__ . "/../../assets/divisional_offices.json")));
//
//
//        foreach ($dos as $do) {
//            $doOffice = (new Office());
//            $doOffice->forceFill([
//                "name" => $do->name,
//                "bn_name" => $do->bn_name ?? null,
//                "code" => $do->code ?? null,
//                "address" => $do->address ?? null,
//                "recommended_manpower" => $do->recommended_manpower_quantity ?? null,
//                "description" => $do->division ?? null,
//                "type" => OfficeTypes::DivisionalOffice
//            ])->saveOrFail();
//
//            foreach ($do->crm_offices as $crm_office) {
//                $croOffice = new Office();
//                $croOffice->forceFill([
//                    "name" => $crm_office->name,
//                    "bn_name" => $crm_office->bn_name ?? null,
//                    "code" => $crm_office->code ?? null,
//                    "address" => $crm_office->address ?? null,
//                    "recommended_manpower" => $crm_office->recommended_manpower_quantity ?? null,
//                    "description" => $crm_office->division ?? null,
//                    "type" => OfficeTypes::CRM_RMOffice,
//                    "parent_id" => $doOffice->id
//                ])->saveOrFail();
//                foreach ($crm_office->branches as $branch) {
//                    $brOffice = new Office();
//                    $brOffice->forceFill([
//                        "name" => $branch->branch_name,
//                        "bn_name" => $branch->bn_branch_name ?? null,
//                        "code" => $branch->branch_code ?? null,
//                        "address" => $branch->address ?? null,
//                        "recommended_manpower" => $branch->recommended_manpower_quantity ?? null,
//                        "type" => OfficeTypes::Branch,
//                        "parent_id" => $croOffice->id
//                    ])->saveOrFail();
//                }
//            }
//        }
//        $this->info("Divisional Offices, CRM-RM Offices & Branches Imported");
//
//        $daos = json_decode(File::get(realpath(__DIR__ . "/../../assets/audit_offices.json")));
//        foreach ($daos as $dao) {
//            $daoOffice = (new Office());
//            $daoOffice->forceFill([
//                "name" => $dao->name,
//                "bn_name" => $dao->bn_name ?? null,
//                "code" => $dao->code ?? null,
//                "address" => $dao->address ?? null,
//                "recommended_manpower" => $dao->recommended_manpower_quantity ?? null,
//                "description" => $dao->division ?? null,
//                "type" => OfficeTypes::DivisionalAuditOffice
//            ])->saveOrFail();
//            foreach ($dao->regional_audit_offices as $rao) {
//                $rao_office = new Office();
//                $rao_office->forceFill([
//                    "name" => $rao->name,
//                    "bn_name" => $rao->bn_name ?? null,
//                    "code" => $rao->code ?? null,
//                    "address" => $rao->address ?? null,
//                    "recommended_manpower" => $rao->recommended_manpower_quantity ?? null,
//                    "description" => $rao->division ?? null,
//                    "type" => OfficeTypes::RegionalAuditOffice,
//                    "parent_id" => $daoOffice->id
//                ])->saveOrFail();
//            }
//        }
//
//        $this->info("Divisional Audit & Regional Audit Offices Imported");
//
//        $hos = json_decode(File::get(realpath(__DIR__ . "/../../assets/head_offices.json")));
//        foreach ($hos as $ho) {
//            (new Office())->forceFill([
//                "name" => $ho->name,
//                "bn_name" => $ho->bn_name ?? null,
//                "code" => $ho->code ?? null,
//                "address" => $ho->address ?? null,
//                "type" => OfficeTypes::HeadOffice
//            ])->saveOrFail();
//        }
//        $this->info("Head Offices Imported");
        return 0;
    }
}
