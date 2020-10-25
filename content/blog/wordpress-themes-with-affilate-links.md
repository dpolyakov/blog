---
title: Бесплатные темы для Wordpress не совсем бесплатны!
date: '2008-07-22 01:19:44'
author: dima
id: '65'
type: post
slug: wordpress-themes-with-affilate-links
categories:
  - Про интернет
tags:
  - wordpress
  - темы
---

Думаю никто не станет спорить с тем, что популярность wordpress (система управления сайтом/блогом для тех, кто не в курсе) набирает обороты с каждым днем. Все дешевле становятся [хостинг и домены](/index/0-5), и многие решаются завести себе персональный блог. И чаще всего в качестве основы выбирают Wordpress.  
Конечно же после установки каждый хочет получить нечто уникальное по дизайну, а не стандартную тему. Те кто не силен в верстке и фотошопе выбирают готовые, и как правило, бесплатные темы. Вот тут то и кроется подвох. В некоторых бесплатных темах файл footer.php, который отвечает за низ страницы зашифрован, примерно так:  
  
`JiMxMDU1OyYjMTA4ODsmIzEwODA7JiMxMDg0OyYjMTA3NzsmIzEwODg7ICYjMTA3OTsmIzEwNzI7JiMxMDk2OyYjMTA4MDsmIzEwOTI7JiMxMDg4OyYjMTA4NjsmIzEwNzQ7JiMxMDcyOyYjMTA4NTsmIzEwODU7JiMxMDg2OyYjMTA3NTsmIzEwODY7ICYjMTA4MjsmIzEwODY7JiMxMDc2OyYjMTA3MjsgJiMxMDc2OyYjMTA4MzsmIzExMDM7ICYjMTA4OTsmIzEwOTA7JiMxMDcyOyYjMTA5MDsmIzExMDA7JiMxMDgwOyAmIzEwODU7JiMxMDcyOyAmIzEwODk7JiMxMDcyOyYjMTA4MTsmIzEwOTA7JiMxMDc3OyB3d3cucG9seWFrb3YubmV0LnJ1`  
  
На самом деле в нем зашифрованы ссылки на сайты. Причем не всегда этичного содержания. Согласитесь, а иметь непонятно откуда взявшиеся левые ссылки у себя на сайте не хочется никому. Поэтому многие пытаются решить проблему удалением зашифрованного кода. Однако, это не панацея, т.к. дизайн разъезжается напрочь. И что же делать?  
  
А выход есть. В этом нам поможет [Base64-декодер](http://www.motobit.com/util/base64-decoder-encoder.asp). Открываем footer.php, копируем зашифрованный код во второе окошко на странице, выбираем ниже **decode the data from a Base64 string (base64 decoding)** и жамкаем **Convert the source data**. Получаем в первом окошке незакодированный фрагмент. Удаляем из него "левые ссылки" и копируем в наш файл footer.php.  
Вот в принципе и все. С приведенным примером кодированного кода можете поэксперементировать)