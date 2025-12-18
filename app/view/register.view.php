

<form  method="post" enctype="multipart/form-data" id="regForm">
     <div id="msg"></div>
    <span class="error"></span><br>
    <input type="text" name="firstname" id="fname" placeholder="enter first name"><br>
    
    <span class="error"></span><br>
    <input type="text" name="lastname" id="lname" placeholder="enter last name"><br>
    
    <span class="error"></span><br>
    <input type="text" name="email" id="email" placeholder="enter your email"><br>
    
    <span class="error"></span><br>
    <input type="text" name="dept" id="dept" placeholder="enter your desire department"><br>
    
    <span class="error"></span><br>
    <input type="radio" name="gender" value="male">male
    <input type="radio" name="gender" value="female">female<br>
    
    <span class="error"></span><br>
    <input type="password" name="password" id="password" placeholder="enter password"><br>

    <span class="error"></span><br>
    <input type="file" name="img"><br>    

    <button type="submit">submit</button>
</form>

<script src="<?= BASE_URL ?>/js/form.js"></script>