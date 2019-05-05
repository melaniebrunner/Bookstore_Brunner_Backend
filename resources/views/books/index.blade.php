<ul>
    @foreach ($books as $book)
    <li>
        <a href="book/{{$book->id}}">
            {{$book->title}}
        </a>
    </li>
    @endforeach
</ul>