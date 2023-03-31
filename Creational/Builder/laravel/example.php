<?php

///Builder dizajn pattern u Laravelu se može koristiti kada se želi
///  izgraditi složen objekat koji se sastoji od mnogih delova.
///  Ovaj pattern se koristi kada postoji potreba da se kreira objekat
///  korak po korak, prilagođen specifičnim zahtevima ili parametrima.
//
//Najčešće se koristi kada se radi sa složenim formama ili kada se
// kreira upit za bazu podataka sa mnogo filtera i parametara.
// Ovaj pattern nam omogućava da izgradimo objekat korak po korak,
// a da se ne brinemo o detaljima svakog koraka.
//
//U Laravelu, Builder pattern se često koristi u okviru Query Builder-a,
// gde se koriste različiti metodi za kreiranje SQL upita, koji se kasnije
// izvršavaju nad bazom podataka.
//
//Primer koriscenja Builder patterna u Laravelu može biti izgradnja složenog
// upita nad bazom podataka korak po korak. Na primer, možemo kreirati
// QueryBuilder objekat, dodati filtere i sortiranja, a zatim izvršiti upit
// i dobiti rezultat.