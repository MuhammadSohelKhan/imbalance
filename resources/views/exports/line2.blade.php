<table border="1">
    <thead>
    <tr>
        <th colspan="9" height="45" bgcolor="#B7DEE8" style="border: 1px solid #000; font-family: 'Times New Roman';">Imbalance check<br>{{ $summary->company }}</th>
        <th bgcolor="#FABF8F" style="color: #0000FF; border: 1px solid #000; font-family: 'Times New Roman';"><a href="sheet://'Summary'!A1">Back</a></th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Buyer</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $summary->buyer }}</th>
            <th></th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Floor</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->floor }}</th>
            <th></th>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Possible Output</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->possible_output }}</th>
        </tr>
        <tr>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Style</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $summary->style }}</th>
            <th></th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Line</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->line }}</th>
            <th></th>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Achieved</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->achieved }}</th>
        </tr>
        <tr>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Item</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $summary->item }}</th>
            <th></th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Study Date</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $summary->study_date }}</th>
            <th></th>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Imbalance%</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=J{{count($line->operations)+9}}</th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th></th>
            <th></th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Allowance</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->allowance }}%</th>
            <th></th>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Balance%</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=J{{count($line->operations)+10}}</th>

            @for($s=1;$s<=$line->operations->max('stages_count');$s++)
            <td></td>
            <th colspan="5" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Operation {{ $s }}</th>
            @endfor
        </tr>
        <tr>
            <th bgcolor="#B7DEE8" align="center" valign="middle" height="45" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">SL</th>
            <th bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Operation</th>
            <th bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Machine</th>
            <th bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Avg.<br>Cycle<br>Time</th>
            <th bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Cycle time<br>(Min) with<br>Allowance</th>
            <th bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Allocated<br>MP</th>
            <th bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Dedicated<br>cycle time for<br>the Line(Min)</th>
            <th bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Capacity<br>per hour</th>
            <td bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Possible<br>Out put</td>
            <th bgcolor="#B7DEE8" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">Minutes<br>Lost per<br>hour</th>

            @for($s=1;$s<=$line->operations->max('stages_count');$s++)
            <td></td>
            <td width="7" align="center" valign="middle" style="border: 1px solid #000;">1</td>
            <td width="7" align="center" valign="middle" style="border: 1px solid #000;">2</td>
            <td width="7" align="center" valign="middle" style="border: 1px solid #000;">3</td>
            <td width="7" align="center" valign="middle" style="border: 1px solid #000;">4</td>
            <td width="7" align="center" valign="middle" style="border: 1px solid #000;">5</td>
            @endfor
        </tr>
        @foreach($line->operations as $idx => $opr)
        <tr>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $loop->iteration }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $opr->type }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $opr->machine }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=IFERROR(AVERAGE(L{{$idx+7}}:P{{$idx+7}},R{{$idx+7}}:V{{$idx+7}}),"")</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=IFERROR((D{{$idx+7}}/60)+((D{{$idx+7}}/60)*$F$5),"")</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $opr->allocated_man_power }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=IFERROR(E{{$idx+7}}/F{{$idx+7}},"")</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=IFERROR(60/G{{$idx+7}},"")</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=MIN(H$7:H${{count($line->operations)}})</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=IFERROR((H{{$idx+7}}-I{{$idx+7}})*E{{$idx+7}},"")</td>

            @forelse($opr->stages as $stage)
            <td></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->first }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->second }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->third }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->fourth }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->fifth }}</td>
            @empty
            <td></td>
            <td align="center" valign="middle" colspan="5" style="//background-color: #CCC0DA;"></td>
            @endforelse
        </tr>
        @endforeach
        <tr>
            <td colspan="5" style="border: 1px solid #000;"></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=SUM(F7:F{{count($line->operations)+6}})</td>
            <td align="center" valign="middle" style="border: 1px solid #000;"></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=AVERAGE(H7:H{{count($line->operations)+6}})</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=MIN(I7:I{{count($line->operations)+6}})</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=SUM(J7:J{{count($line->operations)+6}})</td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="8"></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Imbalance</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=J{{count($line->operations)+7}}/(F{{count($line->operations)+7}} * 60)</td>
        </tr>
        <tr>
            <td colspan="8"></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Balance</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">=1-J{{count($line->operations)+9}}</td>
        </tr>
    </tbody>
</table>