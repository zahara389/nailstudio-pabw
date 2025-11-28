<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Newsletter; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Footer extends Component
{
   
    public $email = ''; 
    
    
    public $message = '';

    
    protected function rules()
    {
        return [
            
            'email' => [
                'required', 
                'email', 
                Rule::unique('newsletter_subscribers', 'email'),
            ],
        ];
    }
    
    // Pesan kustom untuk validasi
    protected $messages = [
        'email.required' => 'Mohon masukkan alamat email Anda.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar sebagai subscriber kami.',
    ];
    
    // Method yang dipanggil saat form disubmit
    public function subscribe()
    {
        $this->validate();

        try {
            // Simpan email ke database
            Newsletter::create([
                'email' => $this->email,
                // Mengambil user_id jika user sedang login
                'user_id' => Auth::check() ? Auth::id() : null,
            ]);

            // Set pesan sukses dan reset input
            $this->message = 'Terima kasih! Anda berhasil berlangganan newsletter kami.';
            $this->email = '';

        } catch (\Exception $e) {
            // Logika fallback error
            $this->message = 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.';
        }
    }

    public function render()
    {
        // Menampilkan view Blade
        return view('livewire.footer');
    }
}