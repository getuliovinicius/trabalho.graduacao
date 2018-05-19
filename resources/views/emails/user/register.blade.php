@component('mail::message')

# Olá {{ $name }}!

Obrigado por ter se registrado no **tgGV - Orçamento Pessoal**.

Clique no botão abaixo para confirmar o registro.

@component('mail::button', ['url' => $url, 'color' => 'green'])
Confirmar o registro
@endcomponent

Atenciosamente,

Equipe {{ config('app.name') }}.

@endcomponent
