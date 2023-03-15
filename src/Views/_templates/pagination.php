<?php if($this->data['pagination']['total']>1){?>
    <nav>
        <ul class="pagination">
            <?php $page = !isset($this->get['page']) ? 0 : $this->get['page'];?>
            <?php for($i=1; $i<=$this->data['pagination']['total']; $i++){?>
                <li class="page-item <?php if( ($page==0 && $i==1) || ( $page==$i ) ){?>active<?php }?>">
                    <?php if($i==1){?>
                        <a class="page-link" href="<?=$this->printUrl(['page' => 0])?>"><?=$i?></a>
                    <?php }else{?>
                        <a class="page-link" href="<?=$this->printUrl(['page' => $i])?>"><?=$i?></a>
                    <?php }?>
                </li>
            <?php }?>
        </ul>
    </nav>
<?php }?>