@component('mail::message')

# {{ $body['title'] }}

Berikut adalah kode verifikasi untuk reset password Anda

@component('mail::panel')
<h1 style="text-align:center;">{{ $body['code'] }}</h1>
@endcomponent

Jika anda tidak membutuhkannya, abaikan Email ini atau hubungi kami.
@endcomponent
