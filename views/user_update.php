<?php echo validation_errors(); ?>
<?php echo $this->upload->display_errors('<div class="alert alert-error">', '</div>'); ?>
<?php echo form_open_multipart(); ?>
    <div>
        <?php echo form_label('Project', 'project_id'); ?>
        <?php echo form_dropdown('project_id', $arrProjects, set_value('publication_id')); ?>
    </div>
    <div>
        <?php echo form_label('Name', 'name'); ?>
        <?php echo form_input('Name', set_value('name')); ?>
    </div>
    <div>
        <?php echo form_label('Nickname', 'nickname'); ?>
        <?php echo form_input('nickname', set_value('nickname')); ?>
    </div>
    <div>
        <?php echo form_label('Cover scan', 'issue_cover'); ?>
        <?php echo form_upload('issue_cover'); ?>
    </div>
    <div>
        <?php echo form_submit('save', 'Save'); ?>
    </div>
<?php echo form_close(); ?>