<table>
    <tr></tr>
    <thead>
    <tr>
        <td width="3"></td>
        <th colspan="8" height="45" bgcolor="#B7DEE8" style="border: 1px solid #000; font-family: 'Times New Roman';">Imbalance Summary<br>{{ $summary->company }}
        </th>
    </tr>
    <tr>
        <td width="3"></td>
        <th valign="middle" bgcolor="#D8E4BC" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 12px; font-weight: bold; text-align: center;">Line</th>
        <th valign="middle" bgcolor="#D8E4BC" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 12px; font-weight: bold; text-align: center;">Buyer</th>
        <th valign="middle" bgcolor="#D8E4BC" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 12px; font-weight: bold; text-align: center;">Style</th>
        <th valign="middle" bgcolor="#D8E4BC" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 12px; font-weight: bold; text-align: center;">Item</th>
        <th valign="middle" bgcolor="#D8E4BC" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 12px; font-weight: bold; text-align: center;">Study<br>Date</th>
        <th valign="middle" bgcolor="#D8E4BC" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 12px; font-weight: bold; text-align: center;">Possible<br>Output</th>
        <th valign="middle" bgcolor="#D8E4BC" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 12px; font-weight: bold; text-align: center;">Actual<br>Production</th>
        <th valign="middle" bgcolor="#D8E4BC" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 12px; font-weight: bold; text-align: center;">Improve<br>Scope/hr</th>
    </tr>
    </thead>
    <tbody>
        @forelse($summary->lines as $line)
        <tr>
            <td width="3"></td>
            <td valign="middle" bgcolor="#DAEEF3" style="border: 1px solid #000; font-family: 'Times New Roman'; text-align: center;"><a href="sheet://'Line-{{ $line->line }}'!A1">Line-{{ $line->line }}</a></td>
            <td valign="middle" bgcolor="#DAEEF3" style="border: 1px solid #000; font-family: 'Times New Roman'; text-align: center;">{{ $summary->buyer }}</td>
            <td valign="middle" bgcolor="#DAEEF3" style="border: 1px solid #000; font-family: 'Times New Roman'; text-align: center;">{{ $summary->style }}</td>
            <td valign="middle" bgcolor="#DAEEF3" style="border: 1px solid #000; font-family: 'Times New Roman'; text-align: center;">{{ $summary->item }}</td>
            <td valign="middle" bgcolor="#DAEEF3" style="border: 1px solid #000; font-family: 'Times New Roman'; text-align: center;">{{ $summary->study_date }}</td>
            <td valign="middle" bgcolor="#DAEEF3" style="border: 1px solid #000; font-family: 'Times New Roman'; text-align: center;">{{ round($line->possible_output) }}</td>
            <td valign="middle" bgcolor="#DAEEF3" style="border: 1px solid #000; font-family: 'Times New Roman'; text-align: center;">{{ $line->achieved }}</td>
            <td valign="middle" bgcolor="#DAEEF3" style="border: 1px solid #000; font-family: 'Times New Roman'; text-align: center;">{{ round($line->possible_output - $line->achieved) }}</td>
        </tr>
        @empty
        <tr>
            <td width="3"></td>
            <td valign="middle" height="30" bgcolor="#DAEEF3" colspan="8" style="border: 1px solid #000; font-family: 'Times New Roman'; font-size: 14px; font-style: italic; text-align: center;">No Line Data Found!</td>
        </tr>
        @endforelse
    </tbody>
</table>