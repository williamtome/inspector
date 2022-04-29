@component('mail::message')
# Cadastro Realizado.

Olá! Estamos muito felizes pro ter você aqui conosco.

Parabéns, você realizou o seu cadastro com sucesso.

Clique no botão abaixo para ser redirecionado para a nossa plataforma e
ao tentar fazer o login, informe esta senha que geramos automaticamente para você.

# {{ $password }}

@component('mail::button', ['url' => route('login')])
Acesse a plataforma
@endcomponent

Muito obrigado,<br>
{{ config('app.name') }}
@endcomponent
