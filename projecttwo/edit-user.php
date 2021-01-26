<?php require_once('./includes/header.php'); ?>
    <div class="container">
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                header("Location:index.php");
            }else{
                $id = $_POST['val'];
                $sql = 'SELECT * FROM users WHERE user_id = :id';
                $stmt = $pdo->prepare($sql);
                 $stmt->execute([
                     ':id' => $id
                ]);
                if($user = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $user_id = $user['user_id'];
                    $user_name = $user['user_name'];
                    $user_email = $user['user_email'];
                    $user_password = $user['user_password'];
                }
            }
        ?>
        <h2 class="pt-4">User Update</h2>
        
         <?php
            if(isset($_POST['edit_me'])){
                $user_id=$_POST['update_id'];
                $user_name=trim($_POST['user_name']);
                $user_email=trim($_POST['user_email']);
                $user_password=trim($_POST['user_password']);
                if(empty($user_name)||empty($user_email)||empty($user_password)){
                    echo "<div class='alret alert-danger'>Field can't be blank!</div>";
                }else{
                    $sql = 'UPDATE users SET user_name = :name, user_email= :email, user_password = :password WHERE user_id = id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':name'=> $user_name,
                        ':email'=> $user_email,
                        ':password'=> $user_password,
                        ':id' => $user_id
                    ]);
                    header("Location: index.php");
                }
            }
         ?>
    
     
        <form class="py-2" action="edit-user.php" autocomplete="off">
            <input type="hidden" value="<?php echo $user_id; ?>" name="update_id" />
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" value="<?php echo $user_name; ?>" class="form-control" id="username" placeholder="Desired username">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" value="<?php echo $user_email; ?>" class="form-control" id="email" placeholder="Desired email address">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" value="<?php echo $user_password; ?>" class="form-control" id="password" placeholder="Enter new password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>


<?php require_once('./includes/footer.php'); ?>