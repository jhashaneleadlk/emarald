<?php

namespace App\Helpers;

use App\Models\Common\PrimaryKeyInfo;
use App\Models\Common\TableLog;
use App\Models\LogDetail;
use App\Models\LogMain;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Helper
{
    public static function genPrimaryIDForBulk(object $primaryKeyInfo, $lastKey = ''): string
    {
        $gnPrefix['Y'] = date('y');

        $prefix = Helper::replaceWithTags($primaryKeyInfo->prefix, $gnPrefix);

        if (!empty($lastKey)) {
            $gen_id = substr($lastKey, strlen($prefix));
        } else {
            $gen_id = '0';
        }

        $max_id = ++$gen_id;

        return $prefix.str_pad($max_id, $primaryKeyInfo->numbof_chars, $primaryKeyInfo->pad_sym, STR_PAD_LEFT);
    }

    public static function replaceWithTags(string $string, array $rplce = []): array|string
    {
        foreach ($rplce as $key => $value) {
            $string = str_replace('%%'.$key.'%%', $value, $string);
        }

        return $string;
    }

    public static function generateOtp($length = 6): string
    {
        return substr(str_shuffle('0123456789'), 0, $length);
    }

    public static function getFixedValue($id, $title = ''): mixed
    {
        $value = FxdVal::when(!empty($title), function ($q) use ($title) {
            return $q->where('val_type', $title);
        })->where('val_id', $id)->first();

        return $value->val_des;
    }

    public static function logRecordFirstLast($consoleThis, string $startOrEnd): void
    {
        if ($startOrEnd == 'Start') {
            $logMainID = self::genPrimaryID('LOGID');
            $detailsContent = "$startOrEnd Command => {$consoleThis->getName()}. LOG_ID:$logMainID";
            LogMain::create([
                'log_id' => $logMainID,
                'log_name' => $consoleThis->getName(),
                'log_parameters' => self::getConsoleParameters($consoleThis->options(), $consoleThis->arguments()),
                'log_signature' => Str::of($consoleThis->signature)->squish()->remove("\n"),
            ])->LogDetails()
                ->create([
                    'content' => $detailsContent,
                ]);
            self::savePrimaryID('LOGID', $logMainID);
            $consoleThis->info($detailsContent);
            Log::channel('cronLogs')
                ->info($detailsContent);
            define('LOG_MAIN_ID', $logMainID);
        }
        if ($startOrEnd == 'End') {
            $detailsContent = "$startOrEnd Command => {$consoleThis->getName()}.";
            LogDetail::create([
                'log_id' => LOG_MAIN_ID,
                'content' => "$startOrEnd Command => {$consoleThis->getName()}.",
            ]);
            $consoleThis->info($detailsContent);
            Log::channel('cronLogs')->info($detailsContent."\n");
        }
    }

    public static function genPrimaryID($key, $dynPrefix = ''): ?string
    {
        $query = PrimaryKeyInfo::find($key);
        if (!empty($query)) {

            $gnPrefix['Y'] = date('y');
            $gnPrefix['DYN'] = $dynPrefix;

            $prefix = Helper::replaceWithTags($query->prefix, $gnPrefix);

            if (!empty($query->last_prkey)) {
                $genID = substr($query->last_prkey, strlen($prefix));
            } else {
                $genID = '0';
            }

            $maxID = ++$genID;

            $primaryKey = $prefix.str_pad($maxID, $query->numbof_chars, $query->pad_sym, STR_PAD_LEFT);
            $query->last_prkey = $primaryKey;
            $query->save();

            return $primaryKey;
        }

        return null;
    }

    public static function getConsoleParameters(array $options, array $arguments): string
    {
        $array = array_merge($arguments, $options);

        $unsetArray = ['help', 'quiet', 'verbose', 'version', 'ansi', 'no-interaction', 'env', 'command'];
        $array = Arr::except($array, $unsetArray);
        $parameterString = '';
        $i = 1;
        foreach ($array as $parameter => $value) {
            if ($value === true) {
                $value = 'true';
            }
            if ($value === false) {
                $value = 'false';
            }
            if ($value === null) {
                $value = 'null';
            }

            if (count($array) == $i) {
                $parameterString .= "{$parameter}: $value";
            } else {
                $parameterString .= "{$parameter}: $value, ";
            }
            $i = $i + 1;
        }

        return $parameterString;
    }

    public static function errorLog($consoleThis, string $detailsContent = 'Error occurred. Check log file'): void
    {
        LogMain::create([
            'log_id' => LOG_MAIN_ID,
            'log_name' => $consoleThis->getName(),
            'log_parameters' => self::getConsoleParameters($consoleThis->options(), $consoleThis->arguments()),
            'log_signature' => Str::of($consoleThis->signature)
                ->squish()
                ->remove("\n"),
        ]);

        self::logDetailsRecord(
            $consoleThis,
            "Start Command => {$consoleThis->getName()}. LOG_ID:".LOG_MAIN_ID,
            onlyDB: true
        );
        self::logDetailsRecord($consoleThis, $detailsContent, onlyDB: true);
        self::logDetailsRecord($consoleThis, "End Command => {$consoleThis->getName()}.", onlyDB: true);

        $consoleThis->error($detailsContent);
        Log::channel('cronLogs')
            ->error($detailsContent);

        $consoleThis->info("End Command => {$consoleThis->getName()}.");
        Log::channel('cronLogs')
            ->info("End Command => {$consoleThis->getName()}."."\n");
    }

    public static function logDetailsRecord(
        $consoleThis,
        string $content,
        string $level = 'info',
        string $relational_model = '',
        string $relational_id = '',
        bool $onlyDB = false
    ): void {
        $log_id = LOG_MAIN_ID;
        LogDetail::create(compact('log_id', 'content', 'level', 'relational_model', 'relational_id'));
        if (!$onlyDB) {
            $consoleContent = match ($level) {
                'emergency', 'alert', 'critical', 'error' => 'error',
                'warning', 'notice' => 'warn',
                'info', 'debug' => 'info'
            };
            $consoleThis->$consoleContent($content);
            Log::channel('cronLogs')
                ->$level($content);
        }
    }

    public static function errorMessageFilter(
        $e,
        $defaultMessage = 'System Error! Try again or Please contact administration'
    ): array {
        $condition = Str::startsWith((string) $e->getCode(), '123456789');
        $error['content'] = [
            'error' => $condition ? $e->getMessage() : $defaultMessage,
        ];

        $error['code'] = $condition ? 400 : 500;

        return $error;
    }

    public static function createLog($action = 'login', $guard = 'web'): void
    {
        $user = Auth::guard($guard)->user();

        $lastRecode = TableLog::where(['logable_id' => $user->getKey(), 'logable_type' => get_class($user)])
            ->orderByDesc('id')
            ->limit(1)
            ->select('batch')
            ->first()->batch ?? 0;
        $user->tableLogs()->create([
            'time' => $user->freshTimestamp(),
            'doer' => $user->getAuthIdentifier(),
            'user_id' => 'SYSTEM',
            'guard' => $guard,
            'action' => $action,
            'batch' => $lastRecode + 1,
            'transaction_batch' => 0,
            'ip_address' => request()->ip(),
            'via' => request()->segment(1) == 'api' ? 'Mobile' : 'Web',
        ]);
    }


    public static function datatableCustomSearches($customSearches = ''): string
    {
        $defaults = "
                var search = $('#searchText').val()
                var type = $('#searchByType').val();
                var status = $('#searchByStatus').val();
                var startDateRange = $('#startDateRange').val();
                var endDateRange = $('#endDateRange').val();
                data.searchByType = type;
                data.searchByStatus = status;
                data.startDateRange = startDateRange;
                data.endDateRange = endDateRange;
                data.search = search;
                ";

        return $defaults.' '.$customSearches;
    }

    public static function datatableDom($dom = ''): array
    {
        if (empty($dom)) {
            $dom = '<"card-header flex-column flex-md-row"<"head-label text-center d-flex align-items-center justify-content-center gap-1"><"dt-action-buttons text-end pt-3 pt-md-0 d-flex flex-column flex-sm-row gap-3 align-items-center flex-wrap justify-content-center justify-content-lg-end"B>><"row d-none"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>';
        }

        return [
            'dom' => $dom
        ];
    }

    public static function getAwsDirPath(string $append)
    {
        return config('filesystems.disks.s3.aws_sub_dir')."/{$append}";
    }

}
