<?php

///Observer dizajn patern se koristi kada želimo da implementiramo
///  "publish-subscribe" mehanizam. To znači da kada se neki događaj desi,
///  svi pretplaćeni "observers" će biti obavešteni o tom događaju i izvršiće odgovarajuću akciju.
//
//U Laravelu, postoje gotove implementacije Observer paterna za neke od
// osnovnih funkcija kao što su kreiranje, izmena i brisanje modela u bazi podataka.
// Ove implementacije se koriste kada želimo da automatski obavestimo druge
// delove sistema o promeni u bazi podataka.


namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function created(User $user)
    {
        Log::info("User {$user->name} with email {$user->email} registered successfully.");
    }
}


namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Register the observer(s).
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(UserObserver::class);
    }
}
