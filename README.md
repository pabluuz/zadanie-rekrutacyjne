# Rozwiązanie

## Front-end

## Back-end

Proszę zaprojektować strukturę danych SQL (1), która będzie przechowywała dane główne obiektu typu numer, 
data utworzenia i aktualny status oraz historię zdarzeń w formie nazwy statusu i daty jego powstania. 
Proszę też zaprojektować obiekty PHP 7, które wykonywałyby operacje CRUD (2) na tych danych oraz operację wyszukiwania 
wg nazwy, daty, statusu aktualnego oraz wg statusu historycznego. Wartością dodaną byłby projekt API REST (3) lub SOAP, 
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
Crud znajduje się w [/src/Controller/ItemController.php](src/Controller/ItemController.php)   
Obsługuje on operacje:  
- **C** new
- **R** show
- **U** edit
- **D** delete
- find

### (3) REST API:
W kontrolerze zawiera się też REST API
- [x] Uniform Interface
- [x] Client-server
- [x] Stateless
- [ ] Cacheable (to be implemented, jeśli czas pozwoli https://symfony.com/doc/5.4/components/cache.html)
- [x] Layered system

Dla przykładu zaimplementowałem indeks itemów /item/ (GET). Dla ułatwienia przekierowałem tam domyślny route /  
W pliku `postman.json` znajduje się kolekcja do postmana z end-pointami

## Deploy:  
Polecam użyć wbudowanego webservera symfony
Baza danych sqlite dostarczona jest wraz z rozwiązaniem. W przypadku problemów:  
`php bin/console do:da:cr`  
`php bin/console do:mi:mi`  
`php bin/console do:fi:lo`  

![php słonik logo](https://php.net/images/logos/elephpant-running-78x48.gif)  
Wymaga php >= 7.4
