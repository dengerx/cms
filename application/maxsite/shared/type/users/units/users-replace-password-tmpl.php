<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<p>{{ tf('Если у вас сохранился код активации, то вы можете сразу заполнить все поля. Если код активации утерян, то вначале введите только email и нажмите кнопку «Готово». На указанный email вы получите код активации. После этого вы можете вернуться на эту страницу и заполнить все поля.') }}</p>

<form method="post">{{ mso_form_session('f_session_id') }}

	<p><label>{{ tf('Ваш email') }} <input type="email" name="f_comusers_email" value=""></label></p>

	<p><label>{{ tf('Ваш код активации') }} <input type="text" name="f_comusers_activate_key" 
value=""></label></p>

	<p><label>{{ tf('Новый пароль') }} <input type="text" name="f_comusers_password" value=""></label></p>

	<p><button type="submit" name="f_submit[{{ $comusers_id }}]">{{ tf('Готово') }}</button></p>
</form>
