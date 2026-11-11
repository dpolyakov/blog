---
draft: false
title: Если Windows XP не показывает скрытые файлы
date: '2008-02-21 15:58:00'
author: dima
id: '13'
type: post
slug: windows-xp-no-hidden-files
aliases:
  - 2008-02-21-13
categories:
  - Про компы
tags:
  - вирусы
  - drweb
  - cureit!
  - regedit
---

Если у вас после удаления вирусов типа Brontok, vtorun.AD или чего-то типа того Windows XP не показывает скрытые файлы то эту проблеммку можно решить достаточно просто:
1. Убедиться, что вирус вы всё же удалили. Сделать это можно например так: скачать [бесплатную утилиту CureIt!](https://drweb.com) от DrWeb, и в безопасном режиме проверить комп.
2. Пуск -> Выполнить -> `regsvr32 /i shell32.dll`

После этого всё должно встать на свои места.
Если не помогло можно попробовать ручками поправить реестр:
Пуск -> Выполнить -> `regedit`

```
[HEY_CURRENT_USERSoftwareMicrosoftWindows
CurrentVersionExplorerAdvanced]
"Hidden"=dword:00000001
```

и
```
[HKEY_LOCAL_MACHINESOFTWAREMicrosoftWindows
CurrentVersionExplorerAdvancedFolderHiddenSHOWALL]
"CheckedValue"=dword:00000001"
```

Надеюсь совет поможет как и мне 😊
