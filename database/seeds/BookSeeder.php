<?php

use Illuminate\Database\Seeder;

use App\Book;
use App\User;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::updateOrCreate([
            'id' => 1,
        ], [
            'id' => 1,
            'name' => 'Romeo and Juliet',
            'author' => 'William Shakespeare',
        ]);

        Book::updateOrCreate([
            'id' => 2,
        ], [
            'id' => 2,
            'name' => 'Hamlet',
            'author' => 'William Shakespeare',
        ]);

        Book::updateOrCreate([
            'id' => 3,
        ], [
            'id' => 3,
            'name' => 'War and Peace',
            'author' => 'Leo Tolstoy',
        ]);

        User::find(1)->books()->sync([1,2]);
        User::find(2)->books()->sync([2,3]);
    }
}
