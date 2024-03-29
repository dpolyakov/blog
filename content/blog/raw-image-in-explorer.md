---
title: Просмотр RAW в проводнике Windows
date: '2012-08-15 00:47:39'
author: dima
id: '324'
type: post
slug: raw-image-in-explorer
---

  

Не так давно я что называется «распробовал» RAW-формат при съемке фото. Коротко для тех, кто не в курсе: RAW (формат файлов CR2 у Canon, NEF у Nikon) — это «сырые» данные о фотографии с матрицы фотоаппарата, которые записывает на карту фотоаппарат при съемке. Плюс съемки в raw в том, что при помощи программ обработки фото (Adobe Photoshop и Lightroom в первую очередь) вы сможете получить более качественную фотографию. Всё дело в том, что ресурсы фотоаппарата ограничены, и при фотографировании в jpeg он обрабатывает информацию с матрицы в пределах своих возможностей. На компьютере, естественно, обработать эти данные можно гораздо лучше.

  
  
  
  

У raw есть 2 несущественных минуса: размер файла одной фотографии больше по сравнению с jpeg, и невозможность просмотра изображений в проводнике Windows штатными средствами.

  
  
  
  

Первый минус практически не ощущается, т. к. флешки сейчас более чем доступны по цене.

  
  
  
  

Второй минус так же решается на удивление просто: у Microsoft оказывается есть **[Microsoft Camera Codec Pack](https://www.microsoft.com/en-us/download/details.aspx?id=40310)**, после установки которого raw\`ы прекрасно просматриваются в проводнике и [фотоколлекции Window Live](/blog/2010-10-06-266), а также в других программах на основе кодеков Windows Imaging Codec (WIC).