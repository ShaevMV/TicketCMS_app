<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
Для восстановления пароля воспользуйтесь ссылкой {{ $urlForRecoveryPassword ?? '' }}
</body>
</html>
