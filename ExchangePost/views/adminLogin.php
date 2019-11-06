
<?php require('views/guitarShopHeader.php'); ?>
<main>
    <section>
        <h1>Admin Login</h1>
        <div id="content">
            <h2>Under Construction</h2>
        </div>
        <form action="." method="post">
        <input type="hidden" name="ctlr" value="admin">
        <input type="hidden" name="action" value="formSubmission">
        <label>FName:</label>
        <input type="firstName" name="firstName">
        <label>LName:</label>
        <input type="lastName" name="lastName">
        <label>&nbsp;Password:</label>
        <input type="password" name="password">
        <label>Phone:</label>
        <input type="text" name="phone">
        <label>Email:</label>
        <input type="text" name="email">
        <br><br>
        <input type="submit" value="Login as Administrator">  
    </form>
    </section>
    
</main>

<?php
require('views/guitarShopFooter.php');