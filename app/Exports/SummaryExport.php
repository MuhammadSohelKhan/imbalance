<?php

namespace App\Exports;

use App\Models\Project;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SummaryExport implements WithMultipleSheets
{
    use Exportable;

    protected $summary;

    public function __construct($projid)
    {
    	$this->summary = $projid;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
    	$sheets = [];
    	$projectLines = Project::where('id', $this->summary)->with(['client:id,name', 'lines' => function ($ql)
    	{
    		$ql->where('is_archived', 0)->with(['operations'=>function ($qo)
    		{
    			$qo->with('stages')->withCount('stages');
    		}]);
    	}])->first();

    	$sheets[] = new SummarySheet($projectLines);

    	foreach ($projectLines->lines as $index => $line) {
    		$sheets[] = new SummaryPerLineSheet($projectLines, $line);
    	}

        return $sheets;
    }
}
