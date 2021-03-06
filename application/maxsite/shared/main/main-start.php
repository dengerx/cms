<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MaxSite CMS
 * (c) http://max-3000.com/
 */


// здесь определим $MAIN_FILE — ои используется в main-end.php
global $MAIN_FILE;

// если есть custom/main-template.php, то испольузм его
if ($fn = mso_fe('custom/main-template.php'))
{
	$MAIN_FILE = $fn;
}
else
{
	// main-шаблон вывода находится в meta-поле page_template
	// это определено в shared/meta/meta.ini
	// если метаполе не задано, то может использоваться main/type/page/main.php
	if (is_type('page') and isset($pages) and isset($pages[0]))
	{
		if ($page_template = mso_page_meta_value('page_template', $pages[0]['page_meta']))
		{
			if ($fn = mso_fe('main/' . $page_template . '/main.php')) 
			{	
				mso_set_val('main_file', $fn); // выставляем путь к файлу
			}
		}
		elseif ($fn = mso_fe('main/type/page/main.php')) // предопределенный файл
		{	
			mso_set_val('main_file', $fn); // выставляем путь к файлу
		}
		else
		{	
			if($page_template = mso_get_option('main_template_page', 'templates', '')) // опция
			{
				if ($fn = mso_fe('main/' . $page_template . '/main.php')) 
				{	
					mso_set_val('main_file', $fn); // выставляем путь к файлу
				}
			}
		}
		
	}
	else
	{
		// возможно есть main-файл по type
		// в main/type/home/main.php
		if ($fn = mso_fe('main/type/' . getinfo('type') . '/main.php')) 
		{	
			mso_set_val('main_file', $fn); // выставляем путь к файлу
		}
		else
		{
			// возможно указана опця
			// main_template_TYPE 
			// опции заданы в ini-файлах
			if ($page_template = mso_get_option('main_template_' . getinfo('type'), 'templates', ''))
			{
				if ($fn = mso_fe('main/' . $page_template . '/main.php')) 
				{	
					mso_set_val('main_file', $fn); // выставляем путь к файлу
				}
			}
		}
	}
}

$fn_main = mso_get_val('main_file', '');

if ($fn_main and file_exists($fn_main)) 
{
	$MAIN_FILE = $fn_main;
}
else 
{
	// main.php может находиться в каталоге main/ или в основном каталоге шаблона
	if ($fn = mso_fe('main/main.php')) $fn_main = $fn;
		else $fn_main = getinfo('template_dir') . 'main.php';
	
	// может быть задан main-файл по-умолчанию в опции main_template_default
	if ($page_template = mso_get_option('main_template_default', 'templates', ''))
	{
		if ($fn = mso_fe('main/' . $page_template . '/main.php')) 
		{	
			$fn_main = $fn; // выставляем путь к файлу
		}
	}
	
	$MAIN_FILE = $fn_main;
}

// css-класс для main
$main_name = str_replace(getinfo('template_dir'), '', $MAIN_FILE);
$main_name = str_replace('/main.php', '', $main_name);
$main_name = str_replace('main/', '', $main_name);
$main_name = 'main-' . $main_name;

mso_set_val('main_class', $main_name);

// дополнительный файл там же — main-function.php если есть, то подключаем сразу
$main_file_function = str_replace('.php', '-function.php', $MAIN_FILE);

if (file_exists($main_file_function)) require($main_file_function);

# библиотека для вывода записей в цикле и вывод колонок
require_once(getinfo('shared_dir') . 'stock/page-out/page-out.php');

# библиотека для работы с изображениями
require_once(getinfo('shared_dir') . 'stock/thumb/thumb.php');

ob_start();

# end file