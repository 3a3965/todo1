<div class="container">
    <div class="row">
        <div class="col">
            <?php if( !$this->user->isAdmin ){ ?>
                <a href="/auth/" class="btn btn-light" class="btn btn-primary">
                    Авторизация
                </a>
            <?php }else{?>
                <a href="/auth/unAuthorizeUser/" class="btn btn-light" class="btn btn-primary">
                    Выход
                </a>
            <?php }?>

            <h3 class="text-center">Лист задач</h3>
            <div class="row">
                <div class="col">
                    <?php if( !empty($this->data['data']) && is_array($this->data['data'])){?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><a href="<?=$this->printUrl($this->makeSort('name'), ['order'])?>">Имя</a></th>
                                <th scope="col"><a href="<?=$this->printUrl($this->makeSort('email'), ['order'])?>">Email</a></th>
                                <th scope="col">Задача</th>
                                <th scope="col"><a href="<?=$this->printUrl($this->makeSort('status'), ['order'])?>">Выполнена</a></th>
                                <th scope="col">Редактировалась администратором</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($this->data['data'] as $v){?>
                                <tr>
                                    <th scope="row"><?=$v['id']?></th>
                                    <td>
                                        <?=$v['name']?>
                                    </td>
                                    <td><?=$v['email']?></td>
                                    <td>
                                        <?php if( $this->user->isAdmin ){ ?>
                                            <a href="/todo/edit/<?=$v['id']?>/"><?=$v['task']?></a>
                                        <?php }else{?>
                                            <?=$v['task']?>
                                        <?php }?>
                                    </td>
                                    <td><?=$v['status'] ? "Да" : "Нет"?></td>
                                    <td><?=$v['adminEdited'] ? "Да" : "Нет"?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>

                        <?php $this->loadView('_templates/pagination.php');?>

                    <?php }else{?>
                        <p>Пока лист задач пуст</p>
                    <?php }?>
                </div>
            </div>
            <hr>
            <h3 class="text-center ">Добавить новую задачу</h3>
            <div class="add-form">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="/todo/add/" method="post">
                            <div class="mb-3">
                                <label  class="form-label">Имя</label>
                                <input type="text" class="form-control"  name="name">
                            </div>
                            <div class="mb-3">
                                <labelclass="form-label">E-mail</label>
                                <input type="email" class="form-control"  name="email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Опишите задачу</label>
                                <textarea class="form-control" name="task" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Создать</button>
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
</div>