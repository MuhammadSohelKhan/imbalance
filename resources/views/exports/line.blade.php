<table border="1">
    <thead>
    <tr>
        <th colspan="9" height="45" bgcolor="#B7DEE8" style="border: 1px solid #000; font-family: 'Times New Roman';">Imbalance check<br>{{ $summary->client->name }}</th>
        <th bgcolor="#FABF8F" style="color: #0000FF; border: 1px solid #000; font-family: 'Times New Roman';"><a href="sheet://'Summary'!A1">Back</a></th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Buyer</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->buyer }}</th>
            <th></th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Floor</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->floor }}</th>
            <th></th>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Possible Output</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round($line->possible_output) }}</th>
        </tr>
        <tr>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Style</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->style }}</th>
            <th></th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Line</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->line }}</th>
            <th></th>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Achieved</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->achieved }}</th>
        </tr>
        <tr>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Item</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->item }}</th>
            <th></th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Study Date</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->study_date }}</th>
            <th></th>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Imbalance%</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $imbalance }}%</th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th></th>
            <th></th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Allowance</th>
            <th align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $line->allowance }}%</th>
            <th></th>
            <th colspan="2" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Balance%</th>
            <th id="balanceCell" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $balance }}%</th>

            @for($s=1;$s<=$line->operations->max('stages_count');$s++)
            <td></td>
            <th colspan="5" align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Operation {{ $s }}</th>
            @endfor
        </tr>
        <tr>
            <th bgcolor="#B7DEE8" width="5" align="center" valign="middle" height="45" style="border: 1px solid #000; font-weight: bold; font-size: 11; font-family: 'Times New Roman'">SL</th>
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

        @foreach($line->operations as $opr)
        <tr>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $loop->iteration }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $opr->type }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $opr->machine }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $opr->average_cycle_time }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round($opr->cycle_time_with_allowance, 3) }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $opr->allocated_man_power }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round($opr->dedicated_cycle_time, 2) }}</td>
            <td align="center" valign="middle" @if($opr->capacity_per_hour == $minCapacity) bgcolor="#ffc7ce" @endif style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round($opr->capacity_per_hour) }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round($minCapacity) ?? '' }}</td>

            {{-- @php 
            $capDiff = ($opr->capacity_per_hour - $minCapacity) * $opr->cycle_time_with_allowance;
            @endphp  --}}

            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round(($opr->capacity_per_hour - $minCapacity) * $opr->cycle_time_with_allowance) }}</td>

            @forelse($opr->stages as $stage)
            <td></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->first }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->second }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->third }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->fourth }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $stage->fifth }}</td>
            @empty
            <td></td>
            <td align="center" valign="middle" colspan="5"></td>
            @endforelse
        </tr>
        @endforeach
        <tr>
            <td colspan="5" style="border: 1px solid #000;"></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $totalMP }}</td>
            <td style="border: 1px solid #000;"></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round($line->operations->avg('capacity_per_hour')) }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round($minCapacity) }}</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ round($totalLostMin) }}</td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="8"></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Imbalance</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $imbalance }}%</td>
        </tr>
        <tr>
            <td colspan="8"></td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">Balance</td>
            <td align="center" valign="middle" style="border: 1px solid #000; font-family: 'Times New Roman';">{{ $balance }}%</td>
        </tr>
    </tbody>
</table>