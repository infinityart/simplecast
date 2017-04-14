<?php $this->layout('layout', ['title' => 'login']) ?>

<div class="panel panel-default">
    <div class="panel-heading">Login</div>
    <div class="panel-body">
        <form action="/login">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" name="register">Login</button>
        </form>
    </div>
</div>