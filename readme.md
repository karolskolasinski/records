# Records

Aplikacja umożliwia operacje CRUD na tabelach `record` oraz `track` za pośrednictwem API oraz GUI.

Aby skorzystać z API należy wysłać odpowiednie zapytanie pod określony adres:

### Record
  
- CREATE: zapytanie typu `POST` na endpoint: `/api/record.php`, gdzie w body należy wysłać JSON:

    ```json
      {
        "artist": "artist here",
        "title": "title here",
        "release_type": "mp3",
        "release_year": 2004
      }
    ```
  
  oraz ustawić nagłówek:
    - key: `Content-Type`
    - value: `application/json`

- READ (all): zapytanie typu `GET` na endpoint `/api/record.php`

- READ (one): zapytanie typu `GET` na endpoint `/api/record.php?id=?`, gdzie `?` jest numerem id

- UPDATE: zapytanie typu `PUT` na endpoint `/api/record.php`, gdzie w body należy wysłać JSON:
    ```json
          {
            "id": "?",  
            "artist": "artist here",
            "title": "title here",
            "release_type": "mp3",
            "release_year": 2004
          }
     ```
  w miejsce `"?"` należy podać id
  
- DELETE: zapytanie typu `DELETE` na endpoint `/api/record.php`, gdzie w body należy wysłać JSON:
    ```json
          {
            "id": "?"   
          }
     ```
  w miejsce `"?"` należy podać id

### Track

- CREATE: zapytanie typu `POST` na endpoint: `/api/track.php`, gdzie w body należy wysłać JSON:

    ```json
      {
        "record_id": 123,
        "title": "title here"
      }
    ```
  
  oraz ustawić nagłówek:
    - key: `Content-Type`
    - value: `application/json`

- READ (all): zapytanie typu `GET` na endpoint `/api/track.php`

- READ (one): zapytanie typu `GET` na endpoint `/api/track.php?id=?`, gdzie `?` jest numerem id

- UPDATE: zapytanie typu `PUT` na endpoint `/api/track.php`, gdzie w body należy wysłać JSON:
    ```json
          {
            "id": "?",  
            "record_id": 123,
            "title": "title here"            
          }
     ```
  w miejsce `"?"` należy podać id
  
- DELETE: zapytanie typu `DELETE` na endpoint `/api/track.php`, gdzie w body należy wysłać JSON:
    ```json
          {
            "id": "?"   
          }
     ```
  w miejsce `"?"` należy podać id

## Wykorzystano:
- PHP
- composer
- MySQL
- Materialize
- Heroku

## Kod źródłowy i demo
- code: https://github.com/karolskolasinski/records
- live: https://records-demo.herokuapp.com/

