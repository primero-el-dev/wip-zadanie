# wip-zadanie

## Uruchomienie:
- Uruchom `git clone ` w docelowym katalogu, w którym ma się znaleźć projekt
- Skopius plik `.env.dist` i utwórz `.env` oraz ustaw odpowiednie wartości (`APP_ENV`, `MAIL_FROM`, `MAILER_DSN`, dalej następuje automatyczne pobieranie zależności, plik `.env.local` nie jest wczytywany)
- Po przejściu do katalogu z projektem wykonać `php setup.php` (nastąpi utworzenie pliku `docker-compose.yaml` z odpowiednimi danymi oraz postawienie projektu)
- \*Można załadować fikstury z przykładowym adminem (`docker-compose exec zadanie-php bin/console doctrine:fixtures:load`)

Projekt powinien być gotowy do użycia. Aplikacja jest dostępna pod adresem `http://localhost:81`.

## UWAGA:
mailjet podobno nie dostarcza maili na Gmail.
