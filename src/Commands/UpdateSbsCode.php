<?php

namespace Wovosoft\BkbOffices\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Wovosoft\BkbOffices\Models\Office;

class UpdateSbsCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-sbs-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle(): void
    {
        $codes = collect(json_decode(File::get(__DIR__ . "/../../assets/sbs_branch_map.json")))
            ->where('sbs_code', '!=', '0000');
        $this->info($codes->count());

        $this->output->progressStart($codes->count());

        $codes->each(function (\stdClass $code) {
            $this->output->progressAdvance();
            $office = Office::query()->where('code', '=', str($code->bkb_code)->value())->first();
            if (!$office) {
                return;
            }
            $office->sbs_code = str($code->sbs_code)->padLeft(4, 0)->value();
            $office->saveOrFail();
        });
        $this->output->progressFinish();
    }
}
