<?php
// source: C:\xampp2\htdocs\RTSoft\p1\app\presenters/templates/Homepage/default.latte

use Latte\Runtime as LR;

class Templateb3fb59ed04 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['project'])) trigger_error('Variable $project overwritten in foreach on line 12');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Název</th>
                        <th>Datum odevzdání</th>
                        <th>Typ</th>
                        <th>Webový projekt</th>
                        <th>Akce</th>
                    </tr>
<?php
		$iterations = 0;
		foreach ($projects as $project) {
?>
                    <tr>
                        <td><?php echo LR\Filters::escapeHtmlText($project->id) /* line 14 */ ?></td>
                        <td><?php echo LR\Filters::escapeHtmlText($project->name) /* line 15 */ ?></td>
                        <td>
                            <?php echo LR\Filters::escapeHtmlText(date("d.m Y", strtotime($project->date))) /* line 17 */ ?>

                        </td>
                        <td><?php echo LR\Filters::escapeHtmlText($project->type) /* line 19 */ ?></td>
                        <td>
                            <?php echo LR\Filters::escapeHtmlText($project->is_web) /* line 21 */ ?>

                        </td>
                        <td>
                            <a class="btn btn-dark btn-sm" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:edit", [$project->id])) ?>">✎ Upravit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?php
			echo LR\Filters::escapeHtmlAttr($project->id) /* line 25 */ ?>">✘ Smazat</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="delete<?php echo LR\Filters::escapeHtmlAttr($project->id) /* line 28 */ ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Potvrdit smazání</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                Projekt <?php echo LR\Filters::escapeHtmlText($project->name) /* line 38 */ ?> (ID: <?php
			echo LR\Filters::escapeHtmlText($project->id) /* line 38 */ ?>)
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušit</button>
                              <a class="btn btn-danger" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:delete", [$project->id])) ?>">Smazat</a>
                            </div>
                          </div>
                        </div>
                     </div> 
<?php
			$iterations++;
		}
?>
                </table>
                    <a class="btn btn-dark btn-sm" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:create")) ?>">Vytvořit projekt</a>
<?php
	}

}
