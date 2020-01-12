<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="<%= BASE_URL %>favicon.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
    <title>todo</title>
    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
 }

 body {
  background-color: #E5E5E5;
  font-family: 'Source Sans Pro', sans-serif;
  height: 100vh;
 }

 nav {
  display: flex;
  flex-direction: column;
  justify-content: center;
  width: 147px;
  height: 100vh;
  background-color: #353541;
  position: fixed;
}

nav a {
  color: #C4C4C4;
  font-size: 16px;
  line-height: 20px;
  display: flex;
  flex-direction: column;
  text-align: center;
  margin-top: 10px;
  padding-top: 10px;
  text-decoration: none;
}

nav a:active{
  color: #C4C4C4;
  background: #18181E;
  padding-bottom: 10px;
}

.nav-icons {
  width: 46px;
  height: 46px;
  margin: 0 auto;
}

.user-name {
  font-size: 16px;
line-height: 20px;
color: #E1E1E1;
text-align: center;
} 

.main {
margin-left: 147px;
}

.main-container {
  max-width: 500px;
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
  margin: auto;
  height: 100vh;
}

.logo {
  width: 150px;
  height: auto;

}
.main-container h1 {
  text-align: center;
  font-weight: 600;
  margin-top: 20px;
  color: #353541; 
  font-size: 24px; 
}

@media screen and (min-width: 1350px) {

.main-container {
  max-width: 600px;
}

.logo {
  width: 200px;

}
.main-container h1 {
  font-size: 28px; 
}
}
    </style>
</head>

<body>
        <nav>
            <div>
                
            </div>
          <a href="/"><img src="https://res.cloudinary.com/dcbuctwnl/image/upload/v1578838073/zayavki_gdni1n.svg" class="nav-icons"/>Заявки</a>
          <a href="/"><img src="https://res.cloudinary.com/dcbuctwnl/image/upload/v1578838073/zakaz_he6heb.svg" />Заказы</a>
          <a href="/"><img src="https://res.cloudinary.com/dcbuctwnl/image/upload/v1578838073/klient_ktdx9u.svg" />Клиенты</a>
          <a href="employee/index"><img src="https://res.cloudinary.com/dcbuctwnl/image/upload/v1578838073/sotrudniki_cxrwwp.svg" />Сотрудники</a>
          <a href="/"><img src="https://res.cloudinary.com/dcbuctwnl/image/upload/v1578838073/otchet_vkim4e.svg" />Отчет</a>
        </nav>

        <section class="main">
            <div class="main-container">
            <div class="logo-container">
                <img src="https://res.cloudinary.com/dcbuctwnl/image/upload/v1578838499/logo_vzyses.png" alt="company logo" class="logo">
            </div>
            <h1>Вы на сайте кейтеринг услуг компании "Хорошая Кухня"</h1>
        </div>
        </section>


</body>

</html>