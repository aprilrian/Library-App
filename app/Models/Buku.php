<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $primarykey = 'id';

    protected $fillable = [
        'isbn',
        'judul',
        'idkategori',
        'pengarang',
        'penerbit',
        'kota_terbit',
        'editor',
        'stok',
        'stok_tersedia',
        'file_gambar',
    ];


    public static function rules() {
        return [
            'isbn' => [
                'required',
                'regex:/^\d{1}-\d{3}-\d{5}-\d{1}$/',
                Rule::unique('books')->ignore('books', 'isbn'),
            ],
            'judul' => 'required',
            'idkategori' => 'required|in:1,2,3,4,5',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'kota_terbit' => 'required',
            'editor' => 'required',
            'stok' => 'required|numeric',
            'stok_tersedia' => 'required|numeric',
            'file_gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public static function updateRules(){
        return [
            'idkategori' => 'required|in:1,2,3,4',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'kota_terbit' => 'required',
            'editor' => 'required',
            'stok' => 'required|numeric',
            'stok_tersedia' => 'required|numeric',
            'file_gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }


    public static function messages() {
        return [
            'isbn.required' => 'The ISBN field is required.',
            'isbn.regex' => 'The ISBN format is not valid. Example: 1-234-56789-1',
            'isbn.unique' => 'The ISBN has already been taken.',
        ];
    }
}
