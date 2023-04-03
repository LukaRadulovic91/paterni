<?php

/// Decorator design pattern se koristi kada želimo da dinamički
///  proširimo funkcionalnost objekta, dodavanjem novih funkcija,
///  ali bez promene interfejsa samog objekta.
//
//  Konkretno, ovaj pattern se koristi u situacijama kada:
//
//  1.  Želimo da dodamo funkcionalnost objektu na dinamičan način,
// u zavisnosti od situacije i potrebe.
//  2.  Želimo da imamo mogućnost da koristimo različite kombinacije
// funkcionalnosti, bez promene osnovnog objekta.
//  3.  Želimo da izbegnemo situaciju u kojoj bi nasleđivanje koda
// dovelo do velikog broja različitih podklasa.
//
//Kao primer, možemo zamisliti aplikaciju koja omogućava kreiranje narudžbina.
// Svaka narudžbina ima određeni set artikala koje korisnik može da naruči.
// Da bismo omogućili korisniku da odabere različite vrste artikala, možemo koristiti Decorator pattern.

// app/Components/Component.php

namespace App\Components;

interface Component
{
    public function operation(): string;
}


// app/Components/UserProfile.php

namespace App\Components;

use App\Models\User;

class UserProfile implements Component
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function operation(): string
    {
        return "Name: " . $this->user->name . " " . $this->user->surname . ", Date of birth: " . $this->user->date_of_birth->format('Y-m-d');
    }
}


// app/Decorators/Decorator.php

namespace App\Decorators;

use App\Components\Component;

interface Decorator extends Component
{
    public function getAdditionalInfo(): string;
}


// app/Decorators/ProfileAge.php

namespace App\Decorators;

use App\Components\Component;

class ProfileAge implements Decorator
{
    private $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    public function operation(): string
    {
        return $this->component->operation() . ", Age: " . $this->getAdditionalInfo();
    }

    public function getAdditionalInfo(): string
    {
        return now()->diffInYears($this->component->getUser()->date_of_birth) . " years";
    }
}


// app/Http/Controllers/UserProfileController.php

namespace App\Http\Controllers;

use App\Components\UserProfile;
use App\Decorators\ProfileAge;
use App\Models\User;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        $component = new UserProfile($user);
        $decorator = new ProfileAge($component);

        return response()->json([
            'data' => $decorator->operation()
        ]);
    }
}
