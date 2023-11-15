<?php
        $zapytanieKalendarz = "SELECT zgloszenia.id, zgloszenia.dataZdarzenia, CONCAT(ratownicy.imie, ' ', ratownicy.nazwisko) as ratownik, CONCAT(lekarze.imie, ' ', lekarze.nazwisko) as lekarz, CONCAT(dyspozytorzy.imie, ' ',
        dyspozytorzy.nazwisko) as dyspozytor, opis from zgloszenia INNER JOIN dyspozytorzy on zgloszenia.zgloszenie_dyspozytor = dyspozytorzy.id INNER JOIN lekarze on zgloszenia.zgloszenie_lekarz = lekarze.id
         INNER JOIN ratownicy on zgloszenia.zgloszenie_ratownik = ratownicy.id WHERE dataZdarzenia = '"
    ?>