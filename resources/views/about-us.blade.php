@extends('layout')

@section('title', ' about-us')

@section('content')
<style>

.about-section{

padding:100px 0;

}

/* TITLE */

.about-title{

font-size:60px;
font-weight:700;
color:#111;

}

/* TEXT */

.about-text{

font-size:18px;
color:#666;
line-height:1.8;

}

/* GRAY */

.gray{

color:#888;

}

/* IMAGE */

.about-img{

border-radius:10px;
transition:0.5s;

}

.about-img:hover{

transform:scale(1.05);

}


/* LUXURY BUTTON */

.btn-luxury{

background:#333;
border:none;
color:white;
padding:14px 40px;
margin-top:20px;
transition:0.4s;
display:inline-block;
text-decoration:none;
border-radius:30px;
font-weight:600;

}

.btn-luxury:hover{

background:#888;
color:white;
transform:translateY(-3px);

}


/* ANIMATION */

.fade-in{

opacity:0;
transform:translateY(30px);
transition:1s;

}

.fade-in.show{

opacity:1;
transform:translateY(0);

}

</style>



<section class="about-section container">

<div class="row align-items-center">


<!-- IMAGE -->

<div class="col-md-6 fade-in">

<img src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?q=80&w=800" class="img-fluid about-img">

</div>



<!-- TEXT -->

<div class="col-md-6 fade-in">

<h1 class="about-title">

About <span class="gray">7etta</span>

</h1>


<p class="about-text">

7etta is more than a fashion brand it is a symbol of elegance, confidence, and modern luxury.

We create exclusive collections designed for individuals who appreciate premium quality, timeless design, and powerful presence.

Every piece reflects our commitment to excellence, crafted to elevate your lifestyle and express your identity.

</p>


<p class="about-text">

Our vision is to redefine online fashion by offering a unique experience where sophistication meets innovation.

Welcome to 7etta — Where Luxury Meets Lifestyle.

</p>


<!-- BUTTON -->

<a href="collection.php" class="btn-luxury">

Discover Collection →

</a>


</div>


</div>

</section>



<script>

window.addEventListener("scroll", function(){

document.querySelectorAll(".fade-in").forEach(function(el){

var position = el.getBoundingClientRect().top;
var screen = window.innerHeight;

if(position < screen - 100){

el.classList.add("show");

}

});

});

</script>
@endsection