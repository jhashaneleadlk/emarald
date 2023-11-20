<?php

namespace Database\Seeders;

use App\Models\Common\SeederManage;
use Illuminate\Console\View\Components\Error;
use Illuminate\Console\View\Components\Info;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $classes = $this->classesInNamespace();
        unset($classes[0]);
        $alreadySeedsClassNames = SeederManage::select(
            DB::raw("CONCAT('Database\\\Seeders\\\', seeder_class_name) as seeder_class_name")
        )
            ->get()
            ->pluck('seeder_class_name')->toArray();
        $arrayDiff = array_diff($classes, $alreadySeedsClassNames);
        if ($arrayDiff) {
            $this->call($arrayDiff);
        } else {
            with(new Info($this->command->getOutput()))->render('Nothing to seed!! Good to go');
        }
    }

    private function classesInNamespace(): array
    {
        $namespace = 'database/seeders/';

        return collect(File::allFiles($namespace))->map(function ($file) use ($namespace) {
            return Str::of($file->getFileInfo()->getFilename())
                ->before('.php')
                ->start(Str::of($namespace)->title()->replace('/', '\\'))
                ->toString();
        })->toArray();
    }

    public function SeederStructure(string $seederName, callable $function, $thisObj): void
    {
        $exists = SeederManage::where('seeder_class_name', $seederName)->exists();
        if (!$exists) {
            DB::beginTransaction();
            try {

                $function();

                SeederManage::create(['seeder_class_name' => $seederName]);
                DB::commit();
            } catch (\Throwable $th) {
                report($th);
                DB::rollBack();
                with(new Error($thisObj->command->getOutput()))->render('Error occurred. Check log file');
                exit();
            }
        } else {
            (new Info($thisObj->command->getOutput()))->render('Skipping.... Already done before');
        }
    }
}
