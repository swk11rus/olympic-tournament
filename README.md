Описание задачи:
```angular2html
Разрешено использовать:

    docker - для разворачивания дефолтного образа PHP. Версия PHP на усмотрение программиста.
    Библиотеку GD

Задача:

Написать CLI-скрипт, который сформирует сетку матчей олимпийской системы розыгрыша.
На вход скрипт из командной строки должен получать стартовое общее число участников\команд.

    Кол-во игроков может задаваться от 0 до unsigned int32.
    Результат должен быть формироваться в виде файлов изображений.

Итоговые изображения должны:

    Содержать все матчи в виде прямоугольников
    Матчи должны содержать порядковый номер в котором они должны быть сыграны
    Матчи должны содержать информацию о победителях каких матчей должны быть в этом матче.
    Между матчами должны быть соединительные линии обозначающие переходы победителей между матчами. И в целом должно быть понятно куда переходит победитель
    Открываться без "усилий" на среднестатистическом компьютере "два ядра - два гига" с минимальным зумированием на 32'' мониторе (16:9) ;-)

Решение должно содержать пример запуска через docker exec.
```

Запуск:
```bash
docker build -t on
```
```bash
docker run -d -v ${PWD}/app:/usr/src/app/ --name olynet on:latest 
```
```bash
docker exec -it olynet bash -c "echo 16 >number"
```

Результат в файле `app/result/net.jpg`
