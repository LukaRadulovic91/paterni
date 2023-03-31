<?php

// php artisan make:command CreateCar

// handle metoda

public function handle()
{
    // create new car
    $car = new Car;
    $car->make = $this->argument('make');
    $car->model = $this->argument('model');
    $car->year = $this->argument('year');
    $car->save();

    // dispatch inspection job
    InspectCar::dispatch($car);
}

// php artisan make:command InspectCar

public function handle()
{
    // inspect car
    $car = Car::find($this->argument('car'));
    $inspections = InspectionService::inspect($car);

    // check if car passed all inspections
    $passed = true;
    foreach ($inspections as $inspection) {
        if (!$inspection->passed) {
            $passed = false;
            break;
        }
    }

    // update car status
    $car->status = $passed ? 'for sale' : 'not for sale';
    $car->save();
}

// Controller

public function create(Request $request)
{
    // create new car
    CreateCar::dispatch(
        $request->input('make'),
        $request->input('model'),
        $request->input('year')
    );

    // redirect to cars list
    return redirect()->route('cars.index');
}

///  Command design pattern u Laravelu se koristi za izoliranje poslovne logike
///  iz kontrolera i rutiranja. To omogućava da se poslovna logika skladišti u
///  samostalne objekte (komande) koji mogu biti pozvani iz više mjesta u aplikaciji.
///  Neki primjeri kada možete koristiti Command design pattern u Laravelu uključuju:
//
//   1. Kada trebate izvršiti neku poslovnu logiku koja je složena i zahtjeva više koraka.
//
//    2. Kada imate ponavljajući kod u aplikaciji i želite ga refaktorizirati u zasebnu klasu.
//
//    3. Kada želite da se određeni koraci izvršavaju uvijek na isti način, bez obzira na to koji kontroler ih poziva.
//
//    4. Kada želite izvršiti operacije koje mogu biti otkazane ili izvršene kasnije (npr. naplata kreditne kartice ili slanje e-pošte).
//
//    5. Kada želite izvršiti više operacija u jednoj transakciji, kako bi se osiguralo da se sve operacije izvršavaju ili ne izvršavaju.
//
//   Ukratko, Command design pattern se koristi u Laravelu kada želite izolirati
//   poslovnu logiku od kontrolera i rutiranja, kako bi se postigla bolja modularnost,
//   fleksibilnost i ponovna iskoristivost.