<html>

<body>
    <p>Авто-АС</p>
    <p>Ваш e-mail указан как контактный, при оформлении заказа</p>

    <p>
        Для подтверждения email, перейдите по ссылке
        {{-- {{ $link ?? 'x' }} --}}
    </p>

    <p>
        localhost <a target="_blank" href="http://localhost/email/verify/{{ $user->email ?? 'x' }}">Подтвердить E-mail</a>
        <br/>
        https://avto-as.ru/ <a target="_blank" href="https://avto-as.ru/email/verify/{{ $user->email ?? 'x' }}">Подтвердить E-mail</a>
        <br/>
        https://22.avto-as.ru/<a target="_blank" href="https://22.avto-as.ru/email/verify/{{ $user->email ?? 'x' }}">Подтвердить E-mail</a>
    </p>
    <pre>
    {{ $user ?? 'w' }}
</pre>
    <p>
        {{-- name: {{ $name ?? 'x' }} --}}
        <Br />
        {{-- mail: {{ $mail ?? 'x' }} --}}
    </p>
    <p>
        Привет Привет Привет Привет Привет Привет Привет
    </p>
    <p>
        Привет Привет Привет Привет Привет Привет Привет
    </p>
    <p>
        Привет Привет Привет Привет Привет Привет Привет
    </p>
    <p>
        Привет Привет Привет Привет Привет Привет Привет
    </p>

    <br />
    <br />
    <br />
    <br />

    <p>Вы можете отписаться от рассылки такого вида писем, для этого кликните на ссылку > 
        <br/>
        <br/>
        <br/>        localhost <a href="http://localhost/dop/mailStop/{{ $user->email ?? 'x' }}">Отписаться</a></p>
        <br/>        avto-as.ru <a href="https://avto-as.ru/dop/mailStop/{{ $user->email ?? 'x' }}">Отписаться</a></p>
        <br/>        22.avto-as.ru <a href="https://22.avto-as.ru/dop/mailStop/{{ $user->email ?? 'x' }}">Отписаться</a></p>
</body>

</html>
