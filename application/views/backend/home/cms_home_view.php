<div class="row">
    <?php if($this->session->flashdata('error')): ?>
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-ban"></i> <?php echo $this->session->flashdata('error') ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('notice')): ?>
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-warning"></i> <?php echo $this->session->flashdata('notice') ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('success')): ?>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('success') ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-12"></div>
</div>