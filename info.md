# Przetwarzanie Faktur za pomocą OCR

## Opis Projektu
Projekt to aplikacja webowa służąca do przetwarzania faktur za pomocą technologii OCR (Optical Character Recognition). Użytkownicy mogą przesyłać faktury, które są następnie przetwarzane i zapisywane w bazie danych. Aplikacja oferuje intuicyjny interfejs do zarządzania fakturami i kontami użytkowników.

### Kluczowe Funkcje:
1. **Autoryzacja Użytkowników**: Logowanie i zarządzanie kontami użytkowników.
2. **Przesyłanie i Przetwarzanie Faktur**: Możliwość przesyłania faktur, które są przetwarzane w celu wyodrębnienia danych.
3. **Zarządzanie Fakturami**: Przeglądanie przesłanych faktur i szczegółowych danych.
4. **Zarządzanie Kontem**: Możliwość usunięcia konta z potwierdzeniem w formie nakładki (overlay).

---

## Jak Uruchomić Stronę:

1. Uruchom Apache i MySQL w panelu sterowania XAMPP.
2. W phpMyAdmin zaimportuj plik SQL: `invoice_processing.sql`.
3. Wypakuj pliki do dowolnego folderu w: `xampp/htdocs`.
4. Otwórz ten folder w przeglądarce: `localhost/nazwa_twojego_folderu`.
5. Wymagania dodatkowe:
   - **Klucz API i Endpoint z Microsoft Azure AI**, aby działał skrypt do przetwarzania faktur.
   - **E-mail i hasło do skonfigurowania serwera SMTP**, co umożliwi wysyłanie wiadomości e-mail.
6. Skrypt CRON był uruchamiany lokalnie. Aby rozpocząć przetwarzanie faktur, musisz ręcznie uruchomić skrypt znajdujący się w: `scripts/invoice_ocr_script.php`.

---

## Proponowane Zmiany

### 1. **Poprawa Wyświetlania Danych Faktur**
   - **Obecny Stan**: Aplikacja wyświetla dane faktur w stałym formacie bez możliwości personalizacji.
   - **Proponowana Zmiana**: Dodanie funkcji umożliwiającej użytkownikom wybór pól danych, które mają być wyświetlane dla każdej faktury, np.:
     - Numer faktury
     - DataPodsumowanie Zmian
     - Kwota- **Wyświetlanie Faktur**: Dodanie opcji personalizacji wyświetlanych danych faktur.
     - Szczegóły dostawcyie lokalnego mechanizmu, system CRON do wykonywania okresowych zadań.
   - **Kroki Implementacji**:
     - Dodanie strony ustawień, gdzie użytkownicy mogą konfigurować pola do wyświetlenia.środowisku produkcyjnym.
     - Aktualizacja logiki wyświetlania faktur, aby dynamicznie renderować wybrane pola.     - Zapis preferencji użytkownika w bazie danych.
### 2. **Dodanie Mechanizmu CRON**
   - **Obecny Stan**: Aplikacja korzysta ze skryptu, który dopiero po włączeniu go przetwarza faktury jedna po drugiej. Mechanizm, który sprawia że dzieje się to co 5 minut, działa tylko lokalnie.
   - **Proponowana Zmiana**: Implementacja mechanizmu CRON do automatyzacji okresowych zadań na serwerze.
   - **Kroki Implementacji**:
     - Skonfigurowanie zadania CRON na serwerze, aby uruchamiało skrypt co 5 minut.
     - Przetestowanie działania CRON, aby upewnić się, że działa poprawnie.

---

## Podsumowanie Zmian
- **Wyświetlanie Faktur**: Dodanie opcji personalizacji wyświetlanych danych faktur.
- **CRON**: Zastąpienie lokalnego mechanizmu systemem CRON do wykonywania okresowych zadań.

Te zmiany poprawią użyteczność i skalowalność aplikacji, czyniąc ją bardziej niezawodną w środowisku produkcyjnym.
