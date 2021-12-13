# Rozwiązanie

## Front-end

## Back-end

Proszę zaprojektować strukturę danych SQL (1), która będzie przechowywała dane główne obiektu typu numer, 
data utworzenia i aktualny status oraz historię zdarzeń w formie nazwy statusu i daty jego powstania. 
Proszę też zaprojektować obiekty PHP 7, które wykonywałyby operacje CRUD (2) na tych danych oraz operację wyszukiwania 
wg nazwy, daty, statusu aktualnego oraz wg statusu historycznego. Wartością dodaną byłby projekt API REST lub SOAP, 
które byłoby interfejsem do tych obiektów.

### (1) Struktura danych:

`>describe item`

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id | int | NO | PRI | NULL | auto\_increment |
| status\_type\_id | int | NO | MUL | NULL |  |
| name | varchar\(255\) | YES |  | NULL |  |
| number | bigint | YES |  | NULL |  |
| created\_at | datetime | NO |  | NULL |  |
| modified\_at | datetime | NO |  | NULL |  |


`>describe status_type`

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id | int | NO | PRI | NULL | auto\_increment |
| name | varchar\(255\) | NO |  | NULL |  |

  
`>describe status_history`

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id | int | NO | PRI | NULL | auto\_increment |
| item\_id | int | NO | MUL | NULL |  |
| status\_type\_id | int | NO | MUL | NULL |  |
| date | datetime | NO |  | NULL |  |

### (2) CRUD:
Crud znajduje się w src/Controller/ItemController.php oraz w src/Controller/StatusController.php  
Dodatkowo z poziomu dev można użyć php bin/console make:crud aby bardzo szybko zrobić jakiegokolwiek innego cruda

### (3) REST API:
W kontrolerze zawiera się też REST API
- [x] Uniform Interface
- [x] Client-server
- [x] Stateless
- [ ] Cacheable (z uwagi na czas pominąłem cache)
- [x] Layered system



## Deploy:  
Z dockerem:  
`docker-compose build --pull --no-cache`  
`docker-compose up`

Bez dockera (nie testowałem):  
Ustawiamy .env  
Odpalamy:  
php bin/console do:da:cr  
php bin/console do:mi:mi  
php bin/console do:fi:lo  

Serwis dostępny jest pod ``https://localhost/``

## Troubleshooting:
`docker-compose exec php composer install`  
`docker-compose exec php bin/console do:mi:mi`

## Na podstawie:
##### Boilerplate:
https://github.com/dunglas/symfony-docker  
##### Symfony:
https://symfony.com/  
zależności symfony zawarte są w composer.json
