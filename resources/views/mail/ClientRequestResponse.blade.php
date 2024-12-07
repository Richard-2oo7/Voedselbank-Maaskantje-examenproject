<x-mail.header/>
<p>
    Beste klant,<br>
    @if ($medewerkerReactie->word_klant)
        Uw verzoek is geaccepteerd. U kunt volgende week elke vrijdag uw voedselpakket ophalen.
    @else
        {{ $medewerkerReactie->redenering }}
    @endif
</p>
    <br>
<p>
    Met vriendelijke groet,<br>
    Voedselbank maaskantje
</p>
