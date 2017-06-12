<table>
    <thead>
        <tr>
            <th align="right">Qty</th>
            <th align="left">Description</th>
            <th align="right">Amount</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($transaction->items as $item)
            <tr>
                <td align="right">{{ $item->qty }}</td>
                <td align="left">{{ $item->model->name }}</td>
                <td align="right">{{ $item->gross_total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
