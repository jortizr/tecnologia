<?php

namespace App\Livewire\Navigation;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Sidebar extends Component
{
     /**
     * El nombre de la ruta activa actual.
     *
     * @var string
     */
    public string $currentRouteName;


    /**
     * Los equipos del usuario autenticado.
     *
     * @var \Illuminate\Support\Collection
     */
    public $teams;

       /**
     * Se ejecuta cuando el componente es inicializado.
     */
    public function mount(): void
    {
        $this->currentRouteName = request()->route()->getName();

        // Asegurarse de que el usuario está autenticado y tiene el método allTeams
        // if (Auth::check() && method_exists(Auth::user(), 'allTeams')) {
        //     $this->teams = Auth::user()->allTeams();
        // } else {
        //     $this->teams = collect(); // Devuelve una colección vacía si no hay equipos o usuario
        // }
    }

    public function render()
    {
        return view('livewire.navigation.sidebar');
    }
}
