<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $facture->numero }}</title>
    <style>
        @page { margin: 22mm 18mm; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: #2b211b;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.45;
        }
        .document {
            position: relative;
            min-height: 250mm;
            overflow: hidden;
            padding: 8mm;
            border: 1px solid #eadfcc;
            background: #fffaf3;
        }
        .gradient-watermark {
            position: absolute;
            inset: 0;
            z-index: 0;
            background: linear-gradient(135deg, rgba(198, 156, 72, .20), rgba(127, 29, 29, .08) 48%, rgba(248, 244, 239, .72));
        }
        .logo-watermark {
            position: absolute;
            top: 64mm;
            left: 25mm;
            width: 125mm;
            opacity: .055;
            z-index: 0;
        }
        .content { position: relative; z-index: 1; }
        .header {
            display: table;
            width: 100%;
            padding-bottom: 8mm;
            border-bottom: 2px solid #c69c48;
        }
        .brand, .meta { display: table-cell; vertical-align: top; }
        .brand { width: 58%; }
        .meta { width: 42%; text-align: right; }
        .logo { width: 30mm; height: 30mm; object-fit: contain; vertical-align: middle; }
        .brand-text { display: inline-block; margin-left: 4mm; vertical-align: middle; }
        .brand-title { color: #3b2418; font-size: 21px; font-weight: 700; letter-spacing: 1px; }
        .brand-subtitle { color: #7f1d1d; font-size: 12px; font-style: italic; }
        .document-title { color: #7f1d1d; font-size: 24px; font-weight: 700; text-transform: uppercase; }
        .badge {
            display: inline-block;
            margin-top: 3mm;
            padding: 2mm 4mm;
            border-radius: 999px;
            background: #3b2418;
            color: #fff;
            font-size: 10px;
            text-transform: uppercase;
        }
        .section { margin-top: 8mm; }
        .grid { display: table; width: 100%; }
        .col { display: table-cell; width: 50%; vertical-align: top; }
        .box {
            min-height: 33mm;
            padding: 5mm;
            border: 1px solid #eadfcc;
            background: rgba(255, 255, 255, .80);
        }
        .box + .box { margin-left: 4mm; }
        h2 { margin: 0 0 3mm; color: #3b2418; font-size: 13px; text-transform: uppercase; }
        .muted { color: #76685d; }
        table { width: 100%; border-collapse: collapse; }
        th {
            padding: 3mm;
            background: #3b2418;
            color: #fff;
            font-size: 11px;
            text-align: left;
            text-transform: uppercase;
        }
        td {
            padding: 3mm;
            border-bottom: 1px solid #eadfcc;
            background: rgba(255, 255, 255, .82);
        }
        .right { text-align: right; }
        .totals { width: 72mm; margin-left: auto; margin-top: 5mm; }
        .totals td { padding: 2.5mm 3mm; }
        .total-row td {
            background: #7f1d1d;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
        }
        .footer {
            margin-top: 12mm;
            padding-top: 5mm;
            border-top: 1px solid #c69c48;
            color: #76685d;
            font-size: 10px;
            text-align: center;
        }
        .print-button {
            position: fixed;
            right: 18px;
            top: 18px;
            padding: 10px 14px;
            border: 0;
            border-radius: 6px;
            background: #7f1d1d;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
        }
        @media print {
            body { background: #fff; }
            .print-button { display: none; }
            .document { border: 0; }
        }
    </style>
</head>
<body>
@if ($printMode)
    <button class="print-button" onclick="window.print()">Imprimer</button>
@endif

<main class="document">
    <div class="gradient-watermark"></div>
    @if ($logoDataUri)
        <img src="{{ $logoDataUri }}" class="logo-watermark" alt="">
    @endif

    <div class="content">
        <header class="header">
            <div class="brand">
                @if ($logoDataUri)
                    <img src="{{ $logoDataUri }}" class="logo" alt="Djiméra Design">
                @endif
                <div class="brand-text">
                    <div class="brand-title">Djiméra Design</div>
                    <div class="brand-subtitle">Chic & Glam</div>
                </div>
            </div>
            <div class="meta">
                <div class="document-title">Facture</div>
                <div><strong>{{ $facture->numero }}</strong></div>
                <div class="muted">Date : {{ $facture->date_facture?->format('d/m/Y') ?? now()->format('d/m/Y') }}</div>
                @if ($facture->date_echeance)
                    <div class="muted">Échéance : {{ $facture->date_echeance->format('d/m/Y') }}</div>
                @endif
                <span class="badge">{{ $facture->statut }}</span>
            </div>
        </header>

        <section class="section grid">
            <div class="col">
                <div class="box">
                    <h2>Client</h2>
                    <strong>{{ $facture->client?->nom }}</strong><br>
                    {{ $facture->client?->telephone ?? '' }}<br>
                    {{ $facture->client?->adresse ?? '' }}
                </div>
            </div>
            <div class="col">
                <div class="box">
                    <h2>Détails</h2>
                    Type : {{ ucfirst($facture->type) }}<br>
                    Commande : {{ $facture->commande?->numero ?? '-' }}<br>
                    Tenue : {{ $facture->commande?->type_tenue ?? '-' }}<br>
                    Tissu : {{ $facture->commande?->tissu_utilise ?? '-' }}
                </div>
            </div>
        </section>

        <section class="section">
            <table>
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th class="right">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $facture->commande?->modele_demande ?: ($facture->commande?->type_tenue ?: 'Prestation couture Djiméra Design') }}
                            @if ($facture->commande?->notes)
                                <br><span class="muted">{{ $facture->commande->notes }}</span>
                            @endif
                        </td>
                        <td class="right">{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tbody>
            </table>

            <table class="totals">
                <tr>
                    <td>Total</td>
                    <td class="right">{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr>
                    <td>Payé</td>
                    <td class="right">{{ number_format($facture->montant_paye, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr class="total-row">
                    <td>Reste à payer</td>
                    <td class="right">{{ number_format($facture->reste_a_payer, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>
        </section>

        <footer class="footer">
            Merci pour votre confiance. Djiméra Design - Chic & Glam.
        </footer>
    </div>
</main>
</body>
</html>
