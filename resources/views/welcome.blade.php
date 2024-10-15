@extends('userz')
@section('content')
    <section class="hero">
        <div class="container2">
            <h1>2020 Reading Challenge</h1>
            <p>Want to get more out of your reading life in 2020? We've got a challenge just for you, and a free reading
                challenge kit to help you see it through. We care about quality way more than we quantity.</p>
<button class="button">Learn More</button>
        </div>
    </section>

    <section class="search">
        <div class="container4">
            <form>
                <input type="text" placeholder="Search books" />
                <button type="submit">Search</button>
            </form>
        </div>
    </section>

    <section class="book-features">
        <div class="container5">
            <h2>Discover Your Next Favorite Book</h2>
            <p>Explore our curated book lists, and find your next great read.</p>
            <ul>
                <li>
                    <img src="https://images.ctfassets.net/usf1vwtuqyxm/6S51pK7uwnyhkS9Io9DsAn/320c162c5150f853b8d8568c4715dcef/English_Harry_Potter_7_Epub_9781781100264.jpg?w=914&q=70&fm=jpg" alt="Book 1">
                    <h3>Book 1</h3>
                    <p>This is a description of Book 1.</p>
                </li>
                <li>
                    <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/b468d093312907.5e6139cf2ab03.png" alt="Book 2">
                    <h3>Book 2</h3>
                    <p>This is a description of Book 2.</p>
                </li>
                <li>
                    <img src="https://m.media-amazon.com/images/I/91fQAEtUQML._SL1500_.jpg" alt="Book 3">
                    <h3>Book 3</h3>
                    <p>This is a description of Book 3.</p>
                </li>
            </ul>
        </div>
    </section>


     
@endsection
