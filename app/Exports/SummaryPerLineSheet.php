<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class SummaryPerLineSheet implements FromView, WithEvents, ShouldAutoSize, WithTitle
{
	private $summary;
	private $line;

	public function __construct($sumary, $sLine)
	{
		$this->summary = $sumary;
		$this->line = $sLine;
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $totalLostMin = 0;
        $minCapacity = $this->line->operations->min('capacity_per_hour');
        $totalMP = $this->line->operations->sum('allocated_man_power');

        foreach ($this->line->operations as $idx => $opr) {
        	$totalLostMin += ($opr->capacity_per_hour - $minCapacity) * $opr->cycle_time_with_allowance;
        }
        $imbalance = $totalLostMin / ($totalMP * 60);
        $balance = round((1 - $imbalance) * 100);
        $imbalance = round($imbalance * 100);

        return view('exports.line', ['summary' => $this->summary, 'line' => $this->line, 'totalLostMin' => $totalLostMin, 'minCapacity' => $minCapacity, 'totalMP' => $totalMP, 'imbalance' => $imbalance, 'balance' => $balance]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => '16'
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical'   => 'center'
                    ],
                ]);
            },
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Line-' . $this->line->line;
    }
}
