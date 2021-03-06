# Micro Market

Выполненное тестовое задание. Список товаров
с возможностью редактирования, удаления и просмотра
с постраничным выводом.

## Установка

### Настройка бэкенда

PHP-часть из папки **backend** запускается как
обычное PHP-приложение через PHP-FPM, mod_php. Также
поддерживается встроенный веб-сервер. 

Для начала установите зависимости и подготовьте
файл с настройками:

```shell
composer install
cp .env.example .env
```

После этого откройте файл _.env_ в любом текстовом
редакторе и укажите правильные данные для соединения
с MySQL и Redis.

Быстро запустить встроенный веб-сервер
можно через утилиту make:

```shell
make debug
```

Дополнительно можно использовать
линтер [noVerify](https://github.com/VKCOM/noverify)
от команды ВКонтакте. Подготовка и запуск осуществляется
с помощью той же утилиты make:

```shell
make prepare
make lint
```

### Настройка фронтенда

Просто запустите **yarn install** для установки
зависимостей и укажите значение переменной
**REACT_APP_API_URL** с полным URL бэкенда.
После этого приложение можно запустить обычным образом:

```shell
# Установка зависимостей
yarn install

# Запуск в режиме разработки
REACT_APP_API_URL=http://localhost:8080/ yarn start

# Сборка для деплоя
REACT_APP_API_URL=http://localhost:8080/ yarn build
```

### Результат теста утилитой ab


