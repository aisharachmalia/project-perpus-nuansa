
<style>
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    color: #333;
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

/* Style untuk Book Features Section */
section.book-features {
    background-color: #fff;
    padding: 60px 0;
    text-align: center;
}

.container5 {
    max-width: 900px;
    margin: 0 auto;
}

.book-features h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #333;
}

.book-features p {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 40px;
}

.book-features ul {
    display: flex;
    justify-content: space-around;
    padding: 0;
    list-style: none;
}

.book-features li {
    width: 250px;
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    max-width: 300px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.book-features li:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
}

.book-features img {
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
}

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


</style>