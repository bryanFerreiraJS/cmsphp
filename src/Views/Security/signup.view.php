<?php if (\Vendor\App\MessageTrigger::hasMessage()) : ?>
    <?= \Vendor\App\MessageTrigger::getMessage(); ?>
<?php endif; ?>

<h1 class="text-center mb-5">Sign-up to create account</h1>

<form method="post" class="mx-auto" style="max-width: 400px">

    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="firstName" id="firstName" required/>
        <label for="firstName">First Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="lastName" id="lastName" required/>
        <label for="lastName">Last Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control" name="email" id="email" required/>
        <label for="email">Email</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" name="password" id="password" required/>
        <label for="password">Password</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" name="password_check" id="password_check" required/>
        <label for="password_check">Verify Password</label>
    </div>

    <input type="submit" class="btn btn-success w-100" value="Sign-up"/>
</form>