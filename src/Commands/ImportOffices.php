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
        $this->insertTypes();

        $rows = collect(json_decode(File::get(__DIR__ . "/../../assets/offices.json")));
        $this->info("Importing Offices : ");
        $this->output->progressStart($rows->count());

        //head offices

        $rows
            ->whereNull('parent_id')
            ->each(function ($row) {
                $this->insertOffice($row);
                $this->output->progressAdvance();
            });


        foreach (["RM/CRM", "DAO", "RAO", "CB", "BR"] as $type) {
            $rows->where('type', '=', $type)
                ->whereNotNull('parent_id')
                ->each(function ($cro) use ($type, $rows) {
                    $item = (new Office)->forceFill(
                        collect($cro)
                            ->except(['id', 'created_at', 'updated_at'])
                            ->toArray()
                    );

                    if (!is_null($cro->parent_id)) {
                        $raw_parent = $rows->where('id', '=', $cro->parent_id)->first();

                        $parent = Office::query()->where('code', '=', $raw_parent->code)->first();
                        $item->forceFill([
                            "parent_id" => $parent->id
                        ]);
                    }

                    $item->saveOrFail();
                });
        }

        $this->output->progressFinish();


        return 0;
    }

    /**
     * @throws \Throwable
     */
    private function insertOffice(\stdClass $office): bool
    {
        return (new Office)
            ->forceFill(
                collect($office)
                    ->except(['id', 'created_at', 'updated_at'])
                    ->toArray()
            )
            ->saveOrFail();
    }

    private function insertTypes()
    {
        $types = collect(json_decode(File::get(__DIR__ . "/../../assets/office_types.json")));
        $this->info("Importing Office Types: ");
        $this->output->progressStart($types->count());
        foreach ($types as $type) {
            $ot = new OfficeType();
            $ot->forceFill([
                "name"        => $type->OrgBranchType?->description,
                "bn_name"     => $type->OrgBranchType?->nameBn,
                "description" => $type->OrgBranchType?->description,
                "type"        => $type->OrgBranchType?->name,
            ])->saveOrFail();
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }
}
