<?php $this->layout('layout', ['title' => 'register']) ?>

<div class="panel panel-default">
    <div class="panel-heading">Register</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form class="form-horizontal" action="/register">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="email">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="email">Repeat password</label>
                        <input type="password" class="form-control" name="password" placeholder="Repeat password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="register">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>