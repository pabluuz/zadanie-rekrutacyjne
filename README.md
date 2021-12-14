# Rozwiązanie

## Back-end ![100%](https://progress-bar.dev/100)  
    
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
W pliku [postman.json](postman.json) znajduje się kolekcja do postmana z end-pointami

### Deploy:  
Polecam użyć wbudowanego webservera symfony
Baza danych sqlite dostarczona jest wraz z rozwiązaniem. W przypadku problemów:  
`php bin/console do:da:cr`  
`php bin/console do:mi:mi`  
`php bin/console do:fi:lo`  

![php słonik logo](https://php.net/images/logos/elephpant-running-78x48.gif)  
Wymaga php >= 7.4

## Front-end ![50%](https://progress-bar.dev/50)  
  
Pod adresem https://docs.sencha.com/extjs/6.2.0/ znajduje się dokumentacja framework-a Sencha ExtJS. 
Na podstawie tej dokumentacji proszę opisać najlepszy sposób połączenia danych z załączonego pliku JSON z 
aplikacją zawierającą listę danych (grid) (1) i edycję danych szczegółowych w formularzu (data form) (2). 
Wartością dodaną byłaby prosta implementacja w przykładowej aplikacji ExtJS.  
Załącznik: [Sample-201207.json](Sample-201207.json)

### Rozwiązanie (częściowe):
Aplikacja znajduje się w [/front/index.html](/front/index.html)  
Najmocniej przepraszam za bałagan w tej części repo
#### Co się udało:
(1) Sposób na załadowanie danych, który znalazłem w dokumentacji to użycie proxy z urlem jsona w store.
```
Ext.define('MyApp.store.Items', {
    extend: 'Ext.data.JsonStore',

    alias: 'store.Items',
    autoLoad: true,
    model: 'MyApp.model.Items',

    proxy: {
        type: 'ajax',
        url : 'Sample-201207.json',
        reader: {
            type: 'json'
        }
    }
});
```

(2) Bardzo prostą edycję, bez zapisu udało mi się uzyskać podpinając plugin pod widok
```
Ext.define('MyApp.view.main.List', {
.....
plugins: [
        Ext.create('Ext.grid.plugin.CellEditing', {
            clicksToEdit: 1
        })
    ],
.....
columns: [
        { text: 'ID',  dataIndex: 'ID', flex: 1  },
        { text: 'Name',  dataIndex: 'Name', flex: 1 ,
            editor: {
                xtype: 'textfield',
                allowBlank: false
            } },
```

#### Na co zabrakło czasu:
(1) Json z danymi ma dwa poziomy, tj - każdy `item` ma wiele `history`. Wyzwaniem przy tym
jest takie wyświetlenie grida, aby dało się jakoś wejść głębiej i edytować history.  
Rozważałem też opcję braku edycji history i wyświetlenia tego jako zwykłe pole rzutowane na stringa 
(wartość zmieniała by się przy edycji wartości statusu)  
(2) Do edycji danych powinienem użyć dataforma 
[https://docs.sencha.com/extjs/6.2.0/guides/quick_start/data_forms.html](https://docs.sencha.com/extjs/6.2.0/guides/quick_start/data_forms.html)  
i następnie - 
- wypełnić go danymi ze store
- dodać button Update w widoku
```
buttons: [
            {
                text: 'Update',
                itemId: 'btnUpdate',
                formBind: true,
                handler: 'onUpdateClick'
            },
```
- w kontrolerze dodać
```
onUpdateClick: function (sender, record) {
        ......

        itemForm.submit({
            url: '/api/item',
            ......
            headers:
            {
                'Content-Type': 'application/json'
            },
```
Dodatkowej lektury instrukcji wymagało by też same API do wysyłania rekordów, 
ponieważ nie wiem jeszcze jak to działa w ExtJs
