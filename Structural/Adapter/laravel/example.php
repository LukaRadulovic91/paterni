<?php

/// Adapter design pattern se koristi kada je potrebno
///  obezbediti kompatibilnost između dva različita interfejsa.
///  Na primer, ako koristite neki paket ili biblioteku koja ima
///  drugačiji interfejs nego što je to potrebno u vašoj aplikaciji,
///  možete koristiti adapter pattern kako biste prilagodili taj interfejs vašim potrebama.
//
//U Laravelu, adapter pattern se često koristi kada se radi sa
// različitim vrstama skladišta podataka. Na primer, ako koristite MySQL bazu podataka,
// ali aplikacija treba da radi sa Elasticsearch-om, možete koristiti adapter pattern
// kako biste obezbedili kompatibilnost između ova dva skladišta podataka.
//
//Još jedan primer primene adapter patterna u Laravelu može biti u radu
// sa različitim sistemima za slanje email poruka. Na primer, možete koristiti
// adapter pattern kako biste obezbedili kompatibilnost između Laravelovog
// ugrađenog email sistema i nekog drugog sistema za slanje email poruka koji preferirate.
//
//U suštini, adapter pattern se koristi kada treba prilagoditi postojeći kod nekom
// drugom sistemu ili tehnologiji, kako bi se izbegli veći zahvati u kodu.


namespace App\Adapters;

use App\Models\User;
use NewProfileLibrary\ProfileInterface;

class ProfileAdapter implements ProfileInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getFullName()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }

    public function getEmail()
    {
        return $this->user->email;
    }

    public function getPhoneNumber()
    {
        return $this->user->phone_number;
    }

    // implementacija svih ostalih metoda interfejsa
}


namespace App\Http\Controllers;

use App\Models\User;
use App\Adapters\ProfileAdapter;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user, Request $request)
    {
        // Originalna implementacija
        $profile = new NewProfileLibrary\Profile($user->id);
        $profileData = $profile->getProfileData();

        // Nova implementacija sa adapterom
        $profile = new ProfileAdapter($user);
        $profileData = [
            'full_name' => $profile->getFullName(),
            'email' => $profile->getEmail(),
            'phone_number' => $profile->getPhoneNumber(),
            // pozivi na ostale metode adaptera
        ];

        return view('profiles.show', compact('profileData'));
    }
}
