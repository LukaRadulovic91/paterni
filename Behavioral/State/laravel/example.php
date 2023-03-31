<?php

///State dizajn patern se koristi u Laravelu kada se neko ponašanje
///  objekta značajno menja na osnovu stanja u kojem se objekat nalazi.
///  Ovaj patern se obično koristi u situacijama kada se kompleksna
///  logika može podeliti u različita stanja, gde svako stanje ima svoje specifično ponašanje.
//
//Najčešći primer korišćenja State paterna u Laravelu je kod implementacije
// statusa narudžbine, gde stanja mogu biti "u obradi", "u pripremi", "isporučeno", "otkazano", itd.
// Svako od ovih stanja može imati svoje specifično ponašanje,
// na primer "u obradi" bi moglo značiti da se vrši provera dostupnosti proizvoda,
// "u pripremi" bi moglo značiti da se priprema paket za slanje, a "isporučeno"
// bi moglo značiti da se generiše potvrda o kupovini.
//
//State patern u Laravelu se takođe može koristiti za implementaciju kompleksnih
// procesa gde se stanja menjaju u zavisnosti od različitih faktora.
// Na primer, može se koristiti za implementaciju procesa narudžbine gde se
// stanja menjaju u zavisnosti od dostupnosti proizvoda, plaćanja, slanja itd.

interface ReservationState {
    public function confirm(Reservation $reservation);
    public function cancel(Reservation $reservation);
}

class UnconfirmedReservation implements ReservationState {
    public function confirm(Reservation $reservation) {
        $reservation->setState(new ConfirmedReservation());
    }

    public function cancel(Reservation $reservation) {
        $reservation->setState(new CanceledReservation());
    }
}

class ConfirmedReservation implements ReservationState {
    public function cancel(Reservation $reservation) {
        $reservation->setState(new CanceledReservation());
    }
}

class CanceledReservation implements ReservationState {
    // ne može se promeniti stanje nakon otkazivanja rezervacije
}


class Reservation {
    protected $state;

    public function __construct() {
        $this->setState(new UnconfirmedReservation());
    }

    public function setState(ReservationState $state) {
        $this->state = $state;
    }

    public function confirm() {
        $this->state->confirm($this);
    }

    public function cancel() {
        $this->state->cancel($this);
    }
}


class ReservationController extends Controller {
    public function confirm($id) {
        $reservation = Reservation::find($id);
        $reservation->confirm();
        $reservation->save();
        return redirect()->back();
    }

    public function cancel($id) {
        $reservation = Reservation::find($id);
        $reservation->cancel();
        $reservation->save();
        return redirect()->back();
    }
}
