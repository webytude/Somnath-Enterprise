<?php

namespace App\Services;

use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WorkOrderNumberService
{
    /**
     * Indian financial year label (Apr–Mar), e.g. 2025-26 means Apr 2025 to Mar 2026.
     */
    public static function fiscalYearLabelForDate(Carbon $date): string
    {
        $year = (int) $date->year;
        $month = (int) $date->month;
        if ($month >= 4) {
            $start = $year;
            $end = $year + 1;
        } else {
            $start = $year - 1;
            $end = $year;
        }

        return sprintf('%d-%02d', $start, $end % 100);
    }

    public static function normalizePrefix(string $prefix): string
    {
        $p = strtoupper(trim($prefix));

        return $p !== '' ? $p : 'GP';
    }

    public static function formatNumber(int $sequence, string $fiscalYearLabel, string $prefix = 'GP'): string
    {
        $p = self::normalizePrefix($prefix);

        return $p . '/' . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT) . '/' . $fiscalYearLabel;
    }

    /**
     * Preview next number (does not reserve).
     * Sequence is global (one running number for all work orders); prefix and financial year only affect the text, not ###.
     *
     * @param  string|null  $fiscalYearLabel  If null, derived from $date (Indian FY Apr–Mar).
     */
    public static function previewNext(
        Carbon $date,
        string $prefix = 'GP',
        ?string $fiscalYearLabel = null
    ): string {
        $fy = $fiscalYearLabel ?? self::fiscalYearLabelForDate($date);
        $p = self::normalizePrefix($prefix);
        $max = WorkOrder::max('sequence_number');
        $next = (int) ($max ?? 0) + 1;

        return self::formatNumber($next, $fy, $p);
    }

    /**
     * Allocate next global sequence (transaction + lock). Prefix and FY are stored for display only.
     *
     * @param  string|null  $fiscalYearLabel  If null, derived from $date.
     * @return array{fiscal_year_label: string, sequence_number: int, work_order_number: string, number_prefix: string}
     */
    public static function allocateNext(Carbon $date, string $prefix = 'GP', ?string $fiscalYearLabel = null): array
    {
        return DB::transaction(function () use ($date, $prefix, $fiscalYearLabel) {
            $fy = $fiscalYearLabel ?? self::fiscalYearLabelForDate($date);
            $p = self::normalizePrefix($prefix);
            $max = WorkOrder::query()->lockForUpdate()->max('sequence_number');
            $next = (int) ($max ?? 0) + 1;

            return [
                'number_prefix' => $p,
                'fiscal_year_label' => $fy,
                'sequence_number' => $next,
                'work_order_number' => self::formatNumber($next, $fy, $p),
            ];
        });
    }
}
