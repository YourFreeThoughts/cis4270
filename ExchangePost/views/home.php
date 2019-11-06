<?php require('views/guitarShopHeader.php'); ?>
<main>
    <section>
        <h1>Admin Login</h1>
        <div id="content">
            <h2>Under Construction</h2>
        </div>
        <form action="." method="post">
        <input type="hidden" name="ctlr" value="home">
        <input type="hidden" name="action" value="login">
        <label>FirstName:</label>
        <input type="text" name="firstName">
        <label>&nbsp;Password:</label>
        <input type="text" name="password">
        <br><br>
        <input type="submit" value="Login as Administrator">  
    </form>

    </section>
</main>
<?php require('views/guitarShopFooter.php');
