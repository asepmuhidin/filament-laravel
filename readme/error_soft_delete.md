# error_soft_delete

Jika kita menjalankan filament-resource --softdelete, akan error Call to undefined method Illuminate\Database\Eloquent\Builder::withoutTrashed()
ini diakibatkan ketika membuat migrate tidak menyertakan kolom deleted_at. untuk mengatasinya, contoh tabel categories
- buat migrate untuk menambahkan kolom tsb : php artisan make:migration add_deleted_at_to_categories_table --table=categories
- pada file migration 
  public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();<<== tambahkan ini
        });
    }
 - pada modelnya 
   use Illuminate\Database\Eloquent\SoftDeletes;
   class Category extends Model
   {
        use HasFactory, SoftDeletes;
   }    
- Jalankan migrate : php artisan migrate.

KALAU MAU ADA SOFT DELETE, JANGAN LUPA MENAMBAHKAN $table->softdelete(), pada file migration