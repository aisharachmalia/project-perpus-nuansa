<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<style>
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    color: #333;
}
body {
        font-family: 'Poppins', sans-serif;
    }
header {
position: fixed;
width: 100%;
top: 0;
left: 0;
z-index: 1000;
background: rgba(0, 0, 0, 0.4);
padding: 20px 0;
transition: background 0.3s ease;
}

header.sticky {
background: rgba(0, 0, 0, 0.7);
box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.container {
max-width: 1200px;
margin: 0 auto;
display: flex;
align-items: center;
justify-content: space-between;
}

.logo {
flex: 1; 
}
.logo img {
    width: 60px; /* Mengubah ukuran lebar logo */
    height: 50px; /* Menjaga proporsi */
}

nav {
flex: 38; /* Flexbox untuk nav agar berada di tengah */
}

nav ul {
list-style: none;
display: flex;
justify-content: center; /* Buat menu berada di tengah */
gap: 30px;
margin: 0;
padding: 0;
}

nav a {
color: #fff;
text-transform: uppercase;
text-decoration: none;
font-weight: bold;
padding: 10px 15px;
transition: color 0.3s ease, background-color 0.3s ease;
border-radius: 5px;
}

nav a:hover {
color: #fff;
background-color: rgba(255, 255, 255, 0.1);
}

nav a.active {
background-color: rgba(255, 255, 255, 0.2);
}

.cart-icon {
/* flex: 1; /* Flexbox untuk menjaga ikon cart di kanan */
text-align: right; */
}
/* 
.cart-icon img {
width: 30px;
height: auto;
} */

@media (max-width: 768px) {
nav ul {
flex-direction: column;
align-items: center;
}
}
.dropdown {
  float: left;
  overflow: hidden;
}

/* Dropdown button */
.dropdown .dropbtn {
  font-size: 16px;
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit; /* Important for vertical align on mobile phones */
  margin: 0; /* Important for vertical align on mobile phones */
}

/* Add a red background color to navbar links on hover */
.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

/* Add a grey background color to dropdown links on hover */
.dropdown-content a:hover {
  background-color: #ddd;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}


.hero {
    background-image: url('https://media.houseandgarden.co.uk/photos/620bb44d47f811e6e7d15429/16:9/w_2580,c_limit/Annabelle-Holland.jpg');
    /* Gambar latar belakang */
    background-size: cover;
    /* Memastikan gambar menutupi seluruh area */
    background-position: center;
    /* Memusatkan gambar */
    padding: 100px 0;
    text-align: center;
    color: #fff;
    /* Mengubah warna teks agar lebih kontras dengan latar belakang */
}

.hero h1 {
    font-size: 48px;
    /* Ukuran font yang lebih besar */
    margin-bottom: 20px;
}

.hero p {
    white-space: break-spaces;
    padding: 10px;
    margin-bottom: 40px;
    font-size: 18px;
    /* Ukuran font untuk teks lebih besar */
}


.button {
    background-color: #4e4f31;
    color: #fff;
    border: none;
    padding: 12px 25px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #4e4f31;
}

.social-links {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
}

.social-links li {
    margin-right: 15px;
}

.search {
    background-color: #ffffff;
    padding: 30px 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.search form {
    display: flex;
    justify-content: center;
}

.search input[type="text"] {
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 50%;
    margin-right: 10px;
}

.search button[type="submit"] {
    background-color: #4e4f31;
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.search button[type="submit"]:hover {
    background-color: #4e4f31;
}


section.author {
    background-color: #fff;
    padding: 60px 0;
    text-align: center;
}

.container5 {
    max-width: 1350px;
    margin: 0 auto;
    background-color: #ffffff;
}

.row {
    display: flex; /* Menggunakan flexbox */
    justify-content: space-between; /* Menjaga jarak di antara kolom */
}

.col-4 {
    flex: 1; /* Memastikan kolom berbagi lebar yang sama */
    margin: 10px; /* Menambahkan margin untuk jarak antar kolom */
}
/* Style untuk Book Features Section */
/* section.book-features {
    background-color: #fff;
    padding: 60px 0;
    text-align: center;
} */
/* .book-features h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #333;
} */

/* .book-features p {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 40px;
} */

/* .book-features ul {
    display: flex;
    justify-content: space-around;
    padding: 0;
    list-style: none;
} */

/* .book-features li {
    width: 250px;
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    max-width: 300px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
} */

/* .book-features li:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
} */

/* .book-features img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 15px;
}

.book-features h3 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 10px;
}

.book-features p {
    font-size: 1rem;
    color: #777;
} */

@media (max-width: 768px) {
    .book-features ul {
        flex-direction: column;
        gap: 20px;
    }
}

footer {
    background-color: #333;
    color: #fff;
    padding: 15px 0;
    text-align: center;
    position: relative;
    bottom: 0;
    width: 100%;
}
section.search {
    background-color: #f4f4f4;
    padding: 40px 0;
}

.container4 {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: center;
}

.container4 form {
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 25px;
    background-color: #fff;
    padding: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.container4 input[type="text"] {
    border: none;
    outline: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 25px 0 0 25px;
    width: 300px;
}

.container4 button[type="submit"] {
    background-color: #525f35;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 0 25px 25px 0;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.container4 button[type="submit"]:hover {
    background-color: #525f35;
}
/* * {
  box-sizing: border-box;
}

html {
  font-family: sans-serif;
  font-weight: 300;
  color: hsl(0 0% 15%);
}

h2 {
  font-weight: 400;
  margin: 2rem 0 0.25rem 0;
}

h1 {
  position: fixed;
  right: 1rem;
  bottom: 1rem;
  opacity: 0.5;
  margin: 0;
}

p {
  margin: 0;
} */
/* 
body {
  display: grid;
  place-items: center;
  min-height: 100vh;
} */

.ag-format-container {
  width: 1342px;
  margin: 0 auto;
}


.ag-courses_box {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;

  padding: 60px 0;
}
.card-penulis {
  -ms-flex-preferred-size: calc(33.33333% - 30px);
  flex-basis: calc(33.33333% - 30px);

  /* margin: 0 15px 30px; */

  overflow: hidden;

  border-radius: 15px;
}
.penulis-judul {
  position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 24px; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); width: 100%;
}
.penulis-juduls {
  position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: rgb(0, 0, 0); font-size: 24px; font-weight: bold; text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.8); width: 100%;
}
.ag-courses-item_link {
  display: block;
  padding: 30px 20px;
  background-image:url('https://i.pinimg.com/enabled_lo/564x/24/95/63/2495635bcea49ecfc842dd5d2b94d85e.jpg') ;

  overflow: hidden;

  position: relative;
}
.ag-courses-item_link:hover,
.ag-courses-item_link:hover .ag-courses-item_date {
  text-decoration: none;
  color: #17420b;
}
.ag-courses-item_link:hover .ag-courses-item_bg {
  -webkit-transform: scale(10);
  -ms-transform: scale(10);
  transform: scale(10);
}
.ag-courses-item_title {
  min-height: 87px;
  margin: 0 0 25px;

  overflow: hidden;

  font-weight: bold;
  font-size: 30px;
  color: #cbf2c3;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date-box {
  font-size: 18px;
  color: #FFF;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date {
  font-weight: bold;
  color: #f9b234;

  -webkit-transition: color .5s ease;
  -o-transition: color .5s ease;
  transition: color .5s ease
}
.ag-courses-item_bg {
  height: 128px;
  width: 128px;
  background-color: #f9b234;

  z-index: 1;
  position: absolute;
  top: -75px;
  right: -75px;

  border-radius: 50%;

  -webkit-transition: all .5s ease;
  -o-transition: all .5s ease;
  transition: all .5s ease;
}
.ag-courses_item:nth-child(2n) .ag-courses-item_bg {
  background-color: #3ecd5e;
}
.ag-courses_item:nth-child(3n) .ag-courses-item_bg {
  background-color: #e44002;
}
.ag-courses_item:nth-child(4n) .ag-courses-item_bg {
  background-color: #952aff;
}
.ag-courses_item:nth-child(5n) .ag-courses-item_bg {
  background-color: #cd3e94;
}
.ag-courses_item:nth-child(6n) .ag-courses-item_bg {
  background-color: #4c49ea;
}



@media only screen and (max-width: 979px) {
  .ag-courses_item {
    -ms-flex-preferred-size: calc(50% - 30px);
    flex-basis: calc(50% - 30px);
  }
  .ag-courses-item_title {
    font-size: 24px;
  }
}

@media only screen and (max-width: 767px) {
  .ag-format-container {
    width: 96%;
  }

}
@media only screen and (max-width: 639px) {
  .ag-courses_item {
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
  }
  .ag-courses-item_title {
    min-height: 72px;
    line-height: 1;

    font-size: 24px;
  }
  .ag-courses-item_link {
    padding: 22px 40px;
  }
  .ag-courses-item_date-box {
    font-size: 16px;
  }
}
.aesthetic-title {
    font-family: 'Roboto', sans-serif; /* Atau font lainnya yang Anda suka */
    font-size: 3rem; /* Ukuran font yang lebih besar */
    text-align: center; /* Rata tengah */
    color: transparent; /* Mengatur warna teks menjadi transparan untuk efek gradasi */
    background: linear-gradient(90deg, #edf1eb, #dff4c8); /* Gradasi warna hijau */
    -webkit-background-clip: text; /* Memotong latar belakang ke teks */
    background-clip: text; /* Memotong latar belakang ke teks */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Bayangan teks */
    letter-spacing: 2px; /* Jarak antar huruf */
    margin-bottom: 30px; /* Margin bawah untuk jarak dengan elemen lainnya */
}
.penulis{
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
  font-size: 2rem;
  text-align: left !important;
  margin-left: 0 !important;
  padding-left: 20px !important;
  color: #333;
}

/* HALAMAN TENTANG */



.container-tentang {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

.about {
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    margin: 20px 0;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.about h2 {
    font-size: 1.8em;
    color: #388107;
    margin-bottom: 10px;
    border-bottom: 2px solid #115815;
    padding-bottom: 5px;
}

.about p, .about ul {
    margin-bottom: 20px;
    font-size: 1.1em;
}

.about ul {
    list-style-type: square;
    padding-left: 20px;
}

footer {
    background-color: #14330a;
    color: white;
    text-align: center;
    padding: 10px 0;
    margin-top: 20px;
}

footer p {
    font-size: 1em;
}


/* HALAMAN PANDUAN */
.navbar a:hover {
    color: #ffcc00;
}
/* Library Navigation */
.library-nav {
    background: linear-gradient(45deg, #2c5030, #2abb4c);
    padding: 15px 0;
    text-align: center;
    border-bottom: 4px solid #2980b9;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.library-nav ul {
    list-style: none;
    padding: 0;
}

.library-nav ul li {
    display: inline-block;
    margin-right: 25px;
}

.library-nav ul li a {
    font-size: 1.1em;
    font-weight: bold;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background 0.3s, transform 0.3s;
}

.library-nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}


</style>