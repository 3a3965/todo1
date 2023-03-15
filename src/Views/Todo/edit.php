<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="text-center">Редактирование задачи</h3>
            <div class="add-form">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="/todo/update/<?=$this->data['id']?>/" method="post">
                            <div class="mb-3">
                                <label class="form-label">Описание задачи</label>
                                <textarea class="form-control" name="task" id="task" rows="3"><?=$this->data['task']?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Выполнение</label>
                                <select class="form-select" name="status">
                                    <option value="0">Нет</option>
                                    <option value="1" <?=$this->data['status'] ? 'selected="selected"' : ''?>>Да</option>
                                </select>
                            </div>
                            <input type="hidden" name="adminEdited" id="adminEdited" value="0">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
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

<script>
    window.addEventListener('load', function(){
        const adminEdited = document.querySelector('#task');
        const startValue = adminEdited.value;
        adminEdited.onchange = () => {
            const adminEditedInput = document.querySelector('#adminEdited');
            if( startValue != adminEdited.value) {
                adminEditedInput.value = 1;
            }else{
                adminEditedInput.value = 0;
            }
        }
    });
</script>