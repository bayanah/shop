<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Products</h1>
        </div>
    </div>

    <div class="row">
        <?php
        foreach ($items as $item) {
            ?>
            <div class="col-4">
                <div class="card">
                    <img class="card-img-top" src="<?= base_url() . '/uploads/' . $item->image ?>" alt="<?= $item->title ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item->title ?></h5>
                        <p class="card-text"><?= $item->price ?></p>
                        <a href="#" class="btn btn-primary">Add to bag</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>        
    </div>    
    <div class="row">
        <div class="col-12">
            <?= $pagination ?>
        </div>
    </div>
</div>