<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="text-center">Авторизация</h3>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="/auth/authorizeUser/" method="post">
                        <div class="mb-3">
                            <label  class="form-label">Логин</label>
                            <input type="text" class="form-control"  name="login">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" class="form-control"  name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Вход</button>
                        <?php if($this->getPageError()){ ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?=$this->getPageError()?>
                            </div>
                        <?php }elseif($this->getPageSuccess()){?>
                            <div class="alert alert-success mt-3" role="alert">
                                <?=$this->getPageSuccess()?>
                            </div>
                        <?php }?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>