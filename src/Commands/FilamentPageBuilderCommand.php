<?php

namespace Sotiriskast\FilamentPageBuilder\Commands;

use Illuminate\Console\Command;

class FilamentPageBuilderCommand extends Command
{
    public $signature = 'filamentpagebuilder';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
