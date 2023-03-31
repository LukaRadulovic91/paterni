<?php

/// U Laravel-u, "Abstract Factory" se koristi kada se kreira objekat
///  koji treba da bude specifičan za određenu aplikaciju ili okruženje.
///  Konkretno, "Abstract Factory" pattern omogućava kreiranje familije
///  povezanih objekata bez eksplicitnog navođenja njihovih klasa.
///  Na ovaj način se obezbeđuje lakša nadogradnja i fleksibilnost aplikacije.
//
//Jedan primer gde se može koristiti "Abstract Factory" pattern u Laravel-u
// jeste kada aplikacija treba da podrži više tipova skladišta podataka (npr. SQL i MongoDB).
// Umesto da u kodu eksplicitno navodimo klase ovih skladišta,
// možemo koristiti "Abstract Factory" pattern kako bismo obezbedili jednostavniju
// implementaciju novih skladišta bez potrebe za menjanjem postojećeg koda.

interface InvoiceFactory {
    public function createHeader(): InvoiceHeader;
    public function createFooter(): InvoiceFooter;
    public function createLineItem(): InvoiceLineItem;
}


class CanadianInvoiceFactory implements InvoiceFactory {
    public function createHeader(): InvoiceHeader {
        return new CanadianInvoiceHeader();
    }

    public function createFooter(): InvoiceFooter {
        return new CanadianInvoiceFooter();
    }

    public function createLineItem(): InvoiceLineItem {
        return new CanadianInvoiceLineItem();
    }
}


class AmericanInvoiceFactory implements InvoiceFactory {
    public function createHeader(): InvoiceHeader {
        return new AmericanInvoiceHeader();
    }

    public function createFooter(): InvoiceFooter {
        return new AmericanInvoiceFooter();
    }

    public function createLineItem(): InvoiceLineItem {
        return new AmericanInvoiceLineItem();
    }
}


class InvoiceController {
    public function create() {
        $location = Auth::user()->location;

        // Kreiranje instance odgovarajuće InvoiceFactory zavisno od lokacije
        $factory = $location === 'Canada'
            ? new CanadianInvoiceFactory()
            : new AmericanInvoiceFactory();

        // Kreiranje instance Invoice koristeći InvoiceFactory
        $invoice = new Invoice($factory);

        // ... Logika za dodavanje stavki na fakturu ...

        // Renderovanje HTML predloška fakture
        return view('invoice', ['invoice' => $invoice->toHtml()]);
    }
}
