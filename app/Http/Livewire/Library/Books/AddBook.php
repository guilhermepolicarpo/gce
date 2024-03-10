<?php

namespace App\Http\Livewire\Library\Books;

use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class AddBook extends Component
{
    public $addModal;
    public $book = [
        'isbn' => null,
        'title' => null,
        'subtitle' => null,
        'category_id' => null,
        'publisher_id' => null,
        'year_published' => null,
        'quantity_available' => null,
        'cover_image' => null,
    ];
    public $author = null;
    public $incarnateAuthor = null;

    protected function rules()
    {
        return [
            'book.isbn' => 'nullable|string|min:10|max:13|unique:books,isbn',
            'book.title' => 'required|string|min:3|max:255',
            'book.subtitle' => 'nullable|string|min:3|max:255',
            'book.category_id' => 'required|integer|exists:categories,id',
            'book.publisher_id' => 'required|integer|exists:publishers,id',
            'book.year_published' => ['required', 'date_format:Y', 'after_or_equal:1800', 'before_or_equal:' . date('Y'), 'min:4', 'max:4'],
            'book.quantity_available' => 'required|integer|min:0',
            'book.cover_image' => 'nullable|url|max:2048',
            'author' => 'required|integer|exists:authors,id',
            'incarnateAuthor' => 'nullable|integer|exists:authors,id',
        ];
    }

    protected $messages = [
        'book.isbn.min' => 'O ISBN do livro deve ter pelo menos 10 caracteres.',
        'book.isbn.max' => 'O ISBN do livro deve ter no máximo 13 caracteres.',
        'book.isbn.unique' => 'O ISBN do livro deve ser exclusivo. Ele ja foi usado por outro livro.',
        'book.title.required' => 'Por favor, digite o título do livro.',
        'book.title.min' => 'O título do livro deve ter pelo menos 3 caracteres.',
        'book.title.max' => 'O título do livro deve ter no máximo 255 caracteres.',
        'book.subtitle.required' => 'Por favor, digite o subtiulo do livro.',
        'book.subtitle.min' => 'O subtiulo do livro deve ter pelo menos 3 caracteres.',
        'book.subtitle.max' => 'O subtiulo do livro deve ter no máximo 255 caracteres.',
        'book.category_id.required' => 'Por favor, selecione uma categoria.',
        'book.category_id.exists' => 'Esta categoria não existe. Por favor, selecione uma categoria válida.',
        'book.publisher_id.required' => 'Por favor, selecione um editor.',
        'book.publisher_id.exists' => 'Este editor não existe. Por favor, selecione um editor válido.',
        'book.year_published.required' => 'Por favor, digite o ano de publicação.',
        'book.year_published.date_format' => 'O ano de publicação deve estar no formato AAAA.',
        'book.year_published.after_or_equal' => 'O ano de publicação deve ser posterior ou igual a 1800.',
        'book.year_published.before_or_equal' => 'O ano de publicação deve ser anterior ou igual ao ano atual.',
        'book.year_published.min' => 'O ano de publicação deve ter 4 caracteres.',
        'book.year_published.max' => 'O ano de publicação deve ter 4 caracteres.',
        'book.quantity_available.required' => 'Por favor, digite a quantidade disponível em estoque.',
        'author.required' => 'Por favor, selecione um autor.',
        'author.exists' => 'Este autor não existe. Por favor, selecione um autor válido.',
        'incarnateAuthor.exists' => 'Este autor não existe. Por favor, selecione um autor válido.',
    ];


    public function render()
    {
        return view('livewire.library.books.add-book');
    }

    public function saveBook(): void
    {
        $validated = $this->validate();

        $bookCreated = Book::create($validated['book']);
        $bookCreated->authors()->attach($validated['author']);
        $bookCreated->authors()->attach($validated['incarnateAuthor']);

        $this->emitUp('bookCreated');
        $this->reset('book', 'author', 'incarnateAuthor');
        $this->resetValidation();
    }

    public function saveBookAndClose(): void
    {
        $this->saveBook();
        $this->addModal = false;
    }


    public function getBookInformationFromOpenLibraryApi(): void
    {
        $isbn = $this->book['isbn'];

        if (!$isbn) {
            return;
        }

        if (strlen($isbn) !== 13 && strlen($isbn) !== 10) {
            return;
        }

        $response = Http::get("https://openlibrary.org/search.json?isbn={{ $isbn }}");

        if ($response->ok() && $response->json('numFound') > 0) {

            $book = $response->json('docs.0');

            $this->book['title'] = $book['title'];
            $this->book['year_published'] = $book['first_publish_year'];

            if ($book['cover_edition_key']) {
                $this->getBookCoverImage($book['cover_edition_key']);
            }
        }
    }

    public function getBookCoverImage($coverId): void
    {
        $cover_imageUrl = "https://covers.openlibrary.org/b/olid/$coverId-M.jpg";

        if ($this->book['cover_image'] === $cover_imageUrl) {
            return;
        }

        $this->book['cover_image'] = "https://covers.openlibrary.org/b/olid/$coverId-M.jpg";
    }
}
