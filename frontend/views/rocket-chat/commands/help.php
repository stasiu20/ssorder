Dostępne polecenia to:
* info - zwraca id uzytkownika i informacje o powiazaniu (lub nie) konta z ssorder

* order - informacja o dzisiejszym zamowieniu lub braku

* last - informacja o ostatnim zrealizowanym zamowieniu (ale nie w dniu dzisiejszym)

* history - 'data od' [data do]
Gdzie obslugiwane formaty daty to:
YYYY-MM-DD
-5days (data sprzed 5dni)

Przykłady:
`history -5days` Wszystkie zamówienia sprzed 5 dni
`history -5days today` Wszystkie zamówienia od 5 dni wstecz do dnia dzisiejszego włącznie

* reorder NrZamownia [uwagi]
