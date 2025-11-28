use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel transactions milikmu
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            
            $table->string('nama_produk'); // Nama barang
            $table->decimal('harga', 15, 2); // Harga satuan
            $table->integer('qty'); // Jumlah beli
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};