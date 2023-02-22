<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class SummarySheet implements FromView, WithEvents, ShouldAutoSize, WithTitle
{
	private $smry;

	public function __construct($summary)
	{
		$this->smry = $summary;
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.summary', ['summary' => $this->smry]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A2:H2')->applyFromArray([
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

    public function title(): string
    {
    	return 'Summary';
    }
}
