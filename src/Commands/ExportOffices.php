<?php

namespace Wovosoft\BkbOffices\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Wovosoft\BkbOffices\Models\Office;

class ExportOffices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:offices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Offices to json file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $offices = Office::query()
            ->orderBy('id')
            ->get();

        //store
        $file = __DIR__ . '/../../assets/offices.json';

        File::put(
            $file,
            $offices->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $this->info("Exported : " . $offices->count());

        return CommandAlias::SUCCESS;
    }
}
