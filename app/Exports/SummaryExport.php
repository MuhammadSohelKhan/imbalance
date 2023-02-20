<?php

namespace App\Exports;

use App\Models\Summary;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SummaryExport implements WithMultipleSheets
{
    use Exportable;

    protected $summary;

    public function __construct($summary_id)
    {
    	$this->summary = $summary_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
    	$sheets = [];
    	$summaryLines = Summary::where('id', $this->summary)->with(['lines' => function ($ql)
    	{
    		$ql->with(['operations'=>function ($qo)
    		{
    			$qo->with('stages')->withCount('stages');
    		}]);
    	}])->first();

    	$sheets[] = new SummarySheet($summaryLines);

    	foreach ($summaryLines->lines as $index => $line) {
    		$sheets[] = new SummaryPerLineSheet($summaryLines, $line);
    	}

        return $sheets;
    }
}
