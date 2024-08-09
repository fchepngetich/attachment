/************************************************business****/
@import url("https://fonts.googleapis.com/css2?family=Rubik+Mono+One&family=Rubik:wght@400;600;800&display=swap");

a{color: #d67900; }
html, body {
  min-height: 100%;
}

.navbar {
    background-color: #041e42 !important;
    margin-bottom: 0;
    border: none;
    padding: 15px;
    border-radius: 0;
  }
  #business-card img{
max-width: 100px;
  }
  .navbar-light .navbar-nav .nav-link{color:#fff !important; padding-right: 15px; font-weight: 600;}


  .navbar a {
    color: #fff;
  }

  .navbar .dropdown-menu a {
    color: #000;
  }


  * {
    margin: 0;
    padding: 0;
  }
  body {
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    font-family: 'Rubik', sans-serif;
    overflow-x: hidden;
  }
  .search-result{
    min-height: 40vh;

  }
  #filter{
    box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;
    height: 100%;
  
  }
  .card-body{
    box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;

  }
  .card{
    border: none !important;
  }
  .button a{
    color: #fff !important;
    text-decoration: none !important;
  }
 button .button{
  background-color: #041e42 !important;
 }

  /* banner image */
  #banner {
    display: flex;
    align-items: center;
    justify-content: center;
    max-width: 100vw;
    min-height: 40vh;
    background-image: url("/assets/images/back3.jpg");
    background-size: cover;
    background-repeat: repeat;
    background-attachment: scroll;
    background-position: center;
    background-color: rgba(0, 0, 0, 0.6);
    background-blend-mode: multiply;
  }

  #banner h1 {
    font-weight: 700;
    padding: 10px;
    color: white;
    max-width: fit-content;
  }

  /*#section_one {
    display: flex;
    gap: 20px;
  }*/

  #business-filter {
    background-color: white;
    height: fit-content;
    padding: 30px;
    border: none;
    border-radius: 8px;
    min-width: 16%;
  }

  .button {
    width: 100%;
  }

  .button button {
    width: 100%;
    background-color: #d67900;
    color: white;
    border-radius: 0;
    padding: 10px;
  }

  .button button:hover,
  .button button:focus {
    background-color: #041e42;
    color: white;
  }
  .fa-brands{
    font-size: 18px;
  }
  #reset-btn {
    border: #d67900 1px solid;
    background-color: #d6790077;
    color: black;
  }

  #reset-btn:hover,
  #reset-btn:focus {
    background-color: #041e42;
    border: none;
    color: white;
  }

 

  .business-link {
    text-decoration: none;
  }

  .category-link {
    text-decoration: none;
  }

  /* business cards */
  .business-link:hover .card {
    transform: scale(1.02);
    box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.185);
  }

  .card-title {
    gap: 30px;
  }

  /* Styles for smartphones */
  @media screen and (max-width: 599px) {
    #section_one {
      flex-direction: column;
    }

    .card-title {
      gap: 0;
    }
  }

  /* Styles for tablets */
  @media screen and (min-width: 600px) and (max-width: 1024px) {
    #section_one {
      flex-direction: column;
    }
  }

  /* Styles for bootstrap medium */
  @media screen and (max-width: 768px) {
    .card-title {
      gap: 0;
    }
  }
  /**********************************************************Footer*/
  .footer {
    background-color: #041e42;
    color: white;
  }
  .footer_media_links a {
    color: white;
    text-decoration: none;
    font-size: 1.5rem;
    padding: 5px;
  }
  .quick-links p a{
    color: #fff;
  }
  .footer_media_links a:hover,
  .footer_media_links a:focus {
    color: #d67900;
  }
  #footer_divider {
    background-color: #efefef;
    height: 2px;
  }
  #footer_info h5 {
    text-decoration: underline;
    font-weight: 800;
  }
  
  #footer_info a {
    color: white;
    text-decoration: none;
  }
  #footer_info a:hover,
  #footer_info a:focus {
    color: #d67900;
  }
  
  #footer_info {
    gap: 30px;
  }
  
  /* Styles for tablets */
  @media screen and (max-width: 768px) {
    #footer_info {
      gap: 30px;
    }
  }
  .card-link{
    position: absolute;
    font-size: 12px !important;
    text-transform: uppercase;
    text-align: center;

  }
.search-cats {max-height: 100px; overflow:scroll;}
  .social-links a{
    margin: 20px;
    color:#041e42 !important;
  }
  .contact-links p{
    margin-bottom: .3rem;
    font-size: 13px;
  }
  .social_links a i{
    font-size: 12px;
  }
  iframe{
    width: 100% !important;
    height: 200px !important;
  }