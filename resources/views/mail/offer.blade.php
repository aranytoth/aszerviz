<x-mail::message>
# Tisztelt Ügyfelünk!

Mellékelten küldjük a gépjárművel kapcsolatos ajánlatot.

Az ajánlatot böngészőben is megtekintheti
<x-mail::button :url="route('worksheet.view', ['worksheet' => $worksheet])">
Ajánlat megtekintése
</x-mail::button>

Üdvözlettel,<br>
{{ config('app.name') }}
</x-mail::message>
