<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu {{ $paiement->id }}</title>
    <style>
        @page { margin: 22mm 18mm; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #2b211b; font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; line-height: 1.45; }
        .document { position: relative; min-height: 250mm; overflow: hidden; padding: 8mm; border: 1px solid #eadfcc; background: #fffaf3; }
        .gradient-watermark { position: absolute; inset: 0; z-index: 0; background: linear-gradient(135deg, rgba(198, 156, 72, .20), rgba(127, 29, 29, .08) 48%, rgba(248, 244, 239, .72)); }
        .logo-watermark { position: absolute; top: 62mm; left: 28mm; width: 120mm; opacity: .055; z-index: 0; }
        .content { position: relative; z-index: 1; }
        .header { display: table; width: 100%; padding-bottom: 8mm; border-bottom: 2px solid #c69c48; }
        .brand, .meta { display: table-cell; vertical-align: top; }
        .brand { width: 58%; }
        .meta { width: 42%; text-align: right; }
        .logo { width: 30mm; height: 30mm; object-fit: contain; vertical-align: middle; }
        .brand-text { display: inline-block; margin-left: 4mm; vertical-align: middle; }
        .brand-title { color: #3b2418; font-size: 21px; font-weight: 700; letter-spacing: 1px; }
        .brand-subtitle { color: #7f1d1d; font-size: 12px; font-style: italic; }
        .document-title { color: #7f1d1d; font-size: 24px; font-weight: 700; text-transform: uppercase; }
        .section { margin-top: 8mm; }
        .box { padding: 6mm; border: 1px solid #eadfcc; background: rgba(255, 255, 255, .84); }
        h2 { margin: 0 0 3mm; color: #3b2418; font-size: 13px; text-transform: uppercase; }
        .amount { margin: 8mm 0; padding: 7mm; background: #7f1d1d; color: #fff; font-size: 24px; font-weight: 700; text-align: center; }
        .grid { display: table; width: 100%; }
        .col { display: table-cell; width: 50%; vertical-align: top; }
        .muted { color: #76685d; }
        .signature { margin-top: 18mm; text-align: right; }
        .signature-line { display: inline-block; width: 55mm; border-top: 1px solid #3b2418; padding-top: 2mm; text-align: center; }
        .footer { margin-top: 12mm; padding-top: 5mm; border-top: 1px solid #c69c48; color: #76685d; font-size: 10px; text-align: center; }
        .print-button { position: fixed; right: 18px; top: 18px; padding: 10px 14px; border: 0; border-radius: 6px; background: #7f1d1d; color: #fff; font-weight: 700; cursor: pointer; }
        @media print { .print-button { display: none; } .document { border: 0; } }
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
                <div class="document-title">Reçu</div>
                <div><strong>Reçu N° {{ str_pad((string) $paiement->id, 5, '0', STR_PAD_LEFT) }}</strong></div>
                <div class="muted">Date : {{ $paiement->date_paiement?->format('d/m/Y') ?? now()->format('d/m/Y') }}</div>
            </div>
        </header>

        <section class="section box">
            <h2>Paiement reçu de</h2>
            <strong>{{ $paiement->client?->nom }}</strong><br>
            {{ $paiement->client?->telephone ?? '' }}
        </section>

        <div class="amount">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</div>

        <section class="section grid">
            <div class="col">
                <div class="box">
                    <h2>Mode de paiement</h2>
                    Type : {{ ucfirst($paiement->type) }}<br>
                    Moyen : {{ ucfirst($paiement->moyen) }}
                </div>
            </div>
            <div class="col">
                <div class="box">
                    <h2>Référence</h2>
                    Commande : {{ $paiement->commande?->numero ?? '-' }}<br>
                    Facture : {{ $paiement->facture?->numero ?? '-' }}
                </div>
            </div>
        </section>

        @if ($paiement->notes)
            <section class="section box">
                <h2>Notes</h2>
                {{ $paiement->notes }}
            </section>
        @endif

        <div class="signature">
            <span class="signature-line">Signature / Cachet</span>
        </div>

        <footer class="footer">
            Merci pour votre confiance. Djiméra Design - Chic & Glam.
        </footer>
    </div>
</main>
</body>
</html>
