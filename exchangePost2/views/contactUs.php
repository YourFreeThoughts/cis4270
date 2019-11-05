<?php require('views/guitarShopHeader.php'); ?>
<main>
    <section>
      <style>
        input{
          float:right;
          width:200px;
        }
        </style>

        <h1>Login</h1>
        <p> Please enter the following information. </p>

    <form style="margin-top:25px;margin-bottom:75px;" action="views/success.php" method="post">
        <input type="hidden" name="ctlr" value="home" />
        <input type="hidden" name="action" value="formSubmission" />

        <p>First Name: <input type="text" name="firstName"></p>
        <p>Last Name: <input type="text" name="lastName"></p>
        <p>Email Address: <input type="text" name="email"></p>
        <p>Phone Number: <input type="text" name="phone"></p>
        <br>
        <p><input type="submit" value="Submit"></p>
    </form>

    </section>

</main>
<?php
require('views/guitarShopFooter.php');
