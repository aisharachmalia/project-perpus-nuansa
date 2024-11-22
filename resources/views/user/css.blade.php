<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

<style>
body {
font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    color: #333;
}
html, body {
  height: 100%;  /* Pastikan html dan body mengambil tinggi penuh */
}

body {
  display: flex;
  flex-direction: column; /* Mengatur konten agar vertikal */
}

.container {
  flex: 1; /* Konten mengisi sisa ruang yang tersedia */
}

footer {
  background-color: #333;
  color: white;
  padding: 20px;
  text-align: center;
  margin-top: auto; /* Footer selalu di bawah */
}

body {
        
    }
/* General Header Styling */
header {
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
    background-color: rgba(43, 101, 28, 0.79);
    padding: 10px 0;
    transition: background 0.3s ease;
    height: 80px;
    display: flex;
    align-items: center;
}
.dropdown-menu {
    
    position: absolute;
    z-index: 1050;
    background-color: rgba(43, 101, 28, 0.71);
}
.dropdown-menu {
    z-index: 1050;
}
.dropdown-menu {
    display: none; /* Prevents display issues */
}
/* Mengatur warna teks pada dropdown */
.dropdown-menu a.dropdown-item {
    color: black !important; /* Mengubah warna teks menjadi hitam */
}

.dropdown-menu a.dropdown-item:hover {
    background-color: #f0f0f0; /* Mengatur warna latar saat di-hover */
    color: black; /* Warna tetap hitam saat di-hover */
}

.dropdown-menu.show {
    display: block; /* Shows dropdown when active */
}

.header-login a {
    display: block !important;
    color: white !important;
}
.login-section a {
    color: white;
}

header.sticky {
    background: rgba(104, 148, 111, 0.7);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Logo Styling */
.logo {
    flex: 0 0 auto; /* Prevents the logo from stretching */
}

.logo img {
    width: 120px;
    height: auto;
    max-height: 90%;
}

/* Centered Navbar Styling */
nav {
    flex-grow: 1; /* Allows nav to occupy space in the middle */
    display: flex;
    justify-content: center; /* Center the navigation menu */
}

nav ul {
    list-style: none;
    display: flex;
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

/* Login Button */
.header-login {
    flex: 0 0 auto; /* Prevents the login section from expanding */
    display: flex;
    justify-content: flex-end;
}

/* Responsive Design */
@media (max-width: 768px) {
    /* Hide nav items and use a toggle menu for mobile screens */
    nav ul {
        display: none; /* Hide nav items by default */
        flex-direction: column;
        background-color: rgba(79, 91, 81, 0.9);
        position: absolute;
        top: 80px;
        right: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
    }

    nav ul.show {
        display: flex; /* Show nav items when toggled */
    }

  
}

.hero {
  background-image: url('{{ asset('assets/images/bg/hero-perpus.jpg') }}');

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
.hero p {
    white-space: break-spaces;
    padding: 10px;
    margin-bottom: 40px;
    font-size: 18px;
    /* Ukuran font untuk teks lebih besar */
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.container {
max-width: 1200px;
margin: 0 auto;
display: flex;
align-items: center;
justify-content: space-between;
}
.containers {
max-width: 1300px;
margin-left: 95px;
display: flex;
align-items: center;
justify-content: space-between;
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

@media (max-width: 768px) {
    .book-features ul {
        flex-direction: column;
        gap: 20px;
    }
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
  position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: rgb(0, 0, 0); font-size: 24px; font-weight: bold; text-shadow: 2px 2px 4px rgba(240, 233, 233, 0.8); width: 100%;
}
.penulis-judulz {
  position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: rgb(255, 255, 255); font-size: 24px; font-weight: bold;  width: 100%;
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
.empty-data-message {
            text-align: center;
            color: #888;
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 40px;
        }

.carousel {
  width: 100%;
  /* overflow-x: scroll; */
  padding: 30px;
  padding-top: 80px;
  position: relative;
  box-sizing: border-box;
}

.carousel__container {
  white-space: nowrap;
  margin: 70px 0px;
  padding-bottom: 10px;
  display: inline-block;
}

.categories__title {
  color: rgb(77, 55, 102);
  font-size: 28px;
  position: absolute;
  padding-left: 30px;
}

.carousel-items {
  width: 200px;
  height: auto; /* Set height to auto to fit content */
  border-radius: 20px;
  overflow: hidden;
  margin-right: 10px;
  margin-top: 70px;
  display: inline-block;
  cursor: pointer;
  transition: 500ms all; /* Adjusted to faster transition */
  transform-origin: center left;
  position: relative;
}

.carousel-item:hover ~ .carousel-items {
  transform: translate3d(100px, 0, 0);
}

.carousel__container:hover .carousel-items {
  opacity: 0.3;
}

.carousel__container:hover .carousel-items:hover {
  transform: scale(1.2); /* Reduce scale to prevent overflow */
  opacity: 1;
}

.carousel-item__img {
  width: 100%; /* Ensure the image fits the container */
  height: 300px; /* Set a fixed height */
  object-fit: cover;
}

.carousel-item__details {
  background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0) 100%);
  font-size: 14px; /* Increase font size for readability */
  opacity: 0;
  transition: 300ms opacity; /* Faster transition */
  padding: 10px;
  position: absolute;
  bottom: 0; /* Position at the bottom */
  left: 0;
  right: 0;
}

.carousel-item__details:hover {
  opacity: 1;
}

.carousel-item__details span {
  font-size: 1rem;
  color: #2ecc71;
}

.carousel-item__details .controls {
  padding-top: 5px; /* Adjust padding if needed */
}

.carousel-item__details .carousel-item__details--title,
.carousel-item__details--subtitle {
  color: #fff;
  margin: 5px 0;
  white-space: normal; /* Allow wrapping */
  overflow: hidden;
  text-overflow: ellipsis; /* Ellipsis for long titles */
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

#btn-back-to-top {
  position: fixed;
  bottom: 20px;
  right: 20px;
  border-radius: 50%;
  display: none;
}
</style>