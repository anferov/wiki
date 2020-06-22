## Проект: Простой wiki движок
Публичная часть отдает html на остовании содержимого в базе
Все данные лежат в БД и представляют собой markdown документы с дополнительным функционалом:
- инлайн схемы plantuml рендарятся на лету в изображение
- инлайн схемы swagger рендарятся на лету в html
- инлайн ссылки на видео рендарятся на лету в html плеер
- нилайн ссылки на объекты бд рендарятся на лету в html


Закрытая часть предствляет собой админку, где можно быстро создаваь статьи 
редактор представляет собой текстовый редактор, с права от него онлайн превью 
так же редактор на лету позволяет добавлять сслкина обьектную модель по типу/тексту
Так же будет версионирование и редактирование сущностей, наример картинок

Версионирование будет идти по semver примерон так
<версия>.<количество публикаций>.<колличество сохраненных правок>
 - версия - по умолчанию 1, инкрементируется через админку
 - количество публикаций - увеличивается сразу после публикации.
 - колличество сохраненных правок - при внесении правок в опубликованный документ делается его копия контена, в которой при сохранении увеличивается данный параметр. При публикации обновляется количество публикаций а данный параметр становиться 0
  
Что будем использовать:
- docker
- sqllite
- symfony
- кастомный metaвata билдер, с логикой
- easy admin с CKeditor
- версионирование документов по semver
- поиск документов через elasticsearch
- тегирование докуметов

- написать нормальны стили самому

###  спринт 1
- [ ] настроить доккер контейнеры для php, nginx
- [ ] установить симфони 5.1, easyadmin
- [ ] настроить контейнер plantum
- [ ] настроить контейнер swagger 
- [ ] проверить интеграции

### спринт2
... пока в планах

```puml
@startuml

left to right direction

title Схема проекта

component plantUmlRenderer #990000 {
    
}

component swaggerRenderer #990000 {
    
}


interface Linkable {
    +getLink(): link
}

abstract class publishable implements Linkable {
    
    +getName(): string
    +activeFrom(): Date
    +activeTo(): ?Date
}

class version extends publishable{
    -magor: int
    -minor: int
    -patch: int
    +__toString():string
}

class Link {
    -class: string
    -id: uuid
    -slug
}

class Image implements Linkable {

}

class article extends publishable{
    -markdownText
    +getVersion(): version
    +getVersions(): []version
    +getContents(): string
}

class tag extends publishable {
    +getColor()
}



class swaggerParser implements ParserInterface
{
    Класс преобразует разметку вида 
    ```swagger в html представление
}

class planumlParser implements ParserInterface{
    Данный класс рендерит на лету разметку вида
    ```plantuml используя сторонный сервис 
    --
    -defaultSyle: string
    -defaultScheme: string
}
note right
    Продразумевается что парсеры 
    дополнительно формируют:
    - описание из диаграммы или картики
    - alt подпись
    - прочие сео штучки
end note

interface ParserInterface {
    +parse(string): string
}

class "MarkdownParser" as parser #003399 implements ParserInterface
{
    
}

class "MarkdownProcessor" as processor
{
    Класс отвечает за делегирование обработки
    преобразования markdown в html в 
    подключенные в него сервисы
    ==
    -parsers[]
    -cache
    --
    +getContents(article):string
    +addParser(Parser)
}

class VideoParser implements ParserInterface{
    Данный парсер достает из текста ссылки
    на видео (ютуб и прочие) и формирует из них 
    плеер в html5 с превью 
}

class DeepLinkParser implements ParserInterface{
    Данный парсер достает из текста 
    строку по шаблону, нахоидит 
    такую запись в бд и в зависимости 
    от типа элемента отрисовывает его
    в html

    так будут отрисовываться картинки
    из таблицы изображений
}

Linkable<-*Link
article "1" -r- "0..*" tag
article "1" -l- "1..*" version

processor "1" <-u-* "1..*" ParserInterface
swaggerParser<.d.>plantUmlRenderer : Сервис рендерит\nкартинку plantuml
planumlParser<.d.>swaggerRenderer : Сервис рендерит\nswagger html

@enduml
```