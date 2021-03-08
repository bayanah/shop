<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Add Category</h1>            
            <?= validation_errors() ?>
            <?= form_open(base_url('home/add_category')) ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title') ?>">                            
            </div>
            <button type="submit" class="btn btn-success">Add new</button>                    
            <?= form_close() ?>
        </div>
    </div>
</div>
