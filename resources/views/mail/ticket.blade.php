<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <style>
            body {
                font-family: Inter, sans-serif;
            }
            div.footer {
                text-align: center;
                font-size: 0.8em;
            }
            table {
                width: 100%;
                margin: 2em auto;
            }
            th {
                text-align: left;
            }
            th,
            td {
                padding: 0.2em 0.4em;
            }
        </style>
    </head>
    <body>
        <p>
            @if ($visit->client->gender === 0)
                Chère cliente,
            @else
                Cher client,
            @endif
        </p>

        <p>
            Trouvez ci-dessous les détails du ticket pour votre visite du {{ $visit->visit_date->format('d.m.Y') }} chez {{ config('app.tenant') }}.
        </p>

        <p>
            Merci pour votre visite !
        </p>

        <table>
            <tr>
                <th>Libellé</th>
                <th>Prix de base</th>
                <th>Prix facturé</th>
            </tr>
            @foreach($visit->sales as $sale)
            <tr>
                <td>{{ $sale->label }}</td>
                <td>{{ $sale->base_price }}</td>
                <td>{{ Number::format($sale->price_charged, 2) }}</td>
            </tr>
            @endforeach
        </table>

        <table>
            <tr>
                <th>Sous-total</th>
                <td>CHF {{ Number::format($visit->salessum, 2) }}</td>
            </tr>
            @if ($visit->discount)
                <tr>
                    <th>Remise</th>
                    <td>- {{ $visit->discount * 100 }} %</td>
                </tr>
            @endif
            @if ($visit->voucher_payment)
            <tr>
                <th>Paiement par bon</th>
                <td>CHF -{{ $visit->voucher_payment }}</td>
            </tr>
            @endif
            @if ($visit->tip)
            <tr>
                <th>Pourboire</th>
                <td>CHF {{ $visit->tip }}</td>
            </tr>
            @endif
            @if ($visit->rounding)
            <tr>
                <th>Arrondi</th>
                <td>CHF {{ Number::format($visit->rounding, 2) }}</td>
            </tr>
            @endif
            <tr>
                <td colspan=2><hr></td>
            </tr>
            <tr>
                <th>Total facturé</th>
                <td><strong>CHF {{ $visit->billed }}</strong></td>
            </tr>
        </table>

        <div class="footer">blaise</div>
    </body>
</html>
